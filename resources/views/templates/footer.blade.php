<footer class="footer">
    <div class="footer-container">
        <a href="#" class="footer-link">
            <img src="{{ asset('assets/img/help.svg') }}" alt="question mark" />
            Here is info
        </a>
        <a href="#" class="footer-link">
            <img src="{{ asset('assets/img/more.svg') }}" alt="plane" />
            Here is More
        </a>
    </div>
</footer>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/fancybox.umd.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/just-validate.production.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
</body>
{{ dd($GLOBALS['sql']) }}
</html>