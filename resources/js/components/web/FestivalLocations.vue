<template>
  <div class="w-full h-[60vh] lg:h-[100vh] overflow-hidden py-10 relative z-50">

    <header class="text-center mb-10 lg:mb-14">

      <h2 id="vm-title" class="mt-2 uppercase font-extrabold text-black tracking-widest text-3xl lg:text-6xl " >
        Festival Locations
      </h2>

    </header>



    <div class=" p-4 border border-black">
      <div ref="mapEl" class="w-full h-full"></div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import axios from 'axios'

const mapEl = ref(null)
let map, infoWindow
let markers = []
let maps // google.maps namespace

// ---- Helpers (no timezone conversion; pure string AM/PM) ----
function formatTimeAMPM(dtStr) {
  if (!dtStr) return ''
  const s = String(dtStr)
  const m = s.match(/(?:T|\s)(\d{2}):(\d{2})(?::\d{2})?/)
  if (!m) return s
  let h = parseInt(m[1], 10)
  const min = m[2]
  const ampm = h >= 12 ? 'PM' : 'AM'
  h = h % 12
  if (h === 0) h = 12
  return `${h}:${min} ${ampm}`
}

function formatDateYMD(dtStr) {
  const m = String(dtStr).match(/^(\d{4})-(\d{2})-(\d{2})/)
  return m ? `${m[1]}-${m[2]}-${m[3]}` : (dtStr || '')
}

// ---- Load Maps JS (no npm) ----
let mapsApiPromise = null
function loadGoogleMaps () {
  if (window.google?.maps) return Promise.resolve(window.google.maps)
  if (mapsApiPromise) return mapsApiPromise

  const apiKey =
    document.querySelector('meta[name="gmaps-key"]')?.content ||
    (import.meta.env?.GOOGLE_MAPS_API_KEY ?? '')

  mapsApiPromise = new Promise((resolve, reject) => {
    if (!apiKey) return reject(new Error('Google Maps API key is missing'))
    const s = document.createElement('script')
    // marker library is needed for AdvancedMarkerElement
    s.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places,marker&v=weekly`
    s.async = true
    s.defer = true
    s.onerror = () => reject(new Error('Failed to load Google Maps'))
    s.onload = () => resolve(window.google.maps)
    document.head.appendChild(s)
  })
  return mapsApiPromise
}

// ---- Build a custom marker (red dot + image) using AdvancedMarkerElement ----
function buildMarkerContent(festival) {
  const wrapper = document.createElement('div')
  wrapper.style.display = 'flex'
  wrapper.style.alignItems = 'center'
  wrapper.style.gap = '6px'

  // red dot
  const dot = document.createElement('div')
  dot.style.width = '12px'
  dot.style.height = '12px'
  dot.style.borderRadius = '9999px'
  dot.style.background = '#ef4444' // red-500
  dot.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.25)'
  wrapper.appendChild(dot)

  // image (round)
  if (festival.image) {
    const img = document.createElement('img')
    img.src = `/storage/${festival.image}`
    img.alt = festival.name || 'Festival'
    img.style.width = '32px'
    img.style.height = '32px'
    img.style.objectFit = 'cover'
    img.style.borderRadius = '9999px'
    img.style.border = '2px solid white'
    img.style.boxShadow = '0 2px 6px rgba(0,0,0,0.2)'
    wrapper.appendChild(img)
  }

  return wrapper
}

function openInfoWindow(festival, position) {
  const start = `${formatDateYMD(festival.start_at)} • ${formatTimeAMPM(festival.start_at)}`
  const end   = `${formatDateYMD(festival.end_at)} • ${formatTimeAMPM(festival.end_at)}`
  const imgHtml = festival.image
    ? `<img src="/storage/${festival.image}" alt="" style="width:230px;max-height:220px;object:cover;border-radius:5px;margin-bottom:8px;margin-top:12px;" />`
    : ''

const urlHtml = festival.site_url
  ? `<div style="margin-top:8px;">
       <a href="${festival.site_url}" target="_blank" rel="noopener"
          style="
            display: inline-block;
            background-color: #000000;
            color: white;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 3px;
            transition: background-color 0.2s ease;
          "
         
          >
          Visit Website
       </a>
     </div>`
  : '';


  const html = `
    <div style="max-width:260px;">
      ${imgHtml}
      <div style="font-weight:700;color:#000000;margin-bottom:6px;margin-top:10px;">${festival.name ?? 'Festival'}</div>
      <div style="font-size:12px;color:#000000;margin-bottom:2px;"><strong>Start:</strong> ${start}</div>
      <div style="font-size:12px;color:#000000;margin-bottom:2px;"><strong>End:</strong> ${end}</div>
      <div style="font-size:12px;color:#000000;"><strong>Location:</strong> ${festival.location ?? ''}</div>
      ${urlHtml}
    </div>
  `

  infoWindow.setContent(html)
  infoWindow.setPosition(position)
  infoWindow.open({ map })
}

async function initMap() {
  const { Map } = await google.maps.importLibrary('maps')
  await google.maps.importLibrary('marker')

map = new Map(mapEl.value, {
  center: { lat: 0, lng: 0 },
  zoom: 1,
  streetViewControl: true,
  mapTypeControl: false,
  mapId: '5107c09a9c52ed1f388902c8',
  // gestureHandling: 'greedy',   // 👈 remove ctrl+scroll overlay
  zoomControl: true,
  zoomControlOptions: {
    position: google.maps.ControlPosition.RIGHT_BOTTOM,
  },
})

  infoWindow = new google.maps.InfoWindow()
}

function clearMarkers() {
  for (const m of markers) m.map = null
  markers = []
}

async function plotFestivals() {
  const res = await axios.get('/api/festivals')
  const items = (res.data || []).filter(f => f.location_lat != null && f.location_lng != null)

  clearMarkers()

  const bounds = new google.maps.LatLngBounds()
  const { AdvancedMarkerElement } = google.maps.marker

  for (const f of items) {
    const pos = new google.maps.LatLng(Number(f.location_lat), Number(f.location_lng))
    bounds.extend(pos)

    const marker = new AdvancedMarkerElement({
      map,
      position: pos,
      content: buildMarkerContent(f),
      title: f.name || 'Festival',
    })

    marker.addListener('gmp-click', () => openInfoWindow(f, pos))
    markers.push(marker)
  }

  if (!bounds.isEmpty()) {
    const padding = window.innerWidth <= 640 ? 110 : 220 // mobile vs desktop
    map.fitBounds(bounds, padding)
  }

}

onMounted(async () => {
  maps = await loadGoogleMaps()
  await initMap()
  await plotFestivals()
})

onBeforeUnmount(() => {
  clearMarkers()
  if (infoWindow) infoWindow.close()
})
</script>


<style>
.gm-ui-hover-effect {
  background-color: #ef4444 !important; /* red bg */
  border-radius: 50% !important; /* fully rounded */
  width: 20px !important; /* smaller */
  height: 20px !important;
  top: 8px !important; /* position over image */
  right: -3px !important;
  opacity: 1 !important;
}

.gm-ui-hover-effect span {
  margin: -2px !important;
  filter: invert(1) brightness(2); /* makes the X white */
  transform: scale(0.7); /* smaller X inside */
}

.gm-style-iw-chr {
  position: absolute;
  top: 0;
  right: 0;
  margin-right: 10px;
}
</style>