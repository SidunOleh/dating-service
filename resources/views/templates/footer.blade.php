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

<script data-src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}" data-type="lazy"></script>
<script>
function getReCaptchaV3(action) {
    return new Promise((resolve, reject) => grecaptcha.ready(() => grecaptcha
        .execute('{{ env('RECAPTCHA_SITE_KEY') }}', {action,})
        .then(resolve))
    )
}
</script>
<script src="{{ asset('assets/js/lazysizes.min.js') }}"></script>
<script data-src="{{ asset('assets/js/bundle.js') }}" data-type="lazy"></script>

<script>
    const load = () => {
        document.querySelectorAll("script[data-type='lazy']").forEach(script => {
            script.setAttribute("src", script.getAttribute("data-src"))
        })
        
        clearTimeout(timer)
    }

    const timer = setTimeout(load, 5000)

    const events = ["mouseover", "keydown", "touchmove", "touchstart",]

    events.forEach(e => window.addEventListener(e, load, {
        passive: true, 
        once: true,
    }))
</script>

</body>

</html>