<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Maintenance</title>
    <?php wp_head(); ?>
</head>
<body>
    <div class="smm-container" style="background-image: url('<?php echo esc_url($data->image_location); ?>')">
        <div class="smm-message">
            <h1><?php echo esc_html($data->message); ?></h1>
            <div id="smm-countdown"></div>
        </div>
    </div>

    <script>
    let timeLeft = <?php echo (int) ($data->end_time - time()); ?>;
    const countdownEl = document.getElementById('smm-countdown');

    function updateCountdown() {
        if (timeLeft <= 0) {
            countdownEl.innerHTML = "We'll be back soon!";
            return;
        }

        const hours = Math.floor(timeLeft / 3600);
        const minutes = Math.floor((timeLeft % 3600) / 60);
        const seconds = timeLeft % 60;

        let timeStr = 'Returning in ';
        if (hours > 0) timeStr += `${hours}h `;
        if (minutes > 0 || hours > 0) timeStr += `${minutes}m `;
        timeStr += `${seconds}s`;

        countdownEl.innerHTML = timeStr.trim();
        timeLeft--;
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
</script>


    <?php wp_footer(); ?>
</body>
</html>
