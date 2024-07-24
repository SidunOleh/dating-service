@include('templates.header')

<div class="popUp-wrapper active">



</div>

@includeWhen(!auth('web')->check(), 'modals.auth') 

@include('templates.footer')