<div class="left-card">
    <div class="title">
        Visit statistis
    </div>

    <div class="statistic-list">
        <div class="statistic-item">
            <span>Day:</span> {{ $creator->visitsCount('day') }}
        </div>
        <div class="statistic-item">
            <span>Week:</span> {{ $creator->visitsCount('week') }}
        </div>
        <div class="statistic-item">
            <span>Month:</span> {{ $creator->visitsCount('month') }}
        </div>
        <div class="statistic-item">
            <span>All time:</span> {{ $creator->visitsCount() }}
        </div>
    </div>
    
    <div class="toggle-container">
        <div class="toggle-group">
            <label for="vote-battle">
                Vote battle
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
            <a href="{{ route('faq.page') }}">
                What is it Roulette?
            </a>
        </div>

        <div class="toggle-group">
            <label for="account-visibility">Account visibility</label>
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

        @if($creator->profile_is_created)
        <div class="info-text">
            <p class="delete-acc">
                Delete your profile
            </p>
        </div>
        @endif
        
    </div>
</div>