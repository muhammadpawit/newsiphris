<script>
    const Loader = {
        // Durasi minimum loader tampil (dalam milidetik)
        minDelay: 500, 
        
        show: function() {
            this.startTime = Date.now(); // Catat waktu mulai
            $('#global-loader').css('display', 'flex');
        },
        
        hide: function() {
            const currentTime = Date.now();
            const timeElapsed = currentTime - this.startTime;
            const remainingTime = Math.max(0, this.minDelay - timeElapsed);

            // Sembunyikan setelah sisa waktu minimum terpenuhi
            setTimeout(() => {
                $('#global-loader').fadeOut('fast');
            }, remainingTime);
        }
    };

    // 1. Body Load
    Loader.show();
    $(window).on('load', function() {
        Loader.hide();
    });

    // 2. AJAX (Gunakan debounce/delay kecil agar tidak flicker pada request cepat)
    $(document).ajaxStart(() => Loader.show()).ajaxStop(() => Loader.hide());
</script>