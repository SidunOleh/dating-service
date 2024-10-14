<div class="users-item battle">
    <div class="battle-container">

        <div class="loader">
            <div class="loader-L"></div>
            <div class="loader-R"></div>
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
                <div class="info">
                    {{ mb_strlen($pair[0]->name) > 5 ? mb_substr($pair[0]->name, 0, 5) . '...' : $pair[0]->name }}, {{ $pair[0]->age }}
                </div>
            </div>
            
            <div class="photo-container photo" id="photo2" data-id="{{ $pair[1]->id }}">
                <img
                    src="{{ asset('assets/img/placeholder.png') }}" 
                    data-src="{{ $pair[1]->gallery->random()->url }}" 
                    class="lazyload" 
                    alt="image" />
                <div class="info">
                    {{ mb_strlen($pair[1]->name) > 5 ? mb_substr($pair[1]->name, 0, 5) . '...' : $pair[1]->name }}, {{ $pair[1]->age }}
                </div>
            </div>

        </div>
    </div>
</div>