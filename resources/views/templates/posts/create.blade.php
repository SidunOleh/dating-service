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
                this.errors.images = 'Images are required'
                valid = false
            }

            if (! this.data.button_number) {
                this.errors.button_number = 'Button is required'
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
        moveUp(i) {
            if (i == 0) {
                return
            }

            const prev = this.data.images[i-1]

            this.data.images[i-1] = this.data.images[i]
            this.data.images[i] = prev
        },
        moveDown(i) {
            if (i == this.data.images.length-1) {
                return
            }

            const next = this.data.images[i+1]

            this.data.images[i+1] = this.data.images[i]
            this.data.images[i] = next
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
            <div class="head">
                <span>1</span> Add photo
            </div>
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
                    accept=".jpg,.jpeg,.jpe,.jif,.jfif,.jfi,.webp,.heif,.heifs,.heic,.heics,.avci,.avcs,.HIF"
                    multiple 
                    hidden
                    @change="addImages"/>
                
                <button 
                    v-if="data.images.length == 0" 
                    id="customButton1" 
                    type="button" 
                    class="btn red" 
                    @click="$('#photoInput').click()">
                    Add photo
                </button>

                <div 
                    v-if="data.images.length"
                    id="photos">
                    <div 
                        v-for="(photo, i) in data.images" 
                        style="position: relative; display: inline-block;">
                        <img :src="window.URL.createObjectURL(photo)">

                        <button 
                            class="move-button move-up" 
                            type="button" 
                            @click="moveUp(i)">↑</button>
                        <button 
                            class="move-button move-down" 
                            type="button" 
                            @click="moveDown(i)">↓</button>

                        <span 
                            class="remove-photo" 
                            @click="deleteImage(i)">×</span>
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
            
            <div 
                v-if="data.images.length >= 1 && data.images.length < 3" 
                class="btn-group">
                <button 
                    id="customButton2" 
                    type="button" 
                    class="btn" 
                    @click="$('#photoInput').click()">
                    Add photo
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="head">
                <span>2</span> Write text
            </div>
            <div class="input-wrapper">
                <label for="description">
                    Text:
                </label>
                    <p><b>Not Allowed:</b> Any prices, coded words like "BBJ" or "BBC", or harassment.</p>
                <textarea 
                    id="text" 
                    name="text" 
                    placeholder="Text" 
                    maxlength="150"
                    v-model="data.text">
                </textarea>
                <div class="rule">
                    <p>no more than 150 characters</p>
                    <p class="characterCount"><span class="counter">{{ data.text.length }}</span> / 150</p>
                </div>
                <div v-if="errors.text" class="error-text">
                    {{ errors.description }}
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="head">
                <span>3</span> Choose button
            </div>
            <div class="title">
                Buttons:
            </div>
            <div class="input-wrapper">
                <div class="post-btns">
                    <div 
                        :class="{'btn': true, 'red': data.button_number == 1}"
                        @click="data.button_number = 1">
                        1
                    </div>
                    <div 
                        :class="{'btn': true, 'red': data.button_number == 2}"
                        @click="data.button_number = 2">
                        2
                    </div>
                    <div 
                        :class="{'btn': true, 'red': data.button_number == 3}"
                        @click="data.button_number = 3">
                        3
                    </div>
                </div>
             
                <div v-if="errors.button_number" class="error-text">
                    {{ errors.button_number }}
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="head">
                <span>4</span> Sending for Approval
            </div>
            <p class="text">
                Yes, You did it! Thank you for completing your post! <br>
                Approval may take up to 72 hours. <br>
                Please double-check all information before submitting. <br>
                You won’t be able to change this information <b>until it is approved.</b>
            </p>

            <div class="btn-group">
                <button 
                    class="btn red" 
                    @click.stop.prevent="send">
                    <img v-if="loading" src="/assets/img/btn-loader.svg" alt="" class="loader" />
                    Save
                </button>
            </div>
        </div>

    </form>
</div>
@endverbatim