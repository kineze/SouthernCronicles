<?php

namespace Database\Seeders;

use App\Models\Speaker;
use App\Models\SpeakerType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class SpeakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Your provided image paths (relative to the public storage 'storage/' prefix in the UI)
        $images = [
            'speakers/pjkFX51koxysRlxkx4Hexx9SmcxX3G4QloKZQTLY.webp',
            'speakers/i8TFjc70kSylu4VNOTm8FdWiyYx99ACf07p3KiIJ.webp',
            'speakers/JjPfAFwf6cKmD1Pq5g6K277y8boXv5Z138B9lilt.jpg',
            'speakers/kKUfnbR3lbd7B5ZYA7gMe7jVEo9YnhvfHmqXYgQw.jpg',
        ];

        // Cache available type IDs (if any)
        $typeIds = SpeakerType::query()->pluck('id')->all();

        for ($i = 1; $i <= 150; $i++) {
            // Cycle evenly through the provided images
            $image = $images[($i - 1) % count($images)];

            // Randomly include socials ~60% of the time
            $maybe = fn() => $faker->boolean(60) ? $faker->url() : null;

            // Pick a type if available
            $speakerTypeId = !empty($typeIds) ? Arr::random($typeIds) : null;

            Speaker::create([
                'name'            => $faker->name(),
                'facebook'        => $maybe(),
                'instagram'       => $maybe(),
                'linkedin'        => $maybe(),
                'speaker_type_id' => $speakerTypeId,   // null if you don't have types yet
                'description'     => $faker->sentence(12),
                'show_on_home'    => $i % 3 === 0,     // roughly 1/3 show on home
                'image'           => $image,           // e.g. "speakers/abc.jpg"
            ]);
        }
    }
}
