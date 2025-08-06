<script>
window.addEventListener('scroll', function () {
  document.querySelectorAll('.parallax-layer').forEach(layer => {
    const speed = layer.getAttribute('data-speed');
    layer.style.transform = `translateY(${window.scrollY * speed}px)`;
  });
});
</script>
