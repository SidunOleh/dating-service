<div class="users-item battle">
    <div class="battle-container">

        <div class="loader">
            <div class="loader-L"><img src="{{ asset('assets/img/loader-l.jpg') }}" alt=""></div>
            <div class="loader-R"><img src="{{ asset('assets/img/loader-r.jpg') }}" alt=""></div>
        </div>
        
        <div class="startBattle">
            <div class="start_btn">Start</div>
        </div>
        
        <div class="photo-battle">
            <div class="repeat" id="repeatButton">
                <span>Repeat</span>
                <svg class="progress-ring" width="80" height="80">
                    <circle
                      class="progress-ring__circle"
                      stroke="white"
                      stroke-width="2"
                      fill="transparent"
                      r="34"
                      cx="40"
                      cy="40"/>
                  </svg>
            </div>

            <div class="photo-container photo" id="photo1" data-id="{{ $pair[0]->id }}">
                <img
                    src="{{ asset('assets/img/placeholder.png') }}" 
                    data-src="{{ $pair[0]->gallery->random()->url }}" 
                    class="lazyload" 
                    alt="image" />
                <div class="info right">
                    {{ $pair[0]->city }}, {{ $pair[0]->state }}
                </div>
            </div>
            
            <div class="photo-container photo" id="photo2" data-id="{{ $pair[1]->id }}">
                <img
                    src="{{ asset('assets/img/placeholder.png') }}" 
                    data-src="{{ $pair[1]->gallery->random()->url }}" 
                    class="lazyload" 
                    alt="image" />
                <div class="info left">
                    {{ $pair[0]->city }}, {{ $pair[0]->state }}
                </div>
            </div>

        </div>
    </div>
</div>