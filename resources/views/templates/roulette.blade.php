<a class="users-item battle">
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

            <div class="photo-container photo" id="photo1" data-id="{{ $creators[0]->id }}">
                <img data-src="{{ $creators[0]->gallery->random()->url }}" class="lazyload" alt="Photo 1" />
                <div class="info">
                    {{ mb_strlen($creators[0]->name) > 5 ? mb_substr($creators[0]->name, 0, 5) . '...' : $creators[0]->name }}, {{ $creators[0]->age }}
                </div>
            </div>
            
            <div class="photo-container photo" id="photo2" data-id="{{ $creators[1]->id }}">
                <img data-src="{{ $creators[1]->gallery->random()->url }}" class="lazyload" alt="Photo 2" />
                <div class="info">
                    {{ mb_strlen($creators[1]->name) > 5 ? mb_substr($creators[1]->name, 0, 5) . '...' : $creators[1]->name }}, {{ $creators[1]->age }}
                </div>
            </div>

        </div>
    </div>
</a>