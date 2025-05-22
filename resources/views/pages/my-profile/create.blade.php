@include('templates.header', ['title' => 'Create post',])

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
                    twitter: '',

                    zip: '',
                    
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
                    ['phone', 'telegram', 'whatsapp', 'instagram', 'snapchat', 'onlyfans', 'profile_email', 'twitter',],
                    ['zip',],
                    ['name', 'age', 'description',],
                    ['photos',],
                    ['id_photo', 'verification_photo', 'street_photo', 'first_name', 'last_name', 'birthday',],
                    [],
                ],
                rules: {
                    phone: [
                        {
                            message: 'One from contact fields required',
                            fn: (val, data) => Boolean(val || data.telegram || data.whatsapp || data.instagram || data.snapchat || data.onlyfans || data.profile_email),
                        },
                        {
                            message: 'Invalid format',
                            fn: val => Boolean(! val || val.match(/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/))
                        },
                    ],
                    telegram: [
                        {
                            message: 'One from contact fields required',
                            fn: (val, data) => Boolean(val || data.phone || data.whatsapp || data.instagram || data.snapchat || data.onlyfans || data.profile_email || data.twitter),
                        },
                    ],
                    whatsapp: [
                        {
                            message: 'One from contact fields required',
                            fn: (val, data) => Boolean(val || data.phone || data.telegram || data.instagram || data.snapchat || data.onlyfans || data.profile_email || data.twitter),
                        },
                    ],
                    instagram: [
                        {
                            message: 'One from contact fields required',
                            fn: (val, data) => Boolean(val || data.phone || data.telegram || data.whatsapp || data.snapchat || data.onlyfans || data.profile_email || data.twitter),
                        },
                    ],
                    snapchat: [
                        {
                            message: 'One from contact fields required',
                            fn: (val, data) => Boolean(val || data.phone || data.telegram || data.whatsapp || data.instagram || data.onlyfans || data.profile_email || data.twitter),
                        },
                    ],
                    onlyfans: [
                        {
                            message: 'One from contact fields required',
                            fn: (val, data) => Boolean(val || data.phone || data.telegram || data.whatsapp || data.instagram || data.snapchat || data.profile_email || data.twitter),
                        },
                    ],
                    profile_email: [
                        {
                            message: 'One from contact fields required',
                            fn: (val, data) => Boolean(val || data.phone || data.telegram || data.whatsapp || data.instagram || data.snapchat || data.onlyfans || data.twitter),
                        },
                        {
                            message: 'Invalid format',
                            fn: val => Boolean(! val || val.match(/^\S+@\S+\.\S+$/))
                        },
                    ],
                    twitter: [
                        {
                            message: 'One from contact fields required',
                            fn: (val, data) => Boolean(val || data.phone || data.telegram || data.whatsapp || data.instagram || data.snapchat || data.onlyfans || data.profile_email),
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
                            message: 'Up to 12 letters',
                            fn: val => val.length <= 12,
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
                            message: 'Must be 21+',
                            fn: val => val >= 21,
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
                            message: 'Must be 250-500 words',
                            fn: val => val.length >= 250 && val.length <= 500
                        },
                    ],

                    photos: [
                        {
                            message: 'Photo required',
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
                            message: 'Birthday required',
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
                        {
                            message: 'Date is invalid',
                            fn: (val, data) => {
                                if (!val || isNaN(Date.parse(val))) return false;
                                
                                const [month, day, year] = val.split('/').map(Number);

                                const currentYear = new Date().getFullYear();
                                const minYear = currentYear;

                                return (
                                    month >= 1 && month <= 12 &&
                                    day >= 1 && day <= 31 &&
                                    year <= minYear
                                );
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
                formatDate(e) {
                    let birthday = this.data.birthday.replace(/\D/g, "").substring(0, 8)
                    let day = birthday.substring(0, 2)
                    let month = birthday.substring(2, 4)
                    let year = birthday.substring(4, 8)

                    if (birthday.length >= 5) {
                        this.data.birthday = day + "/" + month + "/" + year
                    } else if (birthday.length >= 3) {
                        this.data.birthday = day + "/" + month
                    } else if (birthday.length >= 1) {
                        this.data.birthday = day
                    } else {
                        this.data.birthday = ''
                    }
                },

                async search() {
                    this.location.loading = true

                    const fields = ['zip',]

                    fields.forEach(field => delete this.errors[field])

                    let valid = true
                    fields.forEach(field => this.validate(field) || (valid = false))
                   
                    if (valid) {
                        const location = await this.getZip(this.data.zip)

                        if (location) {
                            const latitude = parseFloat(location.latitude).toFixed(7)
                            const longitude = parseFloat(location.longitude).toFixed(7)

                            this.createMap(latitude, longitude)   
                        } else {
                            this.errors.zip = 'Zip Not Found'
                        }
                    }

                    this.location.loading = false
                },
                async getZip(zip) {
                    try {
                        let res = await $.get(`/zips/${zip}`)

                        return res
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

                    if (data.birthday) {
                        const birthday = data.birthday.replaceAll('/', '')
                        
                        data.birthday = `${birthday.substring(4, 8)}-${birthday.substring(0, 2)}-${birthday.substring(2, 4)}`
                    }
                    
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
                    if (this.loading) {
                        return
                    }

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
                        <h2><span>1</span>Cherry's rules</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group rules">
                            <p class="title">Hey there, it’s <b>Cherry21.</b></p>
                            <p class="title">
                                Welcome to <b>Our Magic Family!</b> 
                            </p>
                            <p>
                                I see you’re ready to create your profile! Before we get started, let’s go over a few simple rules.
                                It’s all about being <b>friendly</b>  and showing <b>off your unique magic!</b> 
                            </p>
                            <p><b>Age Requirement:</b> Only users aged <b>21+</b> are allowed.</p>
                            <ul>
                                <li>
                                    <b>Verification Requirement:</b> If you include nudity in your content, your account must be verified.
                                </li>
                                <li>
                                    <b>Personal Content Only:</b> Upload only your own content and respect others uniqueness.
                                </li>
                                <li>
                                    <b>Photo Guidelines:</b> Not Allowed any text or graphical elements on images.
                                </li>
                                <li>
                                    <b> Text Guidelines:</b> Not Allowed any prices, coded words like "BBJ" or "BBC," or harassment.
                                </li>
                                <li>
                                    <b>Account Deletion:</b> The Cherry21 team reserves the right to delete any account without explanation.
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
                        <h2><span>2</span> Contact Information</h2>
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

                            <div class="input-wrapper">
                                <label for="twitter">
                                    <img src="/assets/img/twitter.png" alt="" />
                                    Twitter:
                                </label>
                                <input
                                    type="text"
                                    id="twitter"
                                    placeholder="@"
                                    onkeydown="return event.key != 'Enter'"
                                    v-model="data.twitter"/>
                                <div v-if="errors.twitter" class="error-text">
                                    {{ errors.twitter }}
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
                        <h2><span>3</span> Your Location</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">
                            
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
                                    v-model="data.zip" />
                                <div v-if="errors.zip" class="error-text">
                                    {{ errors.zip }}
                                </div>
                            </div>

                            <div v-show="location.map" id="location" style="height: 300px;"></div>

                        </div>

                        <div class="btn-group">

                            <button 
                                v-if="! location.map" 
                                class="btn red" 
                                type="button" 
                                id="search-location" 
                                @click="search">
                                <img v-if="location.loading" src="/assets/img/btn-loader.svg" class="loader" alt="" />
                                Search
                            </button>

                            <button 
                                v-if="location.map" 
                                class="btn" 
                                type="button" 
                                id="research-location" 
                                @click="search">
                                <img v-if="location.loading" src="/assets/img/btn-loader.svg" class="loader" alt="" />
                                Research
                            </button>

                            <button 
                                v-if="location.map"
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
                        <h2><span>4</span> Personal Details</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">
                            
                            <div class="input-wrapper">
                                <label for="name">
                                    Your name for public:*
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
                                    My Story:*
                                </label>
                                <label for="description">
                                    <p><b>Not Allowed:</b> Any prices, coded words like "BBJ" or "BBC", or harassment.</p>
                                </label>
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    placeholder="Allowed: Feel free to share your hobbies and what makes you unique. Just be yourself. The Cherry21 team uses AI to adjust anything off-limits or block your account if needed!" 
                                    maxlength="500"
                                    minlength="250"
                                    v-model="data.description"></textarea>
                                <div class="rule">
                                    <p>At least 250 characters, no more than 500 characters</p>
                                    <p class="characterCount"><span class="counter">0</span> / 500</p>
                                </div>
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
                        <h2><span>5</span> Add Photo </h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">
                            <div class="photo-container">
                                <p>
                                    Maximum number of photos: 12
                                    <br />
                                    <span>jpeg, .webp, .heic / file size limit: Up to 10Mb</span>
                                </p>
                                <p><b>Not Allowed:</b></p>
                                <ul>
                                    <li>Photos with added text or graphical elements.</li>
                                    <li>Photos of anyone other than yourself.</li>
                                    <li>Blurry or low-quality images.</li>
                                    <li>Collages or images combining multiple photos.</li>
                                </ul>
                                <input 
                                    type="file" 
                                    id="photoInput" 
                                    accept=".jpg,.jpeg,.jpe,.jif,.jfif,.jfi,.webp,.heif,.heifs,.heic,.heics,.avci,.avcs,.HIF"
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
                                            v-if="data.photos.length > 1" 
                                            class="move-button move-up" 
                                            type="button" 
                                            @click="moveUp(i)">↑</button>
                                        <button 
                                            v-if="data.photos.length > 1" 
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
                                    v-if="data.photos.filter(photo => photo.status != 'loading').length >= 1" 
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
                        <h2><span>6</span> Account Verification</h2>
                    </div>

                    <div class="step-body">
                        <div class="form-group">
                            <ol>
                                <li><b>Verification Required:</b> You must verify your account to publish nudity or sexual content.</li>
                                <li><b>Nudity:</b>  This refers to images showing exposed genitals, breasts, or buttocks.</li>
                                <li><b>Legal Compliance:</b> This is required by law, not just our policy.</li>
                                <li><b>Non-Nudity:</b> You can skip verification if you’re not posting nudity. Non-verified accounts may appear lower in search results and can be blocked without explanation.</li>
                            </ol>

                            <div class="verification-section">
                                <label for="document-photo">
                                    Photo of your document showing your photo, name and date of birth (e.g., driver's license)*
                                </label>

                                <div class="image-card">
                                    <img 
                                        v-if="! data.id_photo" 
                                        src="/assets/img/faceOK.jpg" 
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
                                        Upload photo 
                                        <img src="/assets/img/attach.svg" alt="" />
                                    </button>

                                    <button
                                        v-if="data.id_photo"
                                        type="button"
                                        class="custom-remove-btn"
                                        data-img="document-photo-img"
                                        @click="removeVerificationPhoto('id_photo')">
                                        Remove photo
                                    </button>

                                </div>
                            </div>

                            <div class="verification-section">
                                <label for="permission-photo">
                                    Photo of yourself holding your document with your face visible*
                                </label>
                                
                                <div class="image-card">
                                    <img 
                                        v-if="! data.verification_photo" 
                                        src="/assets/img/idOK.jpg" 
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
                                        Upload photo 
                                        <img id="permission-photo-img" src="/assets/img/attach.svg" alt=""/>
                                    </button>

                                    <button
                                        v-if="data.verification_photo"
                                        type="button"
                                        class="custom-remove-btn"
                                        data-img="permission-photo-img"
                                        @click="removeVerificationPhoto('verification_photo')">
                                        Remove photo
                                    </button>

                                </div>
                            </div>

                            <div class="verification-section">
                                <label for="street-photo">
                                    Photo of yourself standing outdoors with your face visible*
                                </label>
                                
                                <div class="image-card">
                                    <img 
                                        v-if="! data.street_photo" 
                                        src="/assets/img/outOK.jpg" 
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
                                        Upload photo 
                                        <img src="/assets/img/attach.svg" alt="" />
                                    </button>

                                    <button 
                                        v-if="data.street_photo" 
                                        type="button" 
                                        class="custom-remove-btn"
                                        data-img="street-photo-img" 
                                        @click="removeVerificationPhoto('street_photo')">
                                        Remove photo
                                    </button>

                                </div>
                            </div>

                            <div class="user-info-section">

                                <div class="input-wrapper">
                                    <label for="first-name">
                                        First name
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
                                        Last name
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
                                        id="dob" 
                                        name="dob" 
                                        onkeydown="return event.key != 'Enter'"
                                        placeholder="mm/dd/yyyy"
                                        v-model="data.birthday" 
                                        @input="formatDate"/>
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
                        <h2><span>7</span> Sending for Approval</h2>
                    </div>
                    <div class="step-body">
                        <div class="form-group">
                            <p class="text">
                                Yes, You did it! Thank you for completing your profile! <br>
                                Approval may take up to 72 hours. <br>
                                Please double-check all information before submitting. <br>
                                You won’t be able to change this information <b>until it is approved.</b>
                            </p>
                        </div>

                        <div class="btn-group">
                            <button 
                                class="btn red" 
                                @click.stop.prevent="send">
                                <img v-if="loading" src="/assets/img/btn-loader.svg" alt="" class="loader" />
                                Send
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