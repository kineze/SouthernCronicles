<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeVueComponent extends Command
{
    protected $signature = 'make:vue 
        {name : Component path, e.g. web/PartnerWithUs or Admin/Users/List}
        {--script-setup : Use <script setup> syntax}
        {--ts : Use TypeScript (lang="ts")}
        {--style=css : Style language (css|scss|postcss|less|stylus)}
        {--force : Overwrite if the file exists}';

    protected $description = 'Create a Vue Single File Component in resources/js/components and auto-register it in resources/js/app.js';

    public function handle(Filesystem $files)
    {
        $rawName  = str_replace('\\', '/', trim($this->argument('name'), '/'));
        $segments = array_values(array_filter(explode('/', $rawName), fn($x) => $x !== ''));
        $fileBase = array_pop($segments);

        $studly = Str::studly($fileBase);
        $kebab  = Str::kebab($studly);

        $relativeDir = implode('/', $segments); // e.g. "admin", "web/news", "marketing/reports"
        $basePath    = resource_path('js/components');
        $targetDir   = $relativeDir ? $basePath . DIRECTORY_SEPARATOR . $relativeDir : $basePath;
        $targetPath  = $targetDir . DIRECTORY_SEPARATOR . $studly . '.vue';

        $useScriptSetup = (bool)$this->option('script-setup');
        $useTs          = (bool)$this->option('ts');
        $style          = strtolower($this->option('style') ?? 'css');
        $styleLang      = in_array($style, ['css','scss','postcss','less','stylus']) ? $style : 'css';

        if ($files->exists($targetPath) && !$this->option('force')) {
            $this->error("File already exists: " . Str::after($targetPath, base_path() . DIRECTORY_SEPARATOR));
            return self::FAILURE;
        }

        if (!$files->isDirectory($targetDir)) {
            $files->makeDirectory($targetDir, 0755, true);
        }

        $sfc = $this->buildSfc($studly, $kebab, $useScriptSetup, $useTs, $styleLang);
        $files->put($targetPath, $sfc);

        $rel = Str::after($targetPath, base_path() . DIRECTORY_SEPARATOR);
        $this->info('Created: ' . $rel);
        $this->line("Component name: <{$kebab}> (file: {$studly}.vue)");

        // Use first segment as the group name (generic, not limited to admin/web)
        $group = $this->inferGroupFromSegments($segments); // e.g. "admin", "web", "marketing", "dashboard", etc.
        $this->updateAppJs($files, $relativeDir, $studly, $kebab, $group);

        return self::SUCCESS;
    }

    protected function buildSfc(string $studly, string $kebab, bool $scriptSetup, bool $ts, string $styleLang): string
    {
        $langAttr       = $ts ? ' lang="ts"' : '';
        $styleLangAttr  = $styleLang !== 'css' ? ' lang="'.$styleLang.'"' : '';

        if ($scriptSetup) {
            return <<<VUE
<template>
  <div class="{$kebab}">
    <!-- {$studly} component -->
  </div>
</template>

<script setup{$langAttr}>
import { ref } from 'vue'
// const count = ref(0)
</script>

<style scoped{$styleLangAttr}>
.{$kebab} { }
</style>
VUE;
        }

        return <<<VUE
<template>
  <div class="{$kebab}">
    <!-- {$studly} component -->
  </div>
</template>

<script{$langAttr}>
import { defineComponent } from 'vue'

export default defineComponent({
  name: '{$studly}',
  components: {},
  props: {},
  setup() {
    return {}
  }
})
</script>

<style scoped{$styleLangAttr}>
.{$kebab} { }
</style>
VUE;
    }

    protected function inferGroupFromSegments(array $segments): string
    {
        // Use first segment if present; otherwise fallback to "components"
        return $segments ? strtolower($segments[0]) : 'components';
    }

    protected function updateAppJs(Filesystem $files, string $relativeDir, string $studly, string $kebab, string $group): void
    {
        $appJs = resource_path('js/app.js');
        if (!$files->exists($appJs)) {
            $this->warn('Skipped app.js update: resources/js/app.js not found.');
            return;
        }

        $contents = $files->get($appJs);

        $importPath      = './components' . ($relativeDir ? '/' . str_replace('\\', '/', $relativeDir) : '') . '/' . $studly . '.vue';
        $importLine      = "import {$studly} from '{$importPath}';";
        $registrationLine= "  .component('{$kebab}', {$studly})";

        if (str_contains($contents, $importLine) && str_contains($contents, $registrationLine)) {
            $this->info('app.js already has import & registration; no changes made.');
            return;
        }

        $updated = $this->insertImport($contents, $importLine, $group);
        $updated = $this->insertRegistration($updated, $registrationLine, $group);
        $updated = preg_replace("/\n{3,}/", "\n\n", $updated);

        if ($updated !== $contents) {
            $files->put($appJs, $updated);
            $this->info('Updated: resources/js/app.js (import & registration added)');
        } else {
            $this->warn('Could not find anchors in app.js; no change written.');
        }
    }

/**
 * APPEND import to the BOTTOM of the group’s import block.
 * If the group section is missing, create it and place the import
 * AFTER the last existing components section (not just after its marker).
 */
protected function insertImport(string $contents, string $importLine, string $group): string
{
    $groupMarker = '/^\/\/\s*' . preg_quote($group, '/') . '\s*components\s*$/im';
    $anyMarker   = '/^\/\/\s*([a-z0-9_-]+)\s*components\s*$/im';
    $constAppRx  = '/^\s*const\s+app\s*=\s*createApp\(\{\}\);/m';

    // If the group's section exists → append to its bottom
    if (preg_match($groupMarker, $contents, $m, PREG_OFFSET_CAPTURE)) {
        return $this->appendImportIntoSection($contents, $m[0][1], $importLine, [$anyMarker, $constAppRx]);
    }

    // Otherwise, create a new section.
    // Prefer to insert it AFTER the entire last components section (not just after its marker).
    $insertionPos = null;

    // 1) After the last "// * components" SECTION (end of that section)
    if (preg_match_all($anyMarker, $contents, $all, PREG_OFFSET_CAPTURE)) {
        $lastMarker = end($all[0]);                 // [0] => matched text, [1] => offset
        $lastOffset = $lastMarker[1];
        // compute end of that section (next components marker OR const app)
        $sectionEnd = $this->findSectionEnd($contents, $lastOffset, [$anyMarker, $constAppRx]);
        $insertionPos = $sectionEnd;                // <-- place AFTER previous section
    }

    // 2) After the top-level import block (fallback if no components marker exists at all)
    if ($insertionPos === null && preg_match('/^(?:\s*import\s.+?;\s*)+/m', $contents, $m, PREG_OFFSET_CAPTURE)) {
        $blockEnd = $this->lineEndFrom($contents, $m[0][1] + strlen($m[0][0]) - 1);
        $insertionPos = $blockEnd;
    }

    // 3) Before const app
    if ($insertionPos === null && preg_match($constAppRx, $contents, $m, PREG_OFFSET_CAPTURE)) {
        $insertionPos = $m[0][1];
    }

    // 4) Start of file
    if ($insertionPos === null) {
        $insertionPos = 0;
    }

    $markerLine = "// {$group} components\n";
    $new = substr($contents, 0, $insertionPos)
         . $markerLine
         . $importLine . "\n"
         . substr($contents, $insertionPos);

    return $new;
}


    protected function appendImportIntoSection(string $contents, int $markerOffset, string $importLine, array $endMarkers): string
    {
        // Section starts after marker’s EOL
        $start = $this->lineEndFrom($contents, $markerOffset);

        // Section end: next components marker OR const app
        $end = strlen($contents);
        foreach ($endMarkers as $rx) {
            if (preg_match($rx, $contents, $mm, PREG_OFFSET_CAPTURE, $start)) {
                $end = min($end, $mm[0][1]);
            }
        }

        // From [start, end), find last import; append after it
        $sub = substr($contents, $start, max(0, $end - $start));
        if ($sub !== '' && preg_match_all('/^\s*import\s.+?;[^\n\r]*$/m', $sub, $all, PREG_OFFSET_CAPTURE)) {
            $last     = end($all[0]);
            $lastAbs  = $start + $last[1];
            $insertAt = $this->lineEndFrom($contents, $lastAbs);
            return substr($contents, 0, $insertAt) . $importLine . "\n" . substr($contents, $insertAt);
        }

        // If no imports exist in this section, place right after the marker
        return substr($contents, 0, $start) . $importLine . "\n" . substr($contents, $start);
    }

    /**
     * Insert registration inside `// {group}` section,
     * or create that section right before `.mount('#app')` if missing.
     */
    protected function insertRegistration(string $contents, string $registrationLine, string $group): string
    {
        $groupRegMarker = '/^(\s*)\/\/\s*' . preg_quote($group, '/') . '\s*$/im';

        // If group section exists → append at bottom of that section (before next group or before mount)
        if (preg_match($groupRegMarker, $contents, $m, PREG_OFFSET_CAPTURE)) {
            $blockEnd = $this->findSectionEnd($contents, $m[0][1], ['/^(\s*)\/\/\s*[a-z0-9_-]+\s*$/im', '/\.mount\s*\(/']);
            return substr($contents, 0, $blockEnd) . $registrationLine . "\n" . substr($contents, $blockEnd);
        }

        // Otherwise create the section right before .mount('#app')
        if (preg_match('/\.mount\s*\(\s*[\'"]#app[\'"]\s*\)/', $contents, $m, PREG_OFFSET_CAPTURE)) {
            $pos = $m[0][1];
            $marker = "  // {$group}\n";
            return substr($contents, 0, $pos) . $marker . $registrationLine . "\n" . substr($contents, $pos);
        }

        // Fallback: append at end
        return rtrim($contents) . "\n" . "  // {$group}\n" . $registrationLine . "\n";
    }

    protected function findSectionEnd(string $contents, int $startOffset, array $endPatterns): int
    {
        $end = strlen($contents);
        foreach ($endPatterns as $rx) {
            if (preg_match($rx, $contents, $m, PREG_OFFSET_CAPTURE, $startOffset + 1)) {
                $end = min($end, $m[0][1]);
            }
        }
        return $end;
    }

    /** Return offset right AFTER the end-of-line containing $pos. */
    protected function lineEndFrom(string $contents, int $pos): int
    {
        $nl = strpos($contents, "\n", $pos);
        return $nl === false ? strlen($contents) : $nl + 1;
    }
}
