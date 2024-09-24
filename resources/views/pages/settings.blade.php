@include('templates.header', ['title' => 'Settings',])

<section class="settings">
    <div class="container">
        <p class="title">Settings</p>

        <div class="settings-list">
            <div class="settings-item">
                <div class="current email">
                    <img src="{{ asset('/assets/img/mailSettings.svg') }}" alt="" /> 
                    {{ $creator->email }}
                </div>
                <div class="reset-btn btn red email">
                    Edit email address
                </div>
            </div>
            <div class="settings-item">
                <div class="current password">
                    <img src="{{ asset('/assets/img/light_lock.svg') }}" alt="" /> 
                    *********
                </div>
                <div class="reset-btn btn red pass">
                    Edit password
                </div>
            </div>
        </div>
    </div>
</section>

@include('modals.settings')
@include('modals.verification')

@include('templates.footer')