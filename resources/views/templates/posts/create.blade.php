<script type="module">
    import { createApp } from 'https://unpkg.com/petite-vue?module'
        
    const postForm = {
        data: {
            images: [],
            button_number: null,
            text: '',
        },
        errors: {},
        loading: false,
        validate() {
            this.errors = {}

            let valid = true

            if (! this.data.images.length) {
                this.errors.images = 'Images are required.'
                valid = false
            }

            if (! this.data.button_number) {
                this.errors.button_number = 'Choose Lucky Paw.'
                valid = false
            }

            return valid
        },
        async addImages(e) {
            const files = e.target.files
            for (let i = 0; i < files.length; i++) {
                if (this.data.images.length == 3) {
                    break
                }

                this.data.images.push(files[i])
            }

            $(e.target).val(null)
        },  
        deleteImage(i) {
            this.data.images.splice(i, 1)
        },
        getFormData() {
            const formData = new FormData()
            
            this.data.images.forEach(image => formData.append('images[]', image))
            formData.append('button_number', this.data.button_number)
            formData.append('text', this.data.text)
            
            return formData
        },
        async send() {
            if (! this.validate()) {
                return
            }

            this.loading = true

            const formData = this.getFormData()

            $.ajax({
                type: 'POST',
                url: '/posts',
                data: formData,
                processData: false,
                contentType: false,
            }).done(data => {
                location.reload()
            }).fail(jqXHR => {
                if (jqXHR.status == 422) {
                    this.errors = {}

                    const errors = jqXHR.responseJSON.errors
                    for (const field in errors) {
                        this.errors[field] = errors[field][0]    
                    }
                } else {
                    alert(jqXHR.responseJSON.message)
                }
            }).always(() => {
                this.loading = false
            })
        },
        mounted() {   
            document.querySelectorAll('[v-clock]').forEach(el => {
                el.removeAttribute('v-clock')
            })
        },
    }

    createApp(postForm).mount('.post-form')
</script>

<style>
    .post-form[v-clock] {
        display: none !important;
    }
</style>

@verbatim
<div class="post-form" v-clock @vue:mounted="mounted">
    <form id="post-form">

        <div class="form-group">
            <div class="photo-container">
                <p>
                    Maximum number of photos: 3
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
                    accept=".jpg,.jpeg,.jpe,.jif,.jfif,.jfi,.webp,.heif,.heifs,.heic,.heics,.avci,.avcs,.HIF,.png"
                    multiple 
                    hidden
                    @change="addImages"/>

                <div id="photos" :class="{'align-center': data.images.length == 0}">
                    <div 
                        v-for="(photo, i) in data.images ?? []" 
                        style="position: relative; display: inline-block;">
                        <img :src="window.URL.createObjectURL(photo)">

                        <span 
                            class="remove-photo" 
                            @click="deleteImage(i)">×</span>
                    </div>

                    <div 
                        v-if="data.images.length < 3" 
                        class="add-photo"
                        @click="$('#photoInput').click()">
                        +
                    </div>

                </div>
            </div>

            <div 
                v-if="data.images.length >= 1" 
                class="photo-count" 
                id="photoCount">
                Available number of photos: {{ data.images.length }}/3
            </div>

            <div v-if="errors.images" class="form-error">
                {{ errors.images }}
            </div>

            <div v-for="i in [0,1,2]">
                <div v-if="errors[`images.${i}`]" class="form-error">
                    {{ errors[`images.${i}`] }}
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="input-wrapper">
                <textarea 
                    id="text" 
                    name="text" 
                    placeholder='Not Allowed: Any prices, coded words like "BBJ" or "BBC", or harassment.'
                    maxlength="150"
                    v-model="data.text">
                </textarea>
                <div class="rule">
                    <p>no more than 150 characters</p>
                    <p class="characterCount"><span class="counter">{{ data.text.length }}</span> / 150</p>
                </div>
                <div v-if="errors.text" class="error-text">
                    {{ errors.text }}
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="title">
                Choose Your Lucky Paw!
            </div>
            <div class="input-wrapper">
                <div class="post-btns">
                    <div 
                        data-number="1"
                        :class="{'paw-btn': true, 'chosen': data.button_number == 1}"
                        @click="data.button_number = 1">
                        <img src="/assets/img/buPaw1.png" alt="">
                    </div>
                    <div 
                        data-number="2"
                        :class="{'paw-btn': true, 'chosen': data.button_number == 2}"
                        @click="data.button_number = 2">
                        <img src="/assets/img/buPaw2.png" alt="">
                    </div>
                    <div 
                        data-number="3"
                        :class="{'paw-btn': true, 'chosen': data.button_number == 3}"
                        @click="data.button_number = 3">
                        <img src="/assets/img/buPaw3.png" alt="">
                    </div>
                </div>
             
                <div v-if="errors.button_number" class="error-text">
                    {{ errors.button_number }}
                </div>
            </div>
            <a href="">What is Lucky Paw?</a>
        </div>

        <div class="form-group">
            <p class="text">
                Approval takes up to 72 hours! Double-check before sending.
            </p>

            <div class="btn-group">
                <button 
                    class="btn red" 
                    @click.stop.prevent="send">
                    <img v-if="loading" src="/assets/img/btn-loader.svg" alt="" class="loader" />
                    Send
                </button>
            </div>
        </div>

    </form>
</div>
@endverbatim