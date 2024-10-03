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
    <div class="footer-bottom">
        <p>Based Dominican Republic.</p>
        <p>USC 2257 / 21+ Only!</p>
        <p>© 2024 Cherry21.com</p>
    </div>
</footer>

<script src="{{ asset('assets/js/lazysizes.min.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.key') }}"></script>
<script src="{{ asset('assets/js/bundle.js') }}"></script>

<script>
    // disable context menu
    document.addEventListener('contextmenu', event => event.preventDefault())

    // recaptcha
    function getReCaptchaV3(action) {
        return new Promise((resolve, reject) => grecaptcha.ready(() => grecaptcha
            .execute("{{ config('services.recaptcha.key') }}", {action,})
            .then(resolve))
        )
    }

    // lazy load
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