<footer class="footer" onclick="onClicks">
    <div class="footer-container">
        <a href="#" class="footer-link">
            <img src="{{ asset('assets/img/help.svg') }}" alt="question mark" />
            Here is info
        </a>
        <a href="#" class="footer-link">
            <img src="{{ asset('assets/img/more.svg') }}" alt="plane"/>
            Here is More
        </a>
    </div>
</footer>

<style>
    .grecaptcha-badge {
        z-index: 100;
    }
</style>
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
<script>
    function getReCaptchaV3(action) {
        return new Promise((resolve, reject) => {
            grecaptcha.ready(() => {
                grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {
                    action: action,
                }).then(resolve)
            })
        })
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const lazyImages = document.querySelectorAll('img[cloading="lazy"]');
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const lazyImage = entry.target;
                    lazyImage.src = lazyImage.dataset.src;
                    lazyImage.onload = function() {
                        lazyImage.removeAttribute("data-src");
                        lazyImage.removeAttribute("loading");
                    };
                    observer.unobserve(lazyImage);
                }
            });
        });

        lazyImages.forEach(function(lazyImage) {
            imageObserver.observe(lazyImage);
        });
    });
</script>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/fancybox.umd.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>