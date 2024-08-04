<template>

    <div class="list">

        <div style="margin-bottom: 10px;">
            Level {{ level }}
        </div>

        <div
            v-for="(item, i) in list" 
            class="item">

            <Flex 
                align="center"
                :gap="10">

                <Flex
                    style="flex-grow: 1;" 
                    :vertical="true">

                    <Input
                        placeholder="Title" 
                        v-model:value="item.title"/>

                    <Textarea
                        placeholder="Text"  
                        :rows="7"
                        v-model:value="item.text"/>

                </Flex>

                <Tooltip>
                    <template #title>
                        Delete
                    </template>
        
                    <div 
                        style="cursor: pointer;"
                        @click="list.splice(i, 1)">
                        🗑️
                    </div>
                </Tooltip>

            </Flex>

            <FAQList
                v-if="level < 2" 
                :list="item.children" :level="level+1" />

        </div>

        <Button
            class="add-btn"  
            @click="list.push({title: '', text: '', children: []})">
            Add item
        </Button>

    </div>

</template>

<script>
import { Button, Input, Textarea, Flex, Tooltip, } from 'ant-design-vue'


export default {
    props: [
        'list', 
        'level',
    ],
    components: {
        Button, Input, Textarea,
        Flex, Tooltip,
    },
}
</script>

<style scoped>
.list {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #002140;
}

.list .list {
   margin: 10px 0;
}

.item {
    margin-bottom: 10px;
}

.ant-input {
    margin-bottom: 5px;
}

.add-btn {
    margin-top: 10px;
}
</style>