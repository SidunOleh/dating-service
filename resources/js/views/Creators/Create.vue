<template>
    <Form layout="vertical">

        <Collapse 
            style="margin-bottom: 20px;"
            v-model:activeKey="activePanels">

            <CollapsePanel 
                header="Credentials"
                :showArrow="false"
                :key="1">

                <FormItem
                    label="Email"
                    :required="true">
                    <Input
                        placeholder="Enter email"
                        v-model:value="data.email"/>
                </FormItem>

                <FormItem
                    label="Password"
                    :required="true">
                    <InputPassword
                        placeholder="Enter password"
                        style="margin-bottom: 10px;" 
                        :visible="true"
                        v-model:value="data.password"/>
                        <Button @click="generatePassword">
                            Generate password
                        </Button>
                </FormItem>

            </CollapsePanel>

            <CollapsePanel 
                header="Info"
                :showArrow="false"
                :key="2">

                <FormItem 
                    label="Photos"
                    :required="true">
                    <UploadImg
                        :multiple="true"
                        :watermark="true"
                        :quality="20"
                        @change="imgs => data.photos = imgs"/>
                </FormItem>

                <FormItem 
                    label="Name"
                    :required="true">
                    <Input
                        placeholder="Enter name"
                        v-model:value="data.name"/>
                </FormItem>

                <FormItem 
                    label="Age"
                    :required="true">
                    <InputNumber
                        style="width: 100%;"
                        placeholder="Enter age"
                        v-model:value="data.age"
                        :min="18"
                        :max="100"/>
                </FormItem>

                <FormItem label="Gender">
                    <Select
                        v-model:value="data.gender"
                        :options="genderOptions"/>
                </FormItem>

                <FormItem 
                    label="Description"
                    :required="true">
                    <Textarea
                        placeholder="Enter description"
                        v-model:value="data.description"
                        show-count
                        :maxlength="500"
                        :rows="5"/>
                </FormItem>

            </CollapsePanel>

            <CollapsePanel 
                header="Contacts"
                :showArrow="false"
                :key="3">

                <FormItem 
                    label="Phone"
                    :required="true">
                    <Input
                        placeholder="Enter phone"
                        :required="true"
                        :maxlength="14"
                        v-model:value="data.phone"
                        @input="formatPhone"/>
                </FormItem>

                <FormItem label="Telegram">
                    <Input
                        placeholder="Enter telegram account"
                        prefix="@"
                        v-model:value="data.telegram"/>
                </FormItem>

                <FormItem label="WhatsApp">
                    <Input
                        placeholder="Enter whatsapp account"
                        prefix="@"
                        v-model:value="data.whatsapp"/>
                </FormItem>

                <FormItem label="SnapChat">
                    <Input
                        placeholder="Enter snapchat account"
                        prefix="@"
                        v-model:value="data.snapchat"/>
                </FormItem>

                <FormItem label="Instagram">
                    <Input
                        placeholder="Enter instagram account"
                        prefix="@"
                        v-model:value="data.instagram"/>
                </FormItem>

                <FormItem label="OnlyFans">
                    <Input
                        placeholder="Enter onlyfans account"
                        prefix="@"
                        v-model:value="data.onlyfans"/>
                </FormItem>

                <FormItem label="Email">
                    <Input
                        placeholder="Enter email"
                        v-model:value="data.profile_email"/>
                </FormItem>

            </CollapsePanel>
                
            <CollapsePanel 
                header="Location"
                :required="true"
                :showArrow="false"
                :key="4">

                <FormItem 
                    label="Location"
                    :required="true">
                    <FindLocation @change="location => data = Object.assign(data, location)"/>

                    <div
                        v-if="data.city && data.state"
                        style="margin-top: 10px;">
                        {{ data.city }}, {{ data.state }}
                    </div>
                    
                    <ShowLocation 
                        v-if="data.longitude && data.latitude"
                        style="margin-top: 10px;"
                        :location="[data.latitude, data.longitude]"/>
                </FormItem>

            </CollapsePanel>


            <CollapsePanel 
                header="Verification"
                :showArrow="false"
                :key="5">

                <FormItem label="First name">
                    <Input
                        placeholder="Enter first name"
                        v-model:value="data.first_name"/>
                </FormItem>

                <FormItem label="Last name">
                    <Input
                        placeholder="Enter last name"
                        v-model:value="data.last_name"/>
                </FormItem>

                <FormItem label="Birthday">
                    <DatePicker
                        style="width: 100%;"
                        placeholder="Select birthday"
                        valueFormat="YYYY-MM-DD"
                        v-model:value="data.birthday"/>
                </FormItem>

                <FormItem label="ID photo">
                    <UploadImg
                        :quality="20"
                        @change="imgs => data.id_photo = imgs[0] ?? null"/>          
                </FormItem>

                <FormItem label="Street photo">
                    <UploadImg
                        :quality="20"
                        @change="imgs => data.street_photo = imgs[0] ?? null"/>          
                </FormItem>

                <FormItem label="Verification photo">
                    <UploadImg
                        :quality="20"
                        @change="imgs => data.verification_photo = imgs[0] ?? null"/>          
                </FormItem>

            </CollapsePanel>

        </Collapse>

        <Button
            :loading="creating"
            @click="create">
            Create
        </Button>
    </Form>

