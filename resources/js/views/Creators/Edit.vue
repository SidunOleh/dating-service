<template>

    <Form layout="vertical">

        <Flex 
            style="margin-bottom: 20px;"
            :gap="20">
            <Flex 
                align="center"
                :gap="5" 
                :vertical="true">
                Banned
                <Switch v-model:checked="data.is_banned"/>
            </Flex>

            <Flex
                align="center" 
                :gap="5" 
                :vertical="true">
                Show on site
                <Switch v-model:checked="data.show_on_site"/>
            </Flex>

            <Flex
                align="center" 
                :gap="5" 
                :vertical="true">
                Roulette
                <Switch v-model:checked="data.play_roulette"/>
            </Flex>
        </Flex>

        <div style="margin-bottom: 10px;">
            <a :href="`/profile/${this.$route.params.id}`">
                View
            </a>
        </div>

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

                <FormItem label="New password">
                    <InputPassword
                        placeholder="Enter new password"
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
                        :uploaded="data.photos"
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
                        placeholder="Select gender"
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
                        :minlength="50"
                        :maxlength="150"
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
                :showArrow="false"
                :key="4">

                <FormItem 
                    label="Location"
                    :required="true">
                    <FindLocation 
                        :data="location"
                        @change="location => data = Object.assign(data, location)"/>

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
                        :uploaded="data.id_photo ? [data.id_photo,] : []"
                        @change="imgs => data.id_photo = imgs[0] ?? null"/>          
                </FormItem>

                <FormItem label="Street photo">
                    <UploadImg
                        :quality="20"
                        :uploaded="data.street_photo ? [data.street_photo,] : []"
                        @change="imgs => data.street_photo = imgs[0] ?? null"/>          
                </FormItem>

                <FormItem label="Verification photo">
                    <UploadImg
                        :quality="20"
                        :uploaded="data.verification_photo ? [data.verification_photo,] : []"
                        @change="imgs => data.verification_photo = imgs[0] ?? null"/>          
                </FormItem>

            </CollapsePanel>

            <CollapsePanel 
                header="Referrals"
                :showArrow="false"
                :key="6">

                <FormItem label="Referral link">
                    <Input
                        readonly
                        :value="data.referral_link"/>
                </FormItem>

                <FormItem label="Balance">
                    <Flex :gap="10">
                        <Input 
                            v-model:value="data.balance"
                            :readonly="!can('creators.edit-balance')"/>

                        <Button
                            v-if="can('creators.edit-balance')"
                            :loading="loading.balance" 
                            @click="confirmPopup(() => updateBalance(), 'Are you sure you want to change balance?')">
                            Update
                        </Button>
                    </Flex>
                </FormItem>

                <Referral 
                    :data="data.referrals"
                    @show="record => $router.push({name: 'creators.edit', params: {id: record.id,},})"/>

            </CollapsePanel>

            <CollapsePanel 
                header="Transactions"
                :showArrow="false"
                :key="7">

                <DetailsModal 
                    v-model:open="transactions.open"
                    v-model:record="transactions.record"/>

                <Transactions 
                    :data="data.transactions"
                    @show="showTransaction"/>

            </CollapsePanel>

        </Collapse>

        <Flex :gap="10">
            <Button
                :loading="loading.edit"
                @click="edit">
                Save
            </Button>    

            <Button
                danger
                :loading="loading.delete"
                @click="confirmPopup(() => deleteRecord(), 'Are you sure you want to delete?')">
                Delete
            </Button>
        </Flex>

    </Form>
</template>

<script>
import { Button, Form, FormItem, Input, Select, InputPassword, InputNumber, Textarea, message, Collapse, CollapsePanel, Flex, Switch, DatePicker, } from 'ant-design-vue'
import UploadImg from '../components/UploadImg.vue'
import FindLocation from '../components/FindLocation.vue'
import ShowLocation from '../components/ShowLocation.vue'
import Referral from './Referrals.vue'
import Transactions from './Transactions.vue'
import DetailsModal from '../Transactions/DetailsModal.vue'
import { confirmPopup, } from '../../helpers/popups'
import creatorsApi from '../../api/creators'
import can from '../../helpers/can'

export default {
    components: {
        Form, FormItem, Input, 
        Select, Button, InputPassword, InputNumber, 
        Textarea, UploadImg, Collapse, 
        CollapsePanel, FindLocation, Flex,
        Switch, ShowLocation, Referral,
        Transactions, DetailsModal, DatePicker,
    },
    data() {
        return {
            activePanels: [1, 2, 3, 4, 5, 6, 7,],
            data: {},
            genders: [
                'Man',
                'Woman',
                'LGBTQIA+',
            ],
            transactions: {
                open: false,
                record: null,
            },
            loading: {
                delete: false,
                edit: false,
                balance: false,
            },
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
        location() {
            return {
                zip: this.data.zip,
                state: this.data.state,
                city: this.data.city,
                latitude: this.data.latitude,
                longitude: this.data.longitude,
            }
        },
    },      
    methods: {
        confirmPopup,
        can,
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
        showTransaction(record) {
            this.transactions.record = record
            this.transactions.open = true
        },
        formatDataToSend() {
            const data = JSON.parse(JSON.stringify(this.data))
            data.photos = data.photos.map(photo => photo.id)
            data.verification_photo = data.verification_photo?.id ?? null
            data.id_photo = data.id_photo?.id ?? null
            data.street_photo = data.street_photo?.id ?? null

            if (! data.password) {
                delete data.password
            }

            return data
        },
        async updateBalance() {
            try {
                this.loading.balace = true
                await creatorsApi.updateBalance(this.$route.params.id, this.data.balance)
                message.success('Successfully saved.')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading.balace = false
            }
        },
        async edit() {
            try {
                this.loading.edit = true
                await creatorsApi.edit(this.$route.params.id, this.formatDataToSend())
                message.success('Successfully saved.')
                window.scrollTo({top: 0, behavior: 'smooth',})
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading.edit = false
            }
        },
        async deleteRecord() {
            try {
                this.loading.delete = true
                await creatorsApi.delete(this.$route.params.id)
                message.success('Successfully deleted.')
                this.$router.push({name: 'creators.index',},)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading.delete = false
            }
        },
    },
    async mounted() {
        try {
            this.loading.edit = true
            this.data = await creatorsApi.show(this.$route.params.id)
        } catch (err) {
            message.error(err?.response?.data?.message ?? err.message)
        } finally {
            this.loading.edit = false
        }
    },
}
</script>