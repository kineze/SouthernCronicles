<script>
    document.addEventListener('DOMContentLoaded', () => {
        const layers = document.querySelectorAll('.parallax-layer');
        let latestScrollY = window.scrollY;
        let ticking = false;

        function updateParallax() {
            layers.forEach(layer => {
                const speed = parseFloat(layer.dataset.speed || 0.3);
                const yOffset = latestScrollY * speed;
                layer.style.transform = `translate3d(0, ${yOffset}px, 0)`;
            });
            ticking = false;
        }

        function onScroll() {
            latestScrollY = window.scrollY;
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        }

        window.addEventListener('scroll', onScroll, { passive: true });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var countDownDate = new Date("{{ $nextFestival->start_at }}").getTime();

        var countdownFunction = setInterval(function () {
            var now = new Date().getTime();
            var timeLeft = countDownDate - now;

            if (timeLeft > 0) {
                var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                const ids = ["days", "days-mobile"];
                const hoursIds = ["hours", "hours-mobile"];
                const minutesIds = ["minutes", "minutes-mobile"];
                const secondsIds = ["seconds", "seconds-mobile"];

                ids.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = days;
                });
                hoursIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = hours;
                });
                minutesIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = minutes;
                });
                secondsIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = seconds;
                });

            } else {
                clearInterval(countdownFunction);
                const cd1 = document.getElementById("countdown");
                const cd2 = document.getElementById("countdown-mobile");
                if (cd1) cd1.innerHTML = "<h2 class='text-white text-2xl'>Festival has started!</h2>";
                if (cd2) cd2.innerHTML = "<h2 class='text-white text-2xl'>Festival has started!</h2>";
            }
        }, 1000);
    });
</script>
