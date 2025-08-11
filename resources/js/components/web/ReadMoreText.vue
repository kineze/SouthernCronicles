<template>
  <div class="grid grid-cols-1 py-16 md:grid-cols-2 lg:grid-cols-3 md:gap-3">
    <div
      v-for="(item, index) in contentBlocks"
      :key="index"
      class="w-full items-center flex flex-col text-black dark:text-white px-4"
    >
      <img
        :src="item.image"
        class="w-64 h-64 object-contain"
        :alt="'Logo ' + (index + 1)"
      />

      <p class="text-justify mt-4">
        {{ isExpanded[index] ? item.text : item.text.slice(0, item.limit) + '...' }}
        <span
          v-if="item.text.length > item.limit"
          class="text-blue-600 cursor-pointer ml-1"
          @click="toggleText(index)"
        >
          {{ isExpanded[index] ? 'Read less' : 'Read more' }}
        </span>
      </p>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'

// Content blocks: each with its own image and text
const contentBlocks = [
  {
    image: '/assets/img/asian-group-logo.webp',
    limit: 300,
    text: `The Asian Group of Literature stands as a pioneering collective of six creative social enterprises, founded by Sri Lankan novelist Pramudith D Rupasinghe, humanitarian and social entrepreneur. With a global presence of its services spanning Asia, Europe, Africa, and the Americas, the organisation operates through a diversified portfolio addressing the evolving landscape of contemporary literature.
    The group's operations encompass six core business divisions: Literary Representation and Editorial Services, Literary Publicist, Academic and Scholarly Publications, Cultural Programmes and Residencies, Recognition and Awards Frameworks, and Festival Curation and Event Management. This comprehensive approach ensures support for writers and literary communities at every stage of their creative journey.
    The Asian Group's foundation rests upon six distinguished pillars: The Asian Review, its flagship literary publication; The Asian Prizes, recognising exceptional literary achievement; The Asian Literary Agency, providing professional representation; The Asian House of Literature, fostering creative residencies and cultural exchange; The Asian Journal of Literature, advancing scholarly discourse; and The Asian Literary Festivals, celebrating literary culture through curated events.
    Through this integrated ecosystem, The Asian Group of Literature champions diverse voices, facilitates cross-cultural dialogue, and strengthens the global literary community. Its commitment extends beyond commerce to genuine social impact, reflecting the founder's vision of literature as a transformative force for positive change across continents and cultures.`
  },
  {
    image: '/assets/img/trogon.webp',
    limit: 300,
    text: `Trogon Global emerges as a trailblazing leader in the international cultural landscape, bridging the gap between corporate excellence and creative innovation from its strategic base in the UAE. As a distinguished festival curation company and cultural consultancy, Trogon Global specialises in conceptualising and delivering world-class festivals and conferences worldwide, establishing itself as a trusted partner in the Creative Economy sector.
    Founded on the principle that "the power of the local shapes the global," the company harnesses decades of collective expertise from its professional team to create meaningful cultural exchanges that transcend geographical boundaries. This philosophy drives every project, ensuring that local authenticity and global relevance converge to produce extraordinary experiences.
    Trogon Global's unique positioning enables the creation of profitable and influential cultural brands that serve a greater purpose beyond commercial success. The company recognises culture as a unifying force, deliberately crafting events that foster understanding, collaboration, and connection across diverse communities. Each festival and conference is meticulously curated to not only entertain and educate but to strengthen the cultural fabric that binds our increasingly interconnected world.
    Registered as Trogon Global Event Management Company LLC in Dubai, the organisation leverages the UAE's strategic location and multicultural environment to serve as a cultural bridge between East and West, consistently delivering transformative experiences that celebrate both local heritage and global innovation.
    `
  },
  {
    image: '/assets/img/pickbook.webp',
    limit: 300,
    text: `Pick a Book is a revolutionary book club that transforms how we cultivate reading culture in our fast-paced digital age. What began as a simple office initiative at Epitom Digital in Colombo, Sri Lanka, has blossomed into a vibrant community platform that redefines how we engage with literature and learning.
The concept emerged from a beautifully simple idea: one employee would read a chapter and share its insights with colleagues during workplace sessions. This organic sharing sparked something remarkable—it revealed a widespread hunger for knowledge amongst people who genuinely loved reading but struggled to find time in their busy schedules.
Recognising this universal challenge, Pick a Book evolved beyond office walls to become a comprehensive book club ecosystem for readers of all backgrounds and ages. The platform ingeniously bridges the gap between our desire to read and the practical constraints of modern life, offering curated book clubs, engaging reading circles, and flexible options to buy, borrow, donate, or swap books.
More than just a traditional book club, Pick a Book fosters genuine community connections through shared literary experiences. It transforms solitary reading into collaborative discovery, where every book becomes a conversation starter and every page turned contributes to personal growth whilst building meaningful relationships with fellow book enthusiasts across the community.`
  }
]

// Reactive state for "read more" toggling per block
const isExpanded = reactive(contentBlocks.map(() => false))

const toggleText = (index) => {
  isExpanded[index] = !isExpanded[index]
}
</script>
