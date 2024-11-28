<footer class="footer">
    <div class="footer-container">
        <a href="{{ route('faq.page') }}" class="footer-link">
            <img src="{{ asset('assets/img/help.svg') }}" alt="question mark" />
            Help Me, Cherry!
        </a>
        <a href="https://t.me/cherry21com" class="footer-link">
            <img src="{{ asset('assets/img/more.svg') }}" alt="plane"/>
            Cherry'gram
        </a>
    </div>
    <div class="footer-bottom">
        <p>Born in DR, Made for Us.</p>
        <p>21+ Only!</p>
        <p>© {{ date('Y') }} Cherry21.com</p>
    </div>
</footer>


<script src="{{ asset('assets/js/lazysizes.min.js') }}"></script>

@if(Route::currentRouteName() == 'subscription.page')
<script src="{{ asset('assets/js/qrcode.min.js') }}"></script>
@endif

<script src="{{ asset('assets/js/bundle.js') }}"></script>

<script>
    // disable context menu
    // document.addEventListener('contextmenu', event => event.preventDefault())

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