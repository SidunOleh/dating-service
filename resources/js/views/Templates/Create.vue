<template>

    <Flex   
        v-if="template.length"
        :vertical="true"
        style="margin-bottom: 20px;">

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

            <DeleteIcon @click="removeBlock(i)"/>

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

        <Button 
            :loading="creating"
            @click="confirmPopup(() => create(), 'Templates must have the same count of profile blocks.')">
            Create
        </Button>
    </Flex>

</template>

<script>
import { message, Flex, Button, } from 'ant-design-vue'
import DeleteIcon from '../icons/Delete.vue'
import { confirmPopup, } from '../../helpers/popups'
import templatesApi from '../../api/templates'

export default {
    components: {
        Flex, Button, DeleteIcon,
    }, 
    data() {
        return {
            template: ['profile',],
            creating: false,
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
        async create() {
            try {
                this.creating = true
                const res = await templatesApi.create({template: this.template})
                message.success('Successfully created.')
                this.$router.push({name: 'templates.edit', params: {id: res.id,},})
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.creating = false
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