@if(auth('web')->check() or $show_contacts)
<div class="user-info-list">
    <p class="info-title">
        Get in Touch
    </p>
    @if($creator->phone)
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/phone.svg" alt="" /> Phone:</span>
        <p class="info">{{ $creator->phone }}</p>
    </div>
    @endif
    @if($creator->telegram)
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/ic_outline-telegram.svg" alt="" /> Telegram:</span>
        <p class="info">{{ $creator->telegram }}</p>
    </div>
    @endif
    @if($creator->whatsapp)
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/whatsapp.svg" alt="" /> Whatsapp:</span>
        <p class="info">{{ $creator->whatsapp }}</p>
    </div>
    @endif
    @if($creator->snapchat)
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/snapchat.svg" alt="" /> Snapchat:</span>
        <p class="info">{{ $creator->snapchat }}</p>
    </div>
    @endif
    @if($creator->instagram)
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/mdi_instagram.svg" alt="" /> Instagram:</span>
        <p class="info">{{ $creator->instagram }}</p>
    </div>
    @endif
    @if($creator->onlyfans)
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/onlyfans.svg" alt="" /> OnlyFans:</span>
        <p class="info">{{ $creator->onlyfans }}</p>
    </div>
    @endif
    @if($creator->profile_email)
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/mail.svg" alt="" /> Email:</span>
        <p class="info">{{ $creator->profile_email }}</p>
    </div>
    @endif
    @if($creator->twitter)
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/twitter.png" alt="" /> Twitter:</span>
        <p class="info">{{ $creator->twitter }}</p>
    </div>
    @endif
</div>
@else
<div class="user-info-list with-blur">
    <div class="blur">
        <div class="blur__body">
            <div class="blur__text">
                Log In, to Get in Touch
            </div>
            <div class="btn red login">
                Log In
            </div>
        </div>
    </div>
    <p class="info-title">
        Get in Touch
    </p>
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/phone.svg" alt="" /> Phone:</span>
        <p class="info">{{ fake()->tollFreePhoneNumber() }}</p>
    </div>
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/ic_outline-telegram.svg" alt="" /> Telegram:</span>
        <p class="info">{{ fake()->userName() }}</p>
    </div>
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/whatsapp.svg" alt="" /> Whatsapp:</span>
        <p class="info">{{ fake()->userName() }}</p>
    </div>
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/snapchat.svg" alt="" /> Snapchat:</span>
        <p class="info">{{ fake()->userName() }}</p>
    </div>
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/mdi_instagram.svg" alt="" /> Instagram:</span>
        <p class="info">{{ fake()->userName() }}</p>
    </div>
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/onlyfans.svg" alt="" /> OnlyFans:</span>
        <p class="info">{{ fake()->userName() }}</p>
    </div>
    <div class="user-info-item">
        <span class="type"><img src="/assets/img/mail.svg" alt="" /> Email:</span>
        <p class="info">{{ fake()->email() }}</p>
    </div>
</div>
@endif