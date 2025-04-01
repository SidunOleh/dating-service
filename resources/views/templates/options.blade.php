<div class="left-card">
    <div class="title">
        Your Post Stats
    </div>

    <div class="statistic-list">
        <div class="statistic-item">
            <span>Daily:</span> {{ $creator->visitsCount('day') }}
        </div>
        <div class="statistic-item">
            <span>Weekly:</span> {{ $creator->visitsCount('week') }}
        </div>
        <div class="statistic-item">
            <span>Monthly:</span> {{ $creator->visitsCount('month') }}
        </div>
        <div class="statistic-item">
            <span>All time:</span> {{ $creator->visitsCount() }}
        </div>
    </div>
    
    <div class="toggle-container">
        <div class="toggle-group">
            <label for="vote-battle">
                Vote Battle
            </label>
            <div class="toggle-body">
                <span>Disabled</span>
                <label class="toggle">
                    <input 
                        type="checkbox" 
                        id="vote-battle" 
                        name="play_roulette"
                        @checked($creator->play_roulette) />
                    <span class="slider"></span>
                </label>
                <span>Enabled</span>
            </div>
        </div>

        <div class="info-text">
            <a href="{{ route('faq.page', ['target' => 'what-is-vote-battle']) }}">
                What is Vote Battle?
            </a>
        </div>

        <div class="toggle-group">
            <label for="account-visibility">Public Profile</label>
            <div class="toggle-body">
                <span>Disabled</span>
                <label class="toggle">
                    <input 
                        type="checkbox" 
                        id="account-visibility"
                        name="show_on_site"
                        @checked($creator->show_on_site) />
                    <span class="slider"></span>
                </label>
                <span>Enabled</span>
            </div>
        </div>

        <div class="sub-link"> 
            <div class="title" style="margin-bottom: 8px;">
                Share Your Profile
            </div>
            <div class="subtitle">Share your personal profile link</div>
            <div class="link-body">
                <div class="link">
                    {{ route('profile.page', ['creator' => $creator->id,]) }}
                </div>
                <div class="btn red copy-link" style="white-space: nowrap;">Copy Link</div>
                <div class="message">
                    <div>
                        Link copied 
                        <img src="{{ asset('/assets/img/checkmark.svg') }}" alt="" />
                    </div>
                </div>
            </div>
        </div>

        @if($creator->profile_is_created and ! $creator->hasUndoneProfileRequest())
        <div class="info-text">
            <p class="delete-acc">
                Delete your profile
            </p>
        </div>
        @endif
        
    </div>
</div>