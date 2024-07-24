@include('templates.header')

<section class="section-404">
    <div class="container">
        <div class="title">
            Ops, this page does not seem to exist
        </div>
        <a href="{{ route('home.index') }}" class="btn red">
            Back home page
        </a>
        <img src="{{ asset('/assets/img/404.svg') }}" alt="" />
    </div>
</section>

@include('templates.footer')
