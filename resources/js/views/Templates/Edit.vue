<template>

    <Flex   
        v-if="template.length"
        style="margin-bottom: 20px;"
        :vertical="true">

        <Flex 
            v-for="(block, i) in template"
            justify="space-between"
            style="padding: 20px;"
            :class="block">

            <Flex 
                align="center"
                :gap="10">
                
                <Flex :vertical="true">
                    <span 
                        class="arrow"
                        @click="moveUp(i)">
                        ▲
                    </span>
                    <span
                        class="arrow"
                        @click="moveDown(i)">
                        ▼
                    </span>
                </Flex>

                {{ block }}

            </Flex>

            <CloseOutlined @click="removeBlock(i)"/>
        </Flex>

    </Flex>

    <Flex justify="space-between">

        <Flex :gap="10">
            <Button 
                class="profile"
                @click="addBlock('profile')">
                Profile
            </Button>

            <Button 
                class="roulette"
                @click="addBlock('roulette')">
                Roulette
            </Button>

            <Button 
                class="ad"
                @click="addBlock('ad')">
                Ad
            </Button>
        </Flex>

        <Flex :gap="10">
            <Button 
                :loading="editing"
                @click="confirmPopup(() => edit(), 'Templates must have the same count of profile blocks.')">
                Save
            </Button> 

            <Button
                style="margin-bottom: 20px;" 
                danger
                :loading="deleting"
                @click="confirmPopup(() => deleteRecord(), 'Are you sure you want to delete?')">
                Delete
            </Button>
        </Flex>

    </Flex>

</template>

<script>
import { message, Flex, Button, } from 'ant-design-vue'
import { CloseOutlined, } from '@ant-design/icons-vue'
import { confirmPopup, } from '../../helpers/popups'
import templatesApi from '../../api/templates'

export default {
    components: {
        Flex, Button, CloseOutlined,
    }, 
    data() {
        return {
            template: [],
            editing: false,
            deleting: false,
        }
    },
    methods: {
        confirmPopup,
        addBlock(block) {
            this.template.push(block)
        },
        removeBlock(index) {
            this.template = this.template.filter((block, i) => i != index)
        },
        async edit() {
            try {
                this.editing = true
                await templatesApi.edit(this.$route.params.id, {template: this.template,})
                message.success('Successfully saved.')
                window.scrollTo({top: 0, behavior: 'smooth',})
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.editing = false
            }
        },
        async deleteRecord() {
            try {
                this.deleting = true
                await templatesApi.delete(this.$route.params.id)
                message.success('Successfully deleted.')
                this.$router.push({name: 'templates.index',})
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.deleting = false
            }
        },
        moveUp(i) {
            if (i == 0) {
                return
            }

            const temp = this.template[i - 1]
            this.template[i - 1] = this.template[i]
            this.template[i] = temp
        },
        moveDown(i) {
            if (this.template.length - 1 == i) {
                return
            }

            const temp = this.template[i + 1]
            this.template[i + 1] = this.template[i]
            this.template[i] = temp
        },
    },
    async mounted() {
        try {
            this.editing = true
            const res = await templatesApi.show(this.$route.params.id)
            this.template = res.template
        } catch (err) {
            message.error(err?.response?.data?.message ?? err.message)
        } finally {
            this.editing = false
        }
    },
}
</script>

<style scoped>
.profile {    
    color: #383d41;
    background-color: #d6d8db;
}

.roulette {
    color: #004085;
    background-color: #b8daff;
}

.ad {
    color: #856404;
    background-color: #ffeeba;
}

.arrow {
    cursor: pointer;
    font-size: 15px;
}
</style>