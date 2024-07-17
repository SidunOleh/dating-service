<template>

    <router-link :to="{name: 'creators.edit', params: {id: data.creator?.id,},}">
        {{ data.creator?.email }}
    </router-link>

    <br>
    <br>
                
    <Form layout="vertical">

        <Collapse 
            style="margin-bottom: 20px;"
            v-model:activeKey="activePanels">

            <CollapsePanel 
                header="Info"
                :showArrow="false"
                :key="1">

                <FormItem
                    label="Name"
                    :class="data.name?.status">

                    <Input
                        style="margin-bottom: 10px;"
                        readonly 
                        :value="data.name ? data.name?.value : data.data?.name"/>
                    
                    <ApproveField
                        v-if="data.name" 
                        v-model:status="data.name.status"
                        v-model:comment="data.name.comment"/>

                </FormItem>

                <FormItem
                    label="Age"
                    :class="data.age?.status">
                    
                    <InputNumber
                        style="margin-bottom: 10px; width: 100%;"
                        readonly 
                        :value="data.age ? data.age?.value : data.creator?.age"/>
                    
                    <ApproveField
                        v-if="data.age" 
                        v-model:status="data.age.status"
                        v-model:comment="data.age.comment"/>

                </FormItem>

                <FormItem
                    label="Gender"
                    :class="data.gender?.status">
                    
                    <Input
                        style="margin-bottom: 10px;"
                        readonly 
                        :value="data.gender ? data.gender?.value : data.creator?.gender"/>
                    
                    <ApproveField
                        v-if="data.gender" 
                        v-model:status="data.gender.status"
                        v-model:comment="data.gender.comment"/>

                </FormItem>

                <FormItem
                    label="Description"
                    :class="data.description?.status">
                    
                    <Textarea
                        style="margin-bottom: 10px;"
                        readonly
                        show-count
                        :value="data.description ? data.description?.value : data.creator?.description"
                        :maxlength="150"
                        :rows="5"/>
                    
                    <ApproveField
                        v-if="data.description" 
                        v-model:status="data.description.status"
                        v-model:comment="data.description.comment"/>

                </FormItem>

            </CollapsePanel>

            <CollapsePanel 
                header="Contacts"
                :showArrow="false"
                :key="2">

                <FormItem
                    label="Phone"
                    :class="data.phone?.status">
                    
                    <Input
                        style="margin-bottom: 10px;"
                        readonly 
                        :value="data.phone ? data.phone?.value : data.creator?.phone"/>
                    
                    <ApproveField
                        v-if="data.phone" 
                        v-model:status="data.phone.status"
                        v-model:comment="data.phone.comment"/>

                </FormItem>

                <FormItem
                    label="Telegram"
                    :class="data.telegram?.status">
                    
                    <Input
                        style="margin-bottom: 10px;"
                        readonly 
                        :value="data.telegram ? data.telegram?.value : data.creator?.telegram"/>
                    
                    <ApproveField
                        v-if="data.telegram" 
                        v-model:status="data.telegram.status"
                        v-model:comment="data.telegram.comment"/>

                </FormItem>

                <FormItem
                    label="Whatsapp"
                    :class="data.whatsapp?.status">
                    
                    <Input
                        style="margin-bottom: 10px;"
                        readonly 
                        :value="data.whatsapp ? data.whatsapp?.value : data.creator?.whatsapp"/>
                    
                    <ApproveField
                        v-if="data.whatsapp" 
                        v-model:status="data.whatsapp.status"
                        v-model:comment="data.whatsapp.comment"/>

                </FormItem>

                <FormItem
                    label="Email"
                    :class="data.profile_email?.status">
                    
                    <Input
                        style="margin-bottom: 10px;"
                        readonly 
                        :value="data.profile_email ? data.profile_email?.value : data.creator?.profile_email"/>
                    
                    <ApproveField
                        v-if="data.profile_email" 
                        v-model:status="data.profile_email.status"
                        v-model:comment="data.profile_email.comment"/>

                </FormItem>

                <FormItem
                    label="Instagram"
                    :class="data.instagram?.status">
                    
                    <Input
                        style="margin-bottom: 10px;"
                        readonly 
                        :value="data.instagram ? data.instagram?.value : data.creator?.instagram"/>
                    
                    <ApproveField
                        v-if="data.instagram" 
                        v-model:status="data.instagram.status"
                        v-model:comment="data.instagram.comment"/>

                </FormItem>

                <FormItem
                    label="SnapChat"
                    :class="data.snapchat?.status">
                    
                    <Input
                        style="margin-bottom: 10px;"
                        readonly 
                        :value="data.snapchat ? data.snapchat?.value : data.creator?.snapchat"/>
                    
                    <ApproveField
                        v-if="data.snapchat" 
                        v-model:status="data.snapchat.status"
                        v-model:comment="data.snapchat.comment"/>

                </FormItem>

                <FormItem
                    label="Onlyfans"
                    :class="data.onlyfans?.status">
                    
                    <Input
                        style="margin-bottom: 10px;"
                        readonly 
                        :value="data.onlyfans ? data.onlyfans?.value : data.creator?.onlyfans"/>
                    
                    <ApproveField
                        v-if="data.onlyfans" 
                        v-model:status="data.onlyfans.status"
                        v-model:comment="data.onlyfans.comment"/>

                </FormItem>

            </CollapsePanel>

            <CollapsePanel
                header="Location"
                :showArrow="false"
                :key="3">

                <FormItem
                    label="Location"
                    :class="data.location?.status">
                    
                    <Flex :gap="5">

                        <Input 
                            style="margin-bottom: 10px;"
                            placeholder="Street"
                            readonly
                            :value="data.location ? data.location?.value?.street : data.creator?.street"/>

                        <Input
                            style="margin-bottom: 10px; width: 300px;"
                            placeholder="Zip"
                            readonly
                            :value="data.location ? data.location?.value?.zip : data.location?.value?.zip"/>

                    </Flex>

                    <div
                        v-if="data.location?.value?.city && data.location?.value?.state"
                        style="margin-bottom: 10px;">
                        {{ data.location?.value?.city }}, {{ data.location?.value?.state }}
                    </div>

                    <ShowLocation 
                        v-if="data.location?.value?.latitude && data.location?.value?.longitude"
                        style="margin-bottom: 10px;"
                        :location="[data.location?.value?.latitude, data.location?.value?.longitude]"/>

                    <ApproveField
                        v-if="data.location" 
                        v-model:status="data.location.status"
                        v-model:comment="data.location.comment"/>

                </FormItem>

            </CollapsePanel>

            <CollapsePanel 
                header="Verification"
                :showArrow="false"
                :key="4">

                <FormItem
                    label="First name"
                    :class="data.first_name?.status">

                    <Input
                        style="margin-bottom: 10px;"
                        placeholder="First name"
                        readonly
                        :value="data.first_name ? data.first_name?.value : data.creator?.first_name"/>

                    <ApproveField
                        v-if="data.first_name"
                        style="margin-top: 10px;" 
                        v-model:status="data.first_name.status"
                        v-model:comment="data.first_name.comment"/>

                </FormItem>

                <FormItem
                    label="Last name"
                    :class="data.last_name?.status">

                    <Input
                        style="margin-bottom: 10px;"
                        placeholder="Last name"
                        readonly
                        :value="data.last_name ? data.last_name?.value : data.creator?.last_name"/>

                    <ApproveField
                        v-if="data.last_name"
                        style="margin-top: 10px;" 
                        v-model:status="data.last_name.status"
                        v-model:comment="data.last_name.comment"/>

                </FormItem>

                <FormItem
                    label="Birthday"
                    :class="data.birthday?.status">

                    <Input
                        style="width: 100%;"
                        placeholder="Birthday"
                        readonly
                        :value="data.birthday ? data.birthday?.value : data.creator?.birthday"/>

                    <ApproveField
                        v-if="data.birthday"
                        style="margin-top: 10px;" 
                        v-model:status="data.birthday.status"
                        v-model:comment="data.birthday.comment"/>

                </FormItem>

                <FormItem
                    label="Verification photo"
                    :class="data.verification_photo?.status">

                    <Image
                        v-if="data.verification_photo ? data.verification_photo?.value?.url : data.creator?.verification_photo?.url"
                        style="object-fit: contain;"
                        :height="295"
                        :width="295"
                        :src="data.verification_photo ? data.verification_photo?.value?.url : data.creator?.verification_photo?.url"/>

                    <ApproveField
                        v-if="data.verification_photo"
                        style="margin-top: 10px;" 
                        v-model:status="data.verification_photo.status"
                        v-model:comment="data.verification_photo.comment"/>

                </FormItem>

                <FormItem
                    label="ID photo"
                    :class="data.id_photo?.status">

                    <Image
                        v-if="data.id_photo ? data.id_photo?.value?.url : data.creator?.id_photo?.url"
                        style="object-fit: contain;"
                        :height="295"
                        :width="295"
                        :src="data.id_photo ? data.id_photo?.value?.url : data.creator?.id_photo?.url"/>

                    <ApproveField
                        v-if="data.id_photo"
                        style="margin-top: 10px;" 
                        v-model:status="data.id_photo.status"
                        v-model:comment="data.id_photo.comment"/>

                </FormItem>

                <FormItem
                    label="Street photo"
                    :class="data.street_photo?.status">

                    <Image
                        v-if="data.street_photo ? data.street_photo?.value?.url : data.creator?.street_photo?.url"
                        style="object-fit: contain;"
                        :height="295"
                        :width="295"
                        :src="data.street_photo ? data.street_photo?.value?.url : data.creator?.street_photo?.url"/>

                    <ApproveField
                        v-if="data.street_photo"
                        style="margin-top: 10px;" 
                        v-model:status="data.street_photo.status"
                        v-model:comment="data.street_photo.comment"/>

                </FormItem>

            </CollapsePanel>

            <CollapsePanel 
                header="Photos"
                :showArrow="false"
                :key="5">

                <FormItem label="Photos">

                    <Flex :gap="20">
                
                        <Flex 
                            :vertical="true"
                            :gap="20">

                            <div style="padding: 10px; background: #f0f0f0; width: 300px;">
                                Old
                            </div>

                            <Image
                                v-for="img in data.creator?.photos?.slice(0, 3)"
                                style="object-fit: contain;"
                                :height="295"
                                :width="295"
                                :src="img.url"/>

                        </Flex>
                    
                        <Flex
                            style="flex-grow: 1;"
                            :vertical="true"
                            :gap="20">

                            <div style="padding: 10px; background:#f0f0f0;">
                                New
                            </div>

                            <Flex
                                v-for="(img, i) in data.photos?.value"
                                :class="data.photos.status[i]"
                                :vertical="true"
                                :gap="10">

                                <Image
                                    style="object-fit: contain;"
                                    :height="230"
                                    :src="img.url"/>

                                <ApproveField 
                                    v-model:status="data.photos.status[i]"
                                    v-model:comment="data.photos.comment[i]"/>

                            </Flex>
                           
                        </Flex>

                    </Flex>

                </FormItem>

            </CollapsePanel>

        </Collapse>

        <Button
            :loading="loading" 
            @click="confirmPopup(done, 'Are you sure you want to apply changes?')">
            Done
        </Button>
              
    </Form>

</template>

<script>
import { Form, FormItem, Input, InputNumber, Textarea, Image, Flex, Button, message, Collapse, CollapsePanel, } from 'ant-design-vue'
import ApproveField from '../components/ApproveField.vue'
import ShowLocation from '../components/ShowLocation.vue'
import profileRequestsApi from '../../api/profile-requests'
import { confirmPopup, } from '../../helpers/popups'

export default {
    components: {
        Form, FormItem, Input,
        ApproveField, InputNumber, Textarea,
        ShowLocation, Image, Flex,
        Button, Collapse, CollapsePanel,
    },
    data() {
        return {
            activePanels: [1, 2, 3, 4, 5,],
            data: {},
            loading: false,
        }
    },
    methods: {
        confirmPopup,
        formatDataToSend() {
            const data = JSON.parse(JSON.stringify(this.data))

            if (data.photos) {
                data.photos.value = this.data.photos.value.map(img => img.id)
            }

            if (data.verification_photo) {
                data.verification_photo.value = this.data.verification_photo.value?.id ?? null
            }

            if (data.id_photo) {
                data.id_photo.value = this.data.id_photo.value?.id ?? null
            }

            if (data.street_photo) {
                data.street_photo.value = this.data.street_photo.value?.id ?? null
            }

            return data
        },
        async done() {
            if (! this.allIsApproved()) {
                this.scrollToPending()
                message.error('You have to approve all fields.')
                return
            }

            try {
                this.loading = true
                const res = await profileRequestsApi.done(
                    this.$route.params.id, 
                    this.formatDataToSend()
                )
                this.goToNext(res.next)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        allIsApproved() {
            for (const field in this.data) {
                if (
                    this.data[field]?.status == 'pending' ||
                    this.data[field]?.status?.includes('pending')
                ) {
                    console.log(this.data, field)
                    return false
                }
            }

            return true
        },
        scrollToPending() {
            document.querySelector('.pending').scrollIntoView({behavior: 'smooth',})
        },
        goToNext(next) {
            if (next) {
                this.$router.push({name: this.$route.name, params: {id: next,},})
            } else {
                this.$router.push({name: this.$route.name.slice(0, -5),})
            }
        },
    },
    async mounted() {
        try {
            this.loading = true
            this.data = await profileRequestsApi.show(this.$route.params.id)
        } catch (err) {
            message.error(err?.response?.data?.message ?? err.message)
        } finally {
            this.loading = false
        }
    },
}
</script>

<style scoped>
.pending {
    padding: 10px;
    border-radius: 5px;
    border: 2px solid blue;
}

.approved {
    padding: 10px;
    border-radius: 5px;
    border: 2px solid green;
}

.rejected {
    padding: 10px;
    border-radius: 5px;
    border: 2px solid red;
}
</style>
