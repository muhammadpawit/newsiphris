                    <div id="global-loader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.7); z-index: 9999; justify-content: center; align-items: center;">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="mt-2 fw-bold">Memproses Data...</div>
                        </div>
                    </div>
<script>
    const Loader = {
        startTime: 0,
        minDelay: 500, // Durasi minimum loader tampil (ms)
        
        show: function() {
            this.startTime = Date.now();
            $('#global-loader').css('display', 'flex').show();
        },
        
        hide: function() {
            const currentTime = Date.now();
            const timeElapsed = currentTime - this.startTime;
            const remainingTime = Math.max(0, this.minDelay - timeElapsed);

            // Sembunyikan setelah sisa waktu minimum terpenuhi agar tidak flicker
            setTimeout(() => {
                $('#global-loader').fadeOut('fast');
            }, remainingTime);
        }
    };

    /**
     * 1. Auto Loader untuk Page Load
     */
    Loader.show();
    $(window).on('load', function() {
        Loader.hide();
    });

    /**
     * 2. Auto Loader untuk Semua Request AJAX (DataTables, Form Submit, dll)
     */
    let ajaxTimer;
    $(document).ajaxStart(function() {
        // Beri delay kecil 200ms: jika request sangat cepat, loader tidak perlu muncul
        ajaxTimer = setTimeout(() => Loader.show(), 200);
    }).ajaxStop(function() {
        clearTimeout(ajaxTimer);
        Loader.hide();
    });

    /**
     * 3. Fungsi Debounce Global
     * Digunakan untuk menunda eksekusi fungsi (seperti search) hingga user berhenti mengetik
     */
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

    /**
     * 4. Integrasi Debounce ke DataTables Search
     * Menangani input search agar tidak langsung menembak server di setiap huruf
     */
    $(document).ready(function() {
        $(document).on('input', '.dataTables_filter input', debounce(function() {
            // Langsung panggil variabel moduleTable yang sudah didefinisikan di bawah
            if (typeof moduleTable !== 'undefined') {
                moduleTable.search(this.value).draw();
            }
        }, 500));
    });
</script>