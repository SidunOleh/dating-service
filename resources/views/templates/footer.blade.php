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

<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}" async></script>
<script>
function getReCaptchaV3(action) {
    return new Promise((resolve, reject) => grecaptcha.ready(() => grecaptcha
        .execute('{{ env('RECAPTCHA_SITE_KEY') }}', {action,})
        .then(resolve))
    )
}
</script>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/fancybox.umd.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>