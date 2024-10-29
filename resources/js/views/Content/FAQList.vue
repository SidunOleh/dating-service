<template>

    <div :class="`list level-${level}`">

        <div
            v-for="(item, i) in list" 
            class="item">

            <Flex 
                align="center"
                :gap="10">

                <Flex 
                    :vertical="true"
                    :gap="5">   
                    <Tooltip>
                        <template #title>
                            Up
                        </template>
            
                        <div 
                            style="cursor: pointer; font-size: 20px;"
                            @click="moveUp(list, i)">
                            ↑
                        </div>
                    </Tooltip>     

                    <Tooltip placement="bottom">
                        <template #title>
                            Down
                        </template>
            
                        <div 
                            style="cursor: pointer; font-size: 20px;"
                            @click="moveDown(list, i)">
                            ↓
                        </div>
                    </Tooltip>     
                </Flex>

                <Flex
                    style="flex-grow: 1;" 
                    :vertical="true">

                    <Input
                        placeholder="Title" 
                        v-model:value="item.title"/>

                    <QuillEditor 
                        v-if="! item.children.length"
                        style="min-height: 200px;"
                        contentType="html"
                        toolbar="full"
                        v-model:content="item.text"
                        @ready="quillReady"></QuillEditor>

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
import imagesApi from '../../api/images'

export default {
    props: [
        'list', 
        'level',
    ],
    components: {
        Button, Input, Textarea,
        Flex, Tooltip,
    },
    methods: {
        quillReady(editor) {
            const toolbar = editor.getModule('toolbar')
            toolbar.addHandler('image', () => {
                const input = document.createElement('input')
                input.setAttribute('type', 'file')
                input.setAttribute('accept', 'image/*')
                input.click()
                input.onchange = async () => {
                    const file = input.files[0]

                    if (! file) {
                        return
                    }

                    const range = editor.getSelection()
                    
                    editor.insertEmbed(range.index, 'image', '/assets/img/lazy-loading.gif')

                    try {
                        const res = await imagesApi.upload(file, false, false, 0)
                        
                        editor.deleteText(range.index, 1)
                        editor.insertEmbed(range.index, 'image', res.url)
                    } catch {
                        editor.deleteText(range.index, 1)
                    }
                }
            })
        },
        moveUp(list, i) {
            if (i == 0) {
                return
            }

            const el = list[i]
            list[i] = list[i-1]
            list[i-1] = el
        },
        moveDown(list, i) {
            if (list.length-1 == i) {
                return
            }

            const el = list[i]
            list[i] = list[i+1]
            list[i+1] = el
        },
    }
}
</script>

<style scoped>
.list {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid gray;
}

.level-2 {
    margin: 10px 0px 10px 20px !important;
}

.item {
    margin: 10px 0px;
}

.ant-input {
    margin-bottom: 5px;
}
</style>