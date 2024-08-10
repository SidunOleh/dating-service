<footer class="footer">
    <div class="footer-container">
        <a href="{{ route('faq.page') }}" class="footer-link">
            <img src="{{ asset('assets/img/help.svg') }}" alt="question mark" />
            Here is info
        </a>
        <a href="{{ route('faq.page') }}" class="footer-link">
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
    return new Promise((resolve, reject) => grecaptcha.ready(() => grecaptcha
        .execute('{{ env('RECAPTCHA_SITE_KEY') }}', {action,})
        .then(resolve))
    )
}
</script>

<script data-src="{{ asset('assets/js/lazysizes.min.js') }}" data-type="lazy"></script>
<script data-src="{{ asset('assets/js/jquery.min.js') }}" data-type="lazy"></script>
<script data-src="{{ asset('assets/js/fancybox.umd.js') }}" data-type="lazy"></script>
<script data-src="{{ asset('assets/js/slick.min.js') }}" data-type="lazy"></script>
<script data-src="{{ asset('assets/js/script.js') }}" data-type="lazy"></script>

<script>
{
    const load = () => {
        document.querySelectorAll("script[data-type='lazy']").forEach(el => el.setAttribute("src", el.getAttribute("data-src")));
        document.querySelectorAll("iframe[data-type='lazy']").forEach(el => el.setAttribute("src", el.getAttribute("data-src")));
    }
    const timer = setTimeout(load, 5000);
    const trigger = () => {
        load();
        clearTimeout(timer);
    }
    const events = ["mouseover","keydown","touchmove","touchstart"];
    events.forEach(e => window.addEventListener(e, trigger, {passive: true, once: true}));
}
</script>
</body>

</html>