</template>

<script>
import { Button, Form, FormItem, Input, Select, InputPassword, InputNumber, Textarea, message, Collapse, CollapsePanel, DatePicker } from 'ant-design-vue'
import UploadImg from '../components/UploadImg.vue'
import FindLocation from '../components/FindLocation.vue'
import ShowLocation from '../components/ShowLocation.vue'
import creatorsApi from '../../api/creators'

export default {
    components: {
        Form, FormItem, Input, 
        Select, Button, InputPassword, InputNumber, 
        Textarea, UploadImg, Collapse, 
        CollapsePanel, ShowLocation, FindLocation,
        DatePicker,
    },
    data() {
        return {
            activePanels: [1, 2, 3, 4, 5,],
            data: {
                email: '',
                password: '',
                photos: [],
                name: '',
                age: null,
                gender: '',
                description: '',
                phone: '',
                telegram: '',
                whatsapp: '',
                snapchat: '',
                instagram: '',
                onlyfans: '',
                profile_email: '',
                zip: null,
                state: '',
                city: '',
                latitude: null,
                longitude: null,
                first_name: '',
                last_name: '',
                birthday: '',
                id_photo: null,
                street_photo: null,
                verification_photo: null,
            },
            genders: [
                'Man',
                'Woman',
                'LGBTQIA+',
            ],
            creating: false,
        }
    },
    computed: {
        genderOptions() {
            return this.genders.map(gender => {
                return {
                    value: gender,
                }
            })
        },
    },      
    methods: {
        generatePassword() {
            this.data.password = Math.random().toString(36).substring(2)
        },
        formatPhone(e) {
            const phone = this.data.phone
                .replace(/\D/g, '')
                .match(/(\d{0,3})(\d{0,3})(\d{0,4})/)
            this.data.phone =
                !phone[2] ? 
                phone[1] : 
                '(' + phone[1] + ') ' + phone[2] + (phone[3] ? '-' + phone[3] : '')
        },
        formatDataToSend() {
            const data = JSON.parse(JSON.stringify(this.data))
            data.photos = data.photos.map(photo => photo.id)
            data.verification_photo = data.verification_photo?.id ?? null
            data.id_photo = data.id_photo?.id ?? null
            data.street_photo = data.street_photo?.id ?? null

            return data
        },
        async create() {
            try {
                this.creating = true
                const res = await creatorsApi.create(this.formatDataToSend())
                message.success('Successfully created.')
                this.$router.push({name: 'creators.edit', params: {id: res.id,},}) 
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.creating = false
            }
        },  
    },
}
</script>