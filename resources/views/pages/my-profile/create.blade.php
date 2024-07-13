@include('templates.header')

<section class="profile-filling">
    <div class="container">
        
        <div class="left-card">
            <div class="title">Visit statistis</div>

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
                    <label for="vote-battle">Vote battle</label>
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
                    <a href="#">What is it Roulette?</a>
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
            </div>

        </div>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script type="module">
            import { createApp } from 'https://unpkg.com/petite-vue?module'

            const multistepForm = {
                data: {
                    phone: '',
                    telegram: '',
                    whatsapp: '',
                    instagram: '',
                    snapchat: '',
                    onlyfans: '',
                    profile_email: '',
                    street: '',
                    zip: null,
                    state: '',
                    city: '',
                    latitude: null,
                    longitude: null,
                    name: '',
                    age: null,
                    description: '',
                    photos: [],
                    id_photo: null,
                    verification_photo: null,
                    street_photo: null,
                    first_name: '',
                    last_name: '',
                    birthday: '',
                },
                steps: [
                    [],
                    ['phone', 'telegram', 'whatsapp', 
                    'instagram', 'snapchat', 'onlyfans', 
                    'profile_email',],
                    ['zip', 'street', 'state', 'latitude', 
                    'longitude',],
                    ['name', 'age', 'city', 'description',],
                    ['photos',],
                    ['id_photo', 'id_photo', 'verification_photo', 
                    'street_photo', 'first_name', 'last_name', 
                    'birthday',],
                ],
                rules: {
                    phone: [
                        {
                            message: 'Invalid format',
                            fn: val => ! val || val.match(/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/)
                        },
                    ],
                    profile_email: [
                        {
                            message: 'Invalid format',
                            fn: val => ! val || val.match(/^\S+@\S+\.\S+$/)
                        },
                    ],
                    street: [
                        {
                            message: 'Street required',
                            fn: val => val,
                        },
                    ],
                    zip: [
                        {
                            message: 'ZIP Code required',
                            fn: val => val,
                        },
                        {
                            message: 'ZIP Code invalid',
                            fn: val => val.match(/[0-9]{5}/), 
                        },
                    ],
                    name: [
                        {
                            message: 'Name required',
                            fn: val => val,
                        },
                        {
                            message: 'At least 2 letters',
                            fn: val => val.length >= 2,
                        },
                        {
                            message: 'Up to 8 letters',
                            fn: val => val.length <= 8,
                        },
                    ],
                    age: [
                        {
                            message: 'Age required',
                            fn: val => val,
                        },
                        {
                            message: 'Invalid age',
                            fn: val => !isNaN(val),
                        },
                        {
                            message: 'Must be 18+',
                            fn: val => val >= 18,
                        },
                        {
                            message: 'Maximum age 100',
                            fn: val => val <= 100,
                        },
                    ],
                    city: [
                        {
                            message: 'City required',
                            fn: val => val,
                        },
                    ],
                    description: [
                        {
                            message: 'Description required',
                            fn: val => val,
                        },
                        {
                            message: 'Must be 50-150 words',
                            fn: val => val.length >= 50 && val.length <= 150
                        },
                    ],
                    photos: [
                        {
                            message: 'At least 1 photo',
                            fn: val => val.length >= 1,
                        },
                    ],
                    id_photo: [
                        {
                            message: 'Photo required',
                            fn: val => val,
                        },
                    ],
                    verification_photo: [
                        {
                            message: 'Photo required',
                            fn: val => val,
                        },
                    ],
                    street_photo: [
                        {
                            message: 'Photo required',
                            fn: val => val,
                        },
                    ],
                    first_name: [
                        {
                            message: 'First name required',
                            fn: val => val,
                        },
                        {
                            message: 'At least 2 letters',
                            fn: val => val.length >= 2,
                        },
                    ],
                    last_name: [
                        {
                            message: 'Last name required',
                            fn: val => val,
                        },
                        {
                            message: 'At least 2 letters',
                            fn: val => val.length >= 2,
                        },
                    ],
                    birthday: [
                        {
                            message: 'Birthday required',
                            fn: val => val,
                        },
                        {
                            message: 'Invalid format',
                            fn: val => val.match(/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/) && !isNaN(Date.parse(val))
                        },
                    ],
                },
                errors: {},
                location: {
                    map: null,
                    marker: null,
                    show: false,
                },
                images: {
                    count: 12,
                    size: 10 * 1024 * 1024,
                },
                loading: false,
                step(number) {
                    const step = $(`[data-step=${number}]`)
                    step.addClass('active')

                    const topOffset = step[0].offsetTop - $('#header').height()
                    window.scrollTo({top: topOffset, behavior: 'smooth',})
                },
                next(next) {
                    const current = next - 1

                    const fields = this.steps[current-1]
             
                    this.resetErrors(fields)
                           
                    fields.forEach(field => this.validateField(field))

                    if (current == 2 && !this.data.phone && !this.data.telegram && !this.data.whatsapp) {
                        this.errors.phone = 'One from Phone, Telegram, Whatsapp fields required'
                    }
                    
                    if (this.hasError(fields)) {
                        return
                    }

                    if (current == 3) {
                        this.searchLocation()
                    } else {
                        this.step(next)
                    }
                },
                resetErrors(fields) {
                    fields.forEach(field => delete this.errors[field])
                },
                validateField(field) {
                    const rules = this.rules[field] ?? []

                    for (let i = 0; i < rules.length; i++) {
                        if (! rules[i].fn(this.data[field])) {
                            this.errors[field] = rules[i].message
                            return
                        }
                    }
                },
                hasError(fields) {
                    for (const field in this.errors) {
                        if (fields.includes(field)) {
                            return true
                        }
                    }

                    return false
                },
                formatPhone(e) {
                    let x = e.target.value
                        .replace(/\D/g, '')
                        .match(/(\d{0,3})(\d{0,3})(\d{0,4})/)
                    e.target.value = !x[2]
                        ? x[1]
                        : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '')
                },
                async searchLocation() {
                    this.location.loading = true

                    this.data.state = ''
                    this.data.city = ''
                    this.data.latitude = null 
                    this.data.longitude = null 

                    const zip = await this.getZip(this.data.zip)
                    if (! zip) {
                        this.errors.zip = 'ZIP Code Not Found'
                        this.location.loading = false
                        return
                    }
                    this.data.state = zip.state
                    this.data.city = zip.city

                    const location = await this.nomitamin(this.data.street, this.data.zip)
                    if (! location) {
                        this.errors.street = 'Address Not Found'
                        this.location.loading = false
                        return
                    }
                    this.data.latitude = location.lat
                    this.data.longitude = location.lon
                    
                    this.createMap(this.data.latitude, this.data.longitude)

                    this.location.loading = false
                },
                async getZip(zip) {
                    try {
                        return await $.get(`/api/zips/${zip}`)
                    } catch {
                        return false
                    }
                },
                async nomitamin(street, zip) {
                    try {
                        let locations = await $.get(`https://nominatim.openstreetmap.org/search?street=${street}}&postalcode=${zip}&countrycodes=US&addressdetails=1&format=json`)
                        
                        locations = locations.filter(location => {
                            if (! location.address.postcode) {
                                return true
                            }

                            return location.address.postcode == zip
                        })

                        return locations[0] 
                    } catch {
                        return false
                    }
                },
                createMap(lat, lng) {
                    if (! this.location.map) {
                        this.location.map = L.map('location')
                            .setView([lat, lng], 15)
                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png')
                            .addTo(this.location.map)
                        window.dispatchEvent(new Event('resize'))
                    } else {
                        this.location.map.setView([lat, lng], 15)
                    }

                    if (! this.location.marker) {
                        this.location.marker = L.marker([lat, lng])
                        this.location.marker.addTo(this.location.map)
                    } else {
                        this.location.marker.setLatLng([lat, lng])
                    }
                },
                uploadImages(e) {
                    const files = e.target.files
                    for (let i = 0; i < files.length; i++) {
                        if (this.data.photos.length == this.images.count) {
                            break
                        }

                        if (files[i].size > this.images.size) {
                            continue
                        }

                        let photo = {
                            file: files[i],
                            status: 'loading',
                        }
                        
                        this.data.photos.push(photo)

                        this.uploadImage(photo.file, true)
                            .then(data => {
                                photo.id = data.id
                                photo.url = data.url
                                photo.status = 'loaded'
                                this.data.photos.forEach((item, i) => item.file == photo.file && this.data.photos.splice(i, 1))
                                this.data.photos.push({...photo})
                            }).catch(() => {
                                this.data.photos.forEach((item, i) => item.file == photo.file && this.data.photos.splice(i, 1))
                            })
                    }

                    $(e.target).val(null)
                },  
                uploadImage(img, watermark) {
                    const data = new FormData()
                    data.append('img', img)
                    data.append('watermark', watermark ? 1 : 0)
                    
                    return $.ajax({
                        type: 'POST',
                        url: '/images/upload',
                        data: data,
                        processData: false,
                        contentType: false,
                    })
                },
                moveUp(i) {
                    if (i == 0) {
                        return
                    }

                    const prev = this.data.photos[i-1]
                    this.data.photos[i-1] = this.data.photos[i]
                    this.data.photos[i] = prev
                },
                moveDown(i) {
                    if (i == this.data.photos.length-1) {
                        return
                    }

                    const next = this.data.photos[i+1]
                    this.data.photos[i+1] = this.data.photos[i]
                    this.data.photos[i] = next
                },
                remove(i) {
                    this.data.photos.forEach((photo, index) => index == i && this.data.photos.splice(i, 1))
                },
                uploadVerificationPhoto(e) {
                    const file = e.target.files[0]
                    const name = $(e.target).attr('name')

                    this.data[name] = {
                        file: file,
                        status: 'loading',
                    }

                    this.uploadImage(file, false)
                        .then(data => {
                            this.data[name].id = data.id
                            this.data[name].url = data.url
                            this.data[name].status = 'loaded'
                            this.data[name] = {...this.data[name]}
                        }).catch(() => {
                            this.data[name] = null
                        })
                },
                async send() {
                    this.loading = true

                    const data = this.formatData()

                    $.ajax({
                        type: 'POST',
                        url: '/my-profile',
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                    }).done(data => {
                        location.href = '/my-profile'
                    }).fail(jqXHR => {
                        alert(jqXHR.responseJSON.message)
                    }).always(() => {
                        this.loading = false
                    })
                },
                formatData() {
                    const data = {...this.data}
                    
                    data.photos = data.photos.map(photo => photo.id)
                    data.id_photo = data.id_photo?.id ?? null
                    data.verification_photo = data.verification_photo?.id ?? null
                    data.street_photo = data.street_photo?.id ?? null
                    
                    if (data.birthday) {
                        data.birthday = new Date(data.birthday).toISOString().split('T')[0]
                    }
                    
                    return data
                },
            }

            createApp(multistepForm).mount('#create-profile')
        </script>

        @verbatim
        <div class="form-container" id="create-profile">
            <form id="multiStepForm">
                <!-- Step 1 -->
                <div class="form-step active" data-step="1">
                    <div class="step-head">
                        <h2><span>1</span>Platform rules</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group rules">
                            <p class="title">Community rules and prohibitions</p>
                            <p>
                                Our platform is cool and safe. Fill out your profile. Our platform is cool and safe. Fill out your profile. Our platform is cool and safe. Fill out your profile.
                            </p>
                            <ul>
                                <li>
                                    1. Our platform is cool and safe. Fill out your profile.
                                </li>
                                <li>
                                    2. Our platform is cool and safe. Fill out your profile.
                                </li>
                                <li>
                                    3. Our platform is cool and safe. Fill out your profile.
                                </li>
                                <li>
                                    4. Our platform is cool and safe. Fill out your profile.
                                </li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button class="btn red next-btn" type="button" id="nextBtn1" @click="next(2)">
                                I Agree
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="form-step" data-step="2">
                    <div class="step-head">
                        <h2><span>2</span> Contact information</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <label for="phone">
                                    <img src="/assets/img/phone.svg" alt="" />
                                    Phone:*
                                </label>
                                <input
                                    type="text"
                                    id="tel"
                                    placeholder="(xxx) xxx-xxxx"
                                    required
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.phone"
                                    maxlength="14"
                                    @input="formatPhone"/>
                                <div v-if="errors.phone" class="error-text">
                                    {{ errors.phone }}
                                </div>
                            </div>

                            <div class="input-wrapper">
                                <label for="telegram">
                                    <img src="/assets/img/ic_outline-telegram.svg" alt="" />
                                    Telegram:
                                </label>
                                <input
                                    type="text"
                                    id="telegram"
                                    placeholder="@"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.telegram"/>
                            </div>

                            <div class="input-wrapper">
                                <label for="whatsapp">
                                    <img src="/assets/img/snapchat.svg" alt="" />
                                    Whatsapp:
                                </label>
                                <input
                                    type="text"
                                    id="whatsapp"
                                    placeholder="@"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.whatsapp"/>
                            </div>

                            <div class="input-wrapper">
                                <label for="snapchat">
                                    <img src="/assets/img/snapchat.svg" alt="" />
                                    Snapchat:
                                </label>
                                <input
                                    type="text"
                                    id="snapchat"
                                    placeholder="@"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.snapchat"/>
                            </div>

                            <div class="input-wrapper">
                                <label for="instagram">
                                    <img src="/assets/img/mdi_instagram.svg" alt="" />
                                    Instagram:
                                </label>
                                <input
                                    type="text"
                                    id="instagram"
                                    placeholder="@"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.instagram"/>
                            </div>

                            <div class="input-wrapper">
                                <label for="onlyfans">
                                    <img src="/assets/img/onlyfans.svg" alt="" />
                                    Onlyfans:
                                </label>
                                <input
                                    type="text"
                                    id="onlyfans"
                                    placeholder="@"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.onlyfans"/>
                            </div>

                            <div class="input-wrapper">
                                <label for="email">
                                    <img src="/assets/img/mail.svg" alt="" />
                                    Email:
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    placeholder="abc@gmail.com"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.profile_email"/>
                                <div v-if="errors.profile_email" class="error-text">
                                    {{ errors.profile_email }}
                                </div>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button class="btn red next-btn" type="button" id="nextBtn2" @click="next(3)">
                                Next step
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="form-step" data-step="3">
                    <div class="step-head">
                        <h2><span>3</span> Add location</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <label for="location">Street and house number:*</label>
                                <input 
                                    type="text" 
                                    id="street" 
                                    placeholder="Street and house number" 
                                    name="street"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.street" />
                                <div v-if="errors.street" class="error-text">
                                    {{ errors.street }}
                                </div>
                            </div>
                            
                            <div class="input-wrapper">
                                <label for="location">ZIP:*</label>
                                <input 
                                    type="text" 
                                    id="zip-code" 
                                    placeholder="ZIP" 
                                    name="zip"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.zip" />
                                <div v-if="errors.zip" class="error-text">
                                    {{ errors.zip }}
                                </div>
                            </div>

                            <div v-show="location.map" id="location" style="height: 300px;"></div>
                        </div>

                        <div class="btn-group">
                            <button v-if="!location.map" class="btn red" type="button" id="search-location" @click="next(4)">
                                <img v-if="location.loading" src="/assets/img/btn-loader.svg" alt="" class="loader" />
                                Search
                            </button>
                            <button v-if="location.map" class="btn" type="button" id="research-location" @click="next(4)">
                                <img v-if="location.loading" src="/assets/img/btn-loader.svg" alt="" class="loader" />
                                Research
                            </button>
                            <button v-if="data.latitude && data.longitude" class="btn red next-btn" type="button" id="nextBtn3" @click="step(4)">
                                Next step
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="form-step" data-step="4">
                    <div class="step-head">
                        <h2><span>4</span> About you</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <label for="name">Your name:*</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    placeholder="Name" 
                                    name="name"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.name" />
                                <div v-if="errors.name" class="error-text">
                                    {{ errors.name }}
                                </div>
                            </div>

                            <div class="input-wrapper">
                                <label for="age">Your age:*</label>
                                <input 
                                    type="text" 
                                    id="age" 
                                    placeholder="Age" 
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.age" />
                                <div v-if="errors.age" class="error-text">
                                    {{ errors.age }}
                                </div>
                            </div>
                            
                            <div class="input-wrapper">
                                <label for="city">Your city:*</label>
                                <input 
                                    type="text" 
                                    id="city" 
                                    placeholder="City" 
                                    readonly
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.city"/>
                                <div v-if="errors.city" class="error-text">
                                    {{ errors.city }}
                                </div>
                            </div>

                            <div class="input-wrapper">
                                <label for="description">Description:*</label>
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    placeholder="Description" 
                                    maxlength="150"
                                    v-model="data.description"></textarea>
                                <p class="rule">No more than 150 characters</p>
                                <div v-if="errors.description" class="error-text">
                                    {{ errors.description }}
                                </div>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button class="btn red next-btn" type="button" id="nextBtn4" @click="next(5)">
                                Next step
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="form-step" data-step="5">
                    <div class="step-head">
                        <h2><span>5</span> Add photo</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">
                            <div class="photo-container">
                                <p>
                                    Maximum number of photos: 12
                                    <br />
                                    <span>.jpeg, .png, .webp, .heic, up to 10MB</span>
                                </p>

                                <input 
                                    type="file" 
                                    id="photoInput" 
                                    accept=".jpg,.jpeg,.jpe,.jif,.jfif,.jfi,.png',.webp,.heif,.heifs,.heic,.heics,.avci,.avcs,.HIF"
                                    multiple 
                                    hidden
                                    @change="uploadImages"/>
                                
                                <button v-if="data.photos.length == 0" id="customButton1" type="button" class="btn red" @click="$('#photoInput').click()">
                                    Add photo
                                </button>

                                <img src="/assets/img/img-loading.webp" style="display: none;" alt="">

                                <div id="photos">

                                    <div v-for="(photo, i) in data.photos" style="position: relative; display: inline-block;">
                                        <img :src="photo.status == 'loaded' ? photo.url : '/assets/img/img-loading.webp'">
                                        <button class="move-button move-up" type="button" @click="moveUp(i)">↑</button>
                                        <button class="move-button move-down" type="button" @click="moveDown(i)">↓</button>
                                        <span :class="{'remove-photo': true, 'none': photo.status == 'loading'}" @click="remove(i)">×</span>
                                    </div>

                                </div>
                            </div>

                            <div v-if="data.photos.length >= 1" class="photo-count" id="photoCount">
                                Available number of photos: {{ data.photos.length }}/12
                            </div>
                            
                            <div class="btn-group">
                                <button v-if="data.photos.length >= 1 && data.photos.length < 12" id="customButton2" type="button" class="btn" @click="$('#photoInput').click()">
                                    Add photo
                                </button>
                                <button v-if="data.photos.length >= 1" class="btn red next-btn" type="button" id="nextBtn5" @click="next(6)">
                                    Next step
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 6 -->
                <div class="form-step step-6" data-step="6">
                    <div class="step-head">
                        <h2><span>6</span> Verification</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">
                            <ol>
                                <li>1. Photos must be clear.</li>
                                <li>2. Photos must be uncropped.</li>
                                <li>3. Photos must be unaltered.</li>
                            </ol>

                            <div class="verification-section">
                                <label for="document-photo">Photo of the document (driver's license)*</label>
                                <div class="image-card">
                                    <img v-if="!data.id_photo" src="/assets/img/person-doc.jpeg" alt=""/>
                                    <img v-if="data.id_photo" :src="data.id_photo.status == 'loaded' ? data.id_photo.url : '/assets/img/img-loading.webp'" alt="">
                                </div>
                                <input
                                    type="file"
                                    id="document-photo"
                                    accept=".jpg,.jpeg,.jpe,.jif,.jfif,.jfi,.png',.webp,.heif,.heifs,.heic,.heics,.avci,.avcs,.HIF"
                                    style="display: none"
                                    name="id_photo"
                                    @change="uploadVerificationPhoto"/>
                                <div class="btn-group">
                                <button
                                    v-if="!data.id_photo"
                                    type="button"
                                    class="custom-upload-btn"
                                    data-input="document-photo"
                                    @click="$('#document-photo').click()">
                                    Upload Photo 
                                    <img src="/assets/img/attach.svg" alt="" />
                                </button>
                                <button
                                    v-if="data.id_photo"
                                    type="button"
                                    class="custom-remove-btn"
                                    data-img="document-photo-img"
                                    @click="data.id_photo = null">
                                    Remove Photo
                                </button>
                                </div>
                            </div>

                            <div class="verification-section">
                                <label for="permission-photo">A photo with "I give permission to use this photo"*</label>
                                <div class="image-card">
                                    <img v-if="!data.verification_photo" src="/assets/img/person-doc.jpeg" alt=""/>
                                    <img v-if="data.verification_photo" :src="data.verification_photo.status == 'loaded' ? data.verification_photo.url : '/assets/img/img-loading.webp'" alt="">
                                </div>
                                <input
                                    type="file"
                                    id="permission-photo"
                                    accept=".jpg,.jpeg,.jpe,.jif,.jfif,.jfi,.png',.webp,.heif,.heifs,.heic,.heics,.avci,.avcs,.HIF"
                                    style="display: none"
                                    name="verification_photo"
                                    @change="uploadVerificationPhoto"/>
                                <div class="btn-group">
                                    <button
                                        v-if="!data.verification_photo"
                                        type="button"
                                        class="custom-upload-btn"
                                        data-input="permission-photo"
                                        @click="$('#permission-photo').click()">
                                        Upload Photo 
                                        <img id="permission-photo-img" src="/assets/img/attach.svg" alt=""/>
                                    </button>
                                    <button
                                        v-if="data.verification_photo"
                                        type="button"
                                        class="custom-remove-btn"
                                        data-img="permission-photo-img"
                                        @click="data.verification_photo = null">
                                        Remove Photo
                                    </button>
                                </div>
                            </div>

                            <div class="verification-section">
                                <label for="street-photo">Street photo*</label>
                                <div class="image-card">
                                    <img v-if="!data.street_photo" src="/assets/img/person-doc.jpeg" alt=""/>
                                    <img v-if="data.street_photo" :src="data.street_photo.status == 'loaded' ? data.street_photo.url : '/assets/img/img-loading.webp'" alt="">
                                </div>
                                <input 
                                    type="file" 
                                    id="street-photo" 
                                    accept=".jpg,.jpeg,.jpe,.jif,.jfif,.jfi,.png',.webp,.heif,.heifs,.heic,.heics,.avci,.avcs,.HIF"
                                    style="display: none" 
                                    name="street_photo"
                                    @change="uploadVerificationPhoto" />
                                <div class="btn-group">
                                    <button 
                                        v-if="!data.street_photo" 
                                        type="button" 
                                        class="custom-upload-btn" 
                                        data-input="street-photo" 
                                        @click="$('#street-photo').click()">
                                        Upload Photo 
                                        <img src="/assets/img/attach.svg" alt="" />
                                    </button>
                                    <button 
                                        v-if="data.street_photo" 
                                        type="button" 
                                        class="custom-remove-btn"
                                        data-img="street-photo-img" 
                                        @click="data.street_photo = null">
                                        Remove Photo
                                    </button>
                                </div>
                            </div>

                            <div class="user-info-section">
                                <div class="input-wrapper">
                                    <label for="first-name">First name*</label>
                                    <input 
                                        type="text" 
                                        id="first-name" 
                                        name="first-name" 
                                        required 
                                        placeholder="Name"
                                        onkeydown="return event.key != 'Enter'"
                                        v-model="data.first_name" />
                                    <div v-if="errors.first_name" class="error-text">
                                        {{ errors.first_name }}
                                    </div>
                                </div>
                                <div class="input-wrapper">
                                    <label for="last-name">Last name*</label>
                                    <input 
                                        type="text" 
                                        id="last-name" 
                                        name="last-name" 
                                        required 
                                        onkeydown="return event.key != 'Enter'"
                                        placeholder="Name"
                                        v-model="data.last_name" />
                                    <div v-if="errors.last_name" class="error-text">
                                        {{ errors.last_name }}
                                    </div>
                                </div>

                                <div class="input-wrapper">
                                    <label for="dob">Date of birth*</label>
                                    <input 
                                        type="text"
                                        id="dob" 
                                        name="dob" 
                                        placeholder="06/22/2024" 
                                        maxlength="10"
                                        onkeydown="return event.key != 'Enter'"
                                        v-model="data.birthday" />
                                    <div v-if="errors.birthday" class="error-text">
                                        {{ errors.birthday }}
                                    </div>
                                </div>
                            </div>

                            <div class="btn-group">
                                <button class="btn red next-btn" type="button" id="nextBtn6" @click="next(7)">
                                    Next step
                                </button>
                                <button class="btn next-btn" type="button" id="skip" @click="step(7)">
                                    Skip
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 7 -->
                <div class="form-step" data-step="7">
                    <div class="step-head">
                        <h2><span>7</span> Sending for approval</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">
                            <p class="text">
                                Our platform is cool and safe. Fill out your profile. Our platform is cool and safe. Fill out your profile. Our platform is cool and safe. Fill out your profile. Our platform is cool and safe. Fill out your profile. Our platform is cool and safe. Fill
                                out your profile. Our platform is cool and safe. Fill out your profile. Our platform is cool and safe. Fill out your profile. Our platform is cool and safe. Fill out your profile. Our platform is cool and safe. Fill out
                                your profile. Our platform is cool and safe. Fill out your profile. Our platform is cool and safe. Fill out your profile. Our platform is cool and safe. Fill out your profile.
                            </p>
                        </div>
                        <div class="btn-group">
                            <button class="btn red" @click.stop.prevent="send">
                                <img v-if="loading" src="/assets/img/btn-loader.svg" alt="" class="loader" />
                                Confirm
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endverbatim

    </div>
</section>

@include('templates.footer')