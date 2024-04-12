<div>
    <span id="countdown" class="countdown font-mono text-xs">
    </span>
</div>

<script>
    const countdownElement = document.getElementById('countdown');

    const countDownDate = new Date("Apr 15, 2024 13:00:00").getTime();

    const x = setInterval(function() {
        const now = new Date().getTime();
        const distance = countDownDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        countdownElement.innerHTML = days + "d {{ __('countdown.label') }}";

        countdownElement.style.color = days < 5 ? '#FF3333' : '#909AA8';

        if (distance < 0) {
            clearInterval(x);
            countdownElement.innerHTML = "{{ __('countdown.expired') }}";
        }
    }, 1000);
</script>
