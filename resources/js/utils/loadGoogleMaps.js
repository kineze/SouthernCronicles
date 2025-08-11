export function loadGoogleMaps(apiKey) {
  return new Promise((resolve, reject) => {
    if (!apiKey) return reject(new Error('Missing Google Maps API key'));
    if (window.google && window.google.maps) return resolve(window.google);

    const existing = document.getElementById('google-maps-script');
    if (existing) {
      existing.addEventListener('load', () => resolve(window.google));
      existing.addEventListener('error', reject);
      return;
    }

    const script = document.createElement('script');
    script.id = 'google-maps-script';
    script.async = true;
    script.defer = true;
    script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places&v=weekly`;
    script.onload = () => resolve(window.google);
    script.onerror = () => reject(new Error('Failed to load Google Maps JS'));
    document.head.appendChild(script);
  });
}
