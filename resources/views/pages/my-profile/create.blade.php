@include('templates.header')

<section class="profile-filling">
    <div class="container">
        
        @include('templates.options')

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        
        <script type="module">
            import { createApp } from 'https://unpkg.com/petite-vue?module'

            const createForm = {
                data: {
                    phone: '',
                    telegram: '',
                    whatsapp: '',
                    instagram: '',
                    snapchat: '',
                    onlyfans: '',
                    profile_email: '',

                    street: '',
                    zip: '',
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
                    ['phone', 'telegram', 'whatsapp', 'instagram', 'snapchat', 'onlyfans', 'profile_email',],
                    ['zip', 'street', 'latitude', 'longitude',],
                    ['name', 'age', 'description',],
                    ['photos',],
                    ['id_photo', 'verification_photo', 'street_photo', 'first_name', 'last_name', 'birthday',],
                    [],
                ],
                rules: {
                    phone: [
                        {
                            message: 'One from Phone, Telegram, Whatsapp fields required',
                            fn: (val, data) => Boolean(val || data.telegram || data.whatsapp),
                        },
                        {
                            message: 'Invalid format',
                            fn: val => Boolean(! val || val.match(/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/))
                        },
                    ],
                    telegram: [
                        {
                            message: 'One from Phone, Telegram, Whatsapp fields required',
                            fn: (val, data) => Boolean(val || data.phone || data.whatsapp),
                        },
                    ],
                    whatsapp: [
                        {
                            message: 'One from Phone, Telegram, Whatsapp fields required',
                            fn: (val, data) => Boolean(val || data.phone || data.telegram),
                        },
                    ],
                    profile_email: [
                        {
                            message: 'Invalid format',
                            fn: val => Boolean(! val || val.match(/^\S+@\S+\.\S+$/))
                        },
                    ],

                    street: [
                        {
                            message: 'Street required',
                            fn: val => Boolean(val),
                        },
                    ],
                    zip: [
                        {
                            message: 'ZIP Code required',
                            fn: val => Boolean(val),
                        },
                        {
                            message: 'ZIP Code invalid',
                            fn: val => Boolean(val.match(/^[0-9]{5}$/)), 
                        },
                    ],
                    latitude: [
                        {
                            message: 'Latitude required',
                            fn: val => Boolean(val),
                        },
                    ],
                    longitude: [
                        {
                            message: 'Longitude required',
                            fn: val => Boolean(val),
                        },
                    ],
                    
                    name: [
                        {
                            message: 'Name required',
                            fn: val => Boolean(val),
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
                            fn: val => Boolean(val),
                        },
                        {
                            message: 'Invalid age',
                            fn: val => ! isNaN(val),
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
                    description: [
                        {
                            message: 'Description required',
                            fn: val => Boolean(val),
                        },
                        {
                            message: 'Must be 50-150 words',
                            fn: val => val.length >= 50 && val.length <= 150
                        },
                    ],

                    photos: [
                        {
                            message: 'Photos required',
                            fn: val => val.length >= 1,
                        },
                    ],
                    
                    id_photo: [
                        {
                            message: 'Photo required',
                            fn: (val, data) => {
                                if (
                                    ! data.verification_photo && 
                                    ! data.street_photo && 
                                    ! data.first_name &&
                                    ! data.last_name &&
                                    ! data.birthday
                                ) {
                                    return true
                                }

                                return Boolean(val)
                            },
                        },
                    ],
                    verification_photo: [
                        {
                            message: 'Photo required',
                            fn: (val, data) => {
                                if (
                                    ! data.id_photo && 
                                    ! data.street_photo && 
                                    ! data.first_name &&
                                    ! data.last_name &&
                                    ! data.birthday
                                ) {
                                    return true
                                }

                                return Boolean(val)
                            },
                        },
                    ],
                    street_photo: [
                        {
                            message: 'Photo required',
                            fn: (val, data) => {
                                if (
                                    ! data.id_photo && 
                                    ! data.verification_photo && 
                                    ! data.first_name &&
                                    ! data.last_name &&
                                    ! data.birthday
                                ) {
                                    return true
                                }

                                return Boolean(val)
                            },
                        },
                    ],
                    first_name: [
                        {
                            message: 'First name required',
                            fn: (val, data) => {
                                if (
                                    ! data.id_photo && 
                                    ! data.verification_photo && 
                                    ! data.street_photo &&
                                    ! data.last_name &&
                                    ! data.birthday
                                ) {
                                    return true
                                }

                                return Boolean(val)
                            },
                        },
                        {
                            message: 'At least 2 letters',
                            fn: val => Boolean(! val || val.length >= 2),
                        },
                    ],
                    last_name: [
                        {
                            message: 'Last name required',
                            fn: (val, data) => {
                                if (
                                    ! data.id_photo && 
                                    ! data.verification_photo && 
                                    ! data.street_photo &&
                                    ! data.first_name &&
                                    ! data.birthday
                                ) {
                                    return true
                                }

                                return Boolean(val)
                            },
                        },
                        {
                            message: 'At least 2 letters',
                            fn: val => Boolean(! val || val.length >= 2),
                        },
                    ],
                    birthday: [
                        {
                            message: 'Last name required',
                            fn: (val, data) => {
                                if (
                                    ! data.id_photo && 
                                    ! data.verification_photo && 
                                    ! data.street_photo &&
                                    ! data.first_name &&
                                    ! data.last_name
                                ) {
                                    return true
                                }

                                return Boolean(val)
                            },
                        },
                    ],
                },
                errors: {},
                location: {
                    map: null,
                    marker: null,
                    loading: false,
                },
                genders: ['Man', 'Woman', 'LGBTQIA+',],
                loading: false,

                next(i) {
                    const fields = this.steps[i]

                    fields.forEach(field => delete this.errors[field])

                    let valid = true
                    fields.forEach(field => this.validate(field) || (valid = false))
                    
                    if (! valid) {
                        return
                    }

                    this.toStep(i+1)
                },
                validate(field) {
                    for (const rule of this.rules[field] ?? []) {
                        const valid = rule.fn(this.data[field], this.data)

                        if (! valid) {
                            this.errors[field] = rule.message

                            return false
                        }
                    }

                    return true
                },
                toStep(i) {
                    const step = $(`[data-step=${i}]`)
                    step.addClass('active')
                    
                    const offset = step[0].offsetTop - $('#header').height()
                    window.scrollTo({top: offset, behavior: 'smooth',})
                },

                formatPhone(e) {
                    const phone = $(e.target).val()
                        .replace(/\D/g, '')
                        .match(/(\d{0,3})(\d{0,3})(\d{0,4})/)
                    this.data.phone =
                        ! phone[2] ? 
                        phone[1] : 
                        '(' + phone[1] + ') ' + phone[2] + (phone[3] ? '-' + phone[3] : '')
                },

                async search() {
                    this.location.loading = true

                    const fields = ['street', 'zip',]

                    fields.forEach(field => delete this.errors[field])

                    let valid = true
                    fields.forEach(field => this.validate(field) || (valid = false))
                   
                    if (valid) {
                        const location = await this.nomitamin(this.data.street, this.data.zip)

                        if (location) {
                            this.data.latitude = parseFloat(location.lat).toFixed(7)
                            this.data.longitude = parseFloat(location.lon).toFixed(7)

                            this.createMap(this.data.latitude, this.data.longitude)   
                        } else {
                            this.errors.street = 'Address Not Found'
                        }
                    }

                    this.location.loading = false
                },
                async nomitamin(street, zip) {
                    try {
                        const params = new URLSearchParams({
                            street: street,
                            postalcode: zip,
                            countrycodes: 'US',
                            addressdetails: 1,
                            format: 'json',
                        })

                        let res = await $.get(`https://nominatim.openstreetmap.org/search?${params.toString()}`)

                        res = res.filter(l => l.address.postcode == zip)

                        return res[0]
                    } catch {
                        return false
                    }
                },
                createMap(lat, lng) {
                    if (this.location.map) {
                        this.location.map.setView([lat, lng], 15)
                    } else {
                        this.location.map = L.map('location')
                        this.location.map.setView([lat, lng], 15)

                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.location.map)

                        window.dispatchEvent(new Event('resize'))
                    }

                    if (this.location.marker) {
                        this.location.marker.setLatLng([lat, lng])
                    } else {
                        this.location.marker = L.marker([lat, lng])
                        this.location.marker.addTo(this.location.map)
                    }
                },

                async uploadImage(img, watermark) {
                    const data = new FormData()
                    data.append('img', img)
                    data.append('watermark', watermark ? 1 : 0)
                    data.append('recaptcha', await getReCaptchaV3('upload_image'))
                    
                    return $.ajax({
                        type: 'POST',
                        url: '/images/upload',
                        data: data,
                        processData: false,
                        contentType: false,
                    })
                },
                deleteImage(id) {
                    return $.ajax({
                        type: 'DELETE',
                        url: `/images/${id}`,
                    })
                },

                async uploadPhotos(e) {
                    const files = e.target.files
                    for (let i = 0; i < files.length; i++) {
                        if (this.data.photos.length == 12) {
                            break
                        }

                        if (files[i].size > 10 * 1024 * 1024) {
                            continue
                        }

                        let photo = {
                            file: files[i],
                            status: 'loading',
                        }
                        
                        this.data.photos.push(photo)

                        await this.uploadImage(photo.file, true)
                            .then(data => {
                                photo.id = data.id
                                photo.url = data.url
                                photo.status = 'loaded'

                                this.data.photos.forEach((item, i) => item.file == photo.file && this.data.photos.splice(i, 1))
                                this.data.photos.push({...photo})
                            }).catch(jqXHR => {
                                this.errors.photos = jqXHR.responseJSON?.message

                                this.data.photos.forEach((item, i) => item.file == photo.file && this.data.photos.splice(i, 1))
                            })
                    }

                    $(e.target).val(null)
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
                    this.deleteImage(this.data.photos[i].id)

                    this.data.photos.splice(i, 1)
                },
                
                uploadVerificationPhoto(photo) {
                    const file = $(`[name=${photo}]`)[0].files[0]

                    this.data[photo] = {
                        file: file,
                        status: 'loading',
                    }

                    this.uploadImage(file, false)
                        .then(data => {
                            this.data[photo].id = data.id
                            this.data[photo].url = data.url
                            this.data[photo].status = 'loaded'
                        }).catch(jqXHR => {
                            this.errors[photo] = jqXHR.responseJSON?.message

                            this.data[photo] = null
                        })
                },
                removeVerificationPhoto(photo) {    
                    this.deleteImage(this.data[photo].id)

                    this.data[photo] = null
                },

                async getData() {
                    const data = JSON.parse(JSON.stringify(this.data))

                    data.photos = data.photos.map(photo => photo.id)
                    
                    data.id_photo = data.id_photo?.id ?? null
                    data.verification_photo = data.verification_photo?.id ?? null
                    data.street_photo = data.street_photo?.id ?? null

                    data.recaptcha = await getReCaptchaV3('create_profile')
                    
                    return data
                },
                scrollToError() {
                    for (let i = 0; i < this.steps.length; i++) {
                        for (const field of this.steps[i]) {
                            if (field in this.errors) {
                                this.toStep(i)
                                return
                            }
                        }
                    }
                },
                async send() {
                    this.loading = true

                    const data = await this.getData()

                    $.ajax({
                        type: 'POST',
                        url: '/my-profile',
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                    }).done(() => {
                        location.href = '/my-profile'
                    }).fail(jqXHR => {
                        if (jqXHR.status == 422) {
                            this.errors = {}
                            
                            const errors = jqXHR.responseJSON.errors
                            for (const field in errors) {
                                this.errors[field] = errors[field][0]    
                            }

                            this.scrollToError()
                        } else {
                            alert(jqXHR.responseJSON.message)
                        }
                    }).always(() => {
                        this.loading = false
                    })
                },
            }

            createApp(createForm).mount('#create-profile')
        </script>

        @verbatim
        <div class="form-container" id="create-profile">
            <form id="multiStepForm">

                <!-- Step 1 -->
                <div class="form-step active" data-step="0">
                    <div class="step-head">
                        <h2><span>1</span>Platform rules</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group rules">
                            <p class="title">
                                Community rules and prohibitions
                            </p>
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
                            <button 
                                class="btn red next-btn" 
                                type="button" 
                                id="nextBtn1" 
                                @click="next(0)">
                                I Agree
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="form-step" data-step="1">
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
                                    id="phone"
                                    placeholder="(xxx) xxx-xxxx"
                                    maxlength="14"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.phone"
                                    @input="formatPhone"/>
                                <div v-if="errors.phone" class="error-text">
                                    {{ errors.phone }}
                                </div>
                            </div>

                            <div class="input-wrapper">
                                <label for="telegram">
                                    <img src="/assets/img/ic_outline-telegram.svg" alt="" />
                                    Telegram:*
                                </label>
                                <input
                                    type="text"
                                    id="telegram"
                                    placeholder="@"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.telegram"/>
                                <div v-if="errors.telegram" class="error-text">
                                    {{ errors.telegram }}
                                </div>
                            </div>

                            <div class="input-wrapper">
                                <label for="whatsapp">
                                    <img src="/assets/img/snapchat.svg" alt="" />
                                    Whatsapp:*
                                </label>
                                <input
                                    type="text"
                                    id="whatsapp"
                                    placeholder="@"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.whatsapp"/>
                                <div v-if="errors.whatsapp" class="error-text">
                                    {{ errors.whatsapp }}
                                </div>
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
                                <div v-if="errors.snapchat" class="error-text">
                                    {{ errors.snapchat }}
                                </div>
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
                                <div v-if="errors.instagram" class="error-text">
                                    {{ errors.instagram }}
                                </div>
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
                                <div v-if="errors.onlyfans" class="error-text">
                                    {{ errors.onlyfans }}
                                </div>
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
                            <button 
                                class="btn red next-btn" 
                                type="button" 
                                id="nextBtn2" 
                                @click="next(1)">
                                Next step
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="form-step" data-step="2">
                    <div class="step-head">
                        <h2><span>3</span> Add location</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">

                            <div class="input-wrapper">
                                <label for="location">
                                    Street and house number:*
                                </label>
                                <input 
                                    type="text" 
                                    id="street" 
                                    placeholder="Street and house number" 
                                    name="street"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.street"
                                    @change="data.latitude = null; data.longitude = null" />
                                <div v-if="errors.street" class="error-text">
                                    {{ errors.street }}
                                </div>
                            </div>
                            
                            <div class="input-wrapper">
                                <label for="location">
                                    ZIP:*
                                </label>
                                <input 
                                    type="text" 
                                    id="zip-code" 
                                    placeholder="ZIP" 
                                    name="zip"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.zip"
                                    @change="data.latitude = null; data.longitude = null" />
                                <div v-if="errors.zip" class="error-text">
                                    {{ errors.zip }}
                                </div>
                            </div>

                            <div v-show="data.latitude && data.longitude" id="location" style="height: 300px;"></div>

                        </div>

                        <div class="btn-group">

                            <button 
                                v-if="! data.latitude && ! data.longitude" 
                                class="btn red" 
                                type="button" 
                                id="search-location" 
                                @click="search">
                                <img v-if="location.loading" src="/assets/img/btn-loader.svg" class="loader" alt="" />
                                Search
                            </button>

                            <button 
                                v-if="data.latitude && data.longitude" 
                                class="btn" 
                                type="button" 
                                id="research-location" 
                                @click="search">
                                <img v-if="location.loading" src="/assets/img/btn-loader.svg" class="loader" alt="" />
                                Research
                            </button>

                            <button 
                                v-if="data.street && data.zip && data.latitude && data.longitude"
                                class="btn red next-btn" 
                                type="button" 
                                id="nextBtn3" 
                                @click="next(2)">
                                Next step
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="form-step" data-step="3">
                    <div class="step-head">
                        <h2><span>4</span> About you</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">
                            
                            <div class="input-wrapper">
                                <label for="name">
                                    Your name:*
                                </label>
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
                                <label for="age">
                                    Your age:*
                                </label>
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
                                <label for="gender">
                                    Your gender:
                                </label>
                                <select 
                                    id="gender" 
                                    name="gender" 
                                    v-model="data.gender">
                                    
                                    <option 
                                        v-for="gender in genders"
                                        :value="gender">
                                        {{ gender }}
                                    </option>

                                </select>
                                <div v-if="errors.gender" class="error-text">
                                    {{ errors.gender }}
                                </div>
                            </div>

                            <div class="input-wrapper">
                                <label for="description">
                                    Description:*
                                </label>
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    placeholder="Description" 
                                    maxlength="150"
                                    v-model="data.description"></textarea>
                                <p class="rule">
                                    No more than 150 characters
                                </p>
                                <div v-if="errors.description" class="error-text">
                                    {{ errors.description }}
                                </div>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button 
                                class="btn red next-btn"
                                type="button" 
                                id="nextBtn4" 
                                @click="next(3)">
                                Next step
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="form-step" data-step="4">
                    <div class="step-head">
                        <h2><span>5</span> Add photo</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">
                            <div class="photo-container">
                                <p>
                                    Maximum number of photos: 12
                                    <br />
                                    <span>.jpeg, .webp, .heic, up to 10MB</span>
                                </p>

                                <input 
                                    type="file" 
                                    id="photoInput" 
                                    accept=".jpg,.jpeg,.jpe,.jif,.jfif,.jfi,.png',.webp,.heif,.heifs,.heic,.heics,.avci,.avcs,.HIF"
                                    multiple 
                                    hidden
                                    @change="uploadPhotos"/>
                                
                                <button 
                                    v-if="data.photos.length == 0" 
                                    id="customButton1" 
                                    type="button" 
                                    class="btn red" 
                                    @click="$('#photoInput').click()">
                                    Add photo
                                </button>

                                <div id="photos">

                                    <div 
                                        v-for="(photo, i) in data.photos" 
                                        style="position: relative; display: inline-block;">

                                        <img 
                                            v-if="photo.status == 'loaded'" 
                                            :src="photo.url">
                                        <img 
                                            v-if="photo.status == 'loading'" 
                                            src="/assets/img/img-loading.webp">

                                        <button 
                                            class="move-button move-up" 
                                            type="button" 
                                            @click="moveUp(i)">↑</button>
                                        <button 
                                            class="move-button move-down" 
                                            type="button" 
                                            @click="moveDown(i)">↓</button>
                                        
                                        <span 
                                            :class="{'remove-photo': true, 'none': photo.status == 'loading'}" 
                                            @click="remove(i)">×</span>
                                    
                                    </div>

                                </div>
                            </div>

                            <div v-if="data.photos.length >= 1" class="photo-count" id="photoCount">
                                Available number of photos: {{ data.photos.length }}/12
                            </div>

                            <div v-if="errors.photos" class="form-error">
                                {{ errors.photos }}
                            </div>
                            
                            <div class="btn-group">

                                <button 
                                    v-if="data.photos.length >= 1 && data.photos.length < 12" 
                                    id="customButton2" 
                                    type="button" 
                                    class="btn" 
                                    @click="$('#photoInput').click()">
                                    Add photo
                                </button>

                                <button 
                                    v-if="data.photos.length >= 1" 
                                    class="btn red next-btn" 
                                    type="button" 
                                    id="nextBtn5" 
                                    @click="next(4)">
                                    Next step
                                </button>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 6 -->
                <div class="form-step step-6" data-step="5">
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
                                <label for="document-photo">
                                    Photo of the document (driver's license)*
                                </label>

                                <div class="image-card">
                                    <img 
                                        v-if="! data.id_photo" 
                                        src="/assets/img/person-doc.jpeg" 
                                        alt=""/>
                                    <img 
                                        v-if="data.id_photo?.status == 'loading'"
                                        src="/assets/img/img-loading.webp" 
                                        alt="">
                                    <img 
                                        v-if="data.id_photo?.status == 'loaded'"
                                        :src="data.id_photo?.url" 
                                        alt="">
                                </div>

                                <div v-if="errors.id_photo" class="form-error">
                                    {{ errors.id_photo }}
                                </div>

                                <input
                                    type="file"
                                    id="document-photo"
                                    accept=".jpg,.jpeg,.jpe,.jif,.jfif,.jfi,.png',.webp,.heif,.heifs,.heic,.heics,.avci,.avcs,.HIF"
                                    style="display: none"
                                    name="id_photo"
                                    @change="uploadVerificationPhoto('id_photo')"/>

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
                                        @click="removeVerificationPhoto('id_photo')">
                                        Remove Photo
                                    </button>

                                </div>
                            </div>

                            <div class="verification-section">
                                <label for="permission-photo">
                                    A photo with "I give permission to use this photo"*
                                </label>
                                
                                <div class="image-card">
                                    <img 
                                        v-if="! data.verification_photo" 
                                        src="/assets/img/person-doc.jpeg" 
                                        alt=""/>
                                    <img 
                                        v-if="data.verification_photo?.status == 'loading'"
                                        src="/assets/img/img-loading.webp" 
                                        alt="">
                                    <img 
                                        v-if="data.verification_photo?.status == 'loaded'"
                                        :src="data.verification_photo?.url" 
                                        alt="">
                                </div>
                                
                                <div v-if="errors.verification_photo" class="form-error">
                                    {{ errors.verification_photo }}
                                </div>

                                <input
                                    type="file"
                                    id="permission-photo"
                                    accept=".jpg,.jpeg,.jpe,.jif,.jfif,.jfi,.png',.webp,.heif,.heifs,.heic,.heics,.avci,.avcs,.HIF"
                                    style="display: none"
                                    name="verification_photo"
                                    @change="uploadVerificationPhoto('verification_photo')"/>

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
                                        @click="removeVerificationPhoto('verification_photo')">
                                        Remove Photo
                                    </button>

                                </div>
                            </div>

                            <div class="verification-section">
                                <label for="street-photo">
                                    Street photo*
                                </label>
                                
                                <div class="image-card">
                                    <img 
                                        v-if="! data.street_photo" 
                                        src="/assets/img/person-doc.jpeg" 
                                        alt=""/>
                                    <img 
                                        v-if="data.street_photo?.status == 'loading'"
                                        src="/assets/img/img-loading.webp" 
                                        alt="">
                                    <img 
                                        v-if="data.street_photo?.status == 'loaded'"
                                        :src="data.street_photo?.url" 
                                        alt="">
                                </div>
                                
                                <div v-if="errors.street_photo" class="form-error">
                                    {{ errors.street_photo }}
                                </div>

                                <input 
                                    type="file" 
                                    id="street-photo" 
                                    accept=".jpg,.jpeg,.jpe,.jif,.jfif,.jfi,.png',.webp,.heif,.heifs,.heic,.heics,.avci,.avcs,.HIF"
                                    style="display: none" 
                                    name="street_photo"
                                    @change="uploadVerificationPhoto('street_photo')" />

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
                                        @click="removeVerificationPhoto('street_photo')">
                                        Remove Photo
                                    </button>

                                </div>
                            </div>

                            <div class="user-info-section">

                                <div class="input-wrapper">
                                    <label for="first-name">
                                        First name*
                                    </label>
                                    <input 
                                        type="text" 
                                        id="first-name" 
                                        name="first-name" 
                                        placeholder="Name"
                                        onkeydown="return event.key != 'Enter'"
                                        v-model="data.first_name" />
                                    <div v-if="errors.first_name" class="error-text">
                                        {{ errors.first_name }}
                                    </div>
                                </div>

                                <div class="input-wrapper">
                                    <label for="last-name">
                                        Last name*
                                    </label>
                                    <input 
                                        type="text" 
                                        id="last-name" 
                                        name="last-name" 
                                        onkeydown="return event.key != 'Enter'"
                                        placeholder="Name"
                                        v-model="data.last_name" />
                                    <div v-if="errors.last_name" class="error-text">
                                        {{ errors.last_name }}
                                    </div>
                                </div>

                                <div class="input-wrapper">
                                    <label for="dob">
                                        Date of birth*
                                    </label>
                                    <input 
                                        type="date"
                                        id="dob" 
                                        name="dob" 
                                        onkeydown="return event.key != 'Enter'"
                                        v-model="data.birthday" />
                                    <div v-if="errors.birthday" class="error-text">
                                        {{ errors.birthday }}
                                    </div>
                                </div>

                            </div>

                            <div class="btn-group">
                                
                                <button 
                                    class="btn next-btn" 
                                    type="button" 
                                    id="skip" 
                                    @click="toStep(6)">
                                    Skip
                                </button>

                                <button 
                                    class="btn red next-btn" 
                                    type="button" 
                                    id="nextBtn6" 
                                    @click="next(5)">
                                    Next step
                                </button>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 7 -->
                <div class="form-step" data-step="6">
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
                            <button 
                                class="btn red" 
                                @click.stop.prevent="send">
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