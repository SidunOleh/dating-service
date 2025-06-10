<template>

    <Flex 
        :gap="10"
        style="margin-bottom: 20px; font-size: 15px;">
        <div>
            <router-link :to="{name: 'creators.edit', params: {id: data.creator?.id,},}">
                {{ data.creator?.email }}
            </router-link>
        </div>
        <div>   
            <span style="font-weight: 700;">{{ data.status }}</span>
        </div>  
    </Flex>

    <Form layout="vertical">
        
        <FormItem 
            label="Images"
            :required="true">
            <UploadImg
                :uploaded="data.imagesModels"
                :disabled="true"/>
        </FormItem>

        <FormItem label="Text">
            <Textarea
                placeholder="Enter text"
                v-model:value="data.text"
                show-count
                :maxlength="150"
                :rows="5"/>
        </FormItem>

        <FormItem 
            label="Button"
            :required="true">
            <InputNumber
                style="width: 100%;"
                placeholder="Enter button number"
                v-model:value="data.button_number"
                :min="1"
                :max="3"/>
        </FormItem>

        <Flex 
            v-if="data.status == 'pending'"
            class="approve-section"
            :vertical="true">
            <FormItem>
                <Textarea
                    placeholder="Enter comment for creator"
                    v-model:value="comment"/>
            </FormItem>
            <Flex :gap="10">
                <Button
                    :loading="loading.approve"
                    @click="confirmPopup(() => approve(), 'Are you sure you want to approve?')">
                    Approve
                </Button>    

                <Button
                    danger
                    :loading="loading.reject"
                    @click="confirmPopup(() => reject(), 'Are you sure you want to reject?')">
                    Reject
                </Button>
            </Flex>
        </Flex>

    </Form>
</template>

<script>
import { Button, Form, FormItem, Input, InputNumber, Textarea, message, Flex, } from 'ant-design-vue'
import UploadImg from '../components/UploadImg.vue'
import { confirmPopup, } from '../../helpers/popups'
import postsApi from '../../api/posts'
import can from '../../helpers/can'

export default {
    components: {
        Form, FormItem, Input, 
        Button, InputNumber, Textarea, 
        UploadImg, Flex,
    },
    data() {
        return {
            data: {},
            loading: {
                approve: false,
                reject: false,
            },
            comment: '',
        }
    },    
    methods: {
        confirmPopup,
        can,
        async fetchData() {
            try {
                this.data = await postsApi.show(this.$route.params.id)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async approve() {
            try {
                this.loading.approve = true
                const res = await postsApi.approve(this.$route.params.id)
                message.success('Successfully approved.')
                if (res.next) {
                    this.$router.push({name: 'posts.show', params: {id: res.next}})
                } else {
                    this.$router.push({name: 'posts.index'})
                }
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading.approve = false
            }
        },
        async reject() {
            try {
                this.loading.reject = true
                const res = await postsApi.reject(this.$route.params.id, {comment: this.comment})
                message.success('Successfully rejected.')
                if (res.next) {
                    this.$router.push({name: 'posts.show', params: {id: res.next}})
                } else {
                    this.$router.push({name: 'posts.index'})
                }
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading.reject = false
            }
        },
    },
    async mounted() {
        this.fetchData()
    },
}
</script>

<style scoped>
.approve-section {
    margin-top: 20px;
    border: 1px solid #bab9b8; 
    padding: 15px 10px; 
    border-radius: 5px;
}
</style>