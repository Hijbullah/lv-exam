<template>
    <div class="tiptap-editor">
        <editor-floating-menu :editor="editor" v-slot="{ commands, isActive, menu }">
            <div
                class="absolute z-10 ml-5 transition duration-200 transform -tanslate-y-1/2"
                :class=" menu.isActive ? 'visible opacity-100' : ' invisible opacity-0'"
                :style="`top: ${menu.top}px`"
            >
                <button
                    class="inline-flex items-center px-2 py-1 rounded hover:bg-gray-300 focus:outline-none"
                    :class="{ 'bg-gray-300': isActive.heading({ level: 1 }) }"
                    @click="commands.heading({ level: 1 })"
                >
                    <p class="text-gray-900 text-sm font-semibold leading-none">H1</p>
                </button>

                <button
                    class="inline-flex items-center px-2 py-1 rounded hover:bg-gray-300 focus:outline-none"
                    :class="{ 'bg-gray-300': isActive.heading({ level: 2 }) }"
                    @click="commands.heading({ level: 2 })"
                >
                    <p class="text-gray-900 text-sm font-semibold leading-none">H2</p>
                </button>

                <button
                    class="inline-flex items-center px-2 py-1 rounded hover:bg-gray-300 focus:outline-none"
                    :class="{ 'bg-gray-300': isActive.heading({ level: 3 }) }"
                    @click="commands.heading({ level: 3 })"
                >
                    <p class="text-gray-900 text-sm font-semibold leading-none">H3</p>
                </button>

                <button
                    class="inline-flex items-center px-2 py-1 rounded hover:bg-gray-300 focus:outline-none"
                    :class="{ 'bg-gray-300': isActive.paragraph() }"
                    @click="commands.paragraph"
                >
                    <svg class="h-3 w-3 fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22.5.248H7.228a6.977 6.977 0 100 13.954h2.318a.25.25 0 01.25.25V22.5a1.25 1.25 0 002.5 0V3a.25.25 0 01.25-.25h3.682a.25.25 0 01.25.25v19.5a1.25 1.25 0 002.5 0V3a.249.249 0 01.25-.25H22.5a1.25 1.25 0 000-2.5zM9.8 11.452a.25.25 0 01-.25.25H7.228a4.477 4.477 0 110-8.954h2.318A.25.25 0 019.8 3z"/></svg>
                </button>

                <button
                    class="inline-flex items-center px-2 py-1 rounded hover:bg-gray-300 focus:outline-none"
                    @click="insertImage(commands.image)"
                >
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="9.75" cy="6.247" r="2.25"/><path d="M16.916 8.71A1.027 1.027 0 0016 8.158a1.007 1.007 0 00-.892.586l-1.558 3.434a.249.249 0 01-.422.053l-.82-1.024a1 1 0 00-.813-.376 1.007 1.007 0 00-.787.426L7.59 15.71a.5.5 0 00.41.79h12a.5.5 0 00.425-.237.5.5 0 00.022-.486z"/><path d="M22 0H5.5a2 2 0 00-2 2v16.5a2 2 0 002 2H22a2 2 0 002-2V2a2 2 0 00-2-2zm-.145 18.354a.5.5 0 01-.354.146H6a.5.5 0 01-.5-.5V2.5A.5.5 0 016 2h15.5a.5.5 0 01.5.5V18a.5.5 0 01-.145.351z"/><path d="M19.5 22h-17a.5.5 0 01-.5-.5v-17a1 1 0 00-2 0V22a2 2 0 002 2h17.5a1 1 0 000-2z"/></svg>
                </button>

            </div>
        </editor-floating-menu>

        <editor-menu-bubble :editor="editor" :keep-in-bounds="keepInBounds" v-slot="{ commands, isActive, menu }">
            <div
                class="absolute flex z-20 bg-gray-900 rounded mb-1 py-1 space-x-1 transition duration-200 transform -translate-x-1/2"
                :class=" menu.isActive ? 'visible opacity-100' : ' invisible opacity-0'"
                :style="`left: ${menu.left}px; bottom: ${menu.bottom}px;`"
            >

                <button
                    class="inline-flex items-center px-2 py-1 hover:bg-gray-700 transition duration-200 rounded focus:outline-none"
                    :class="{ 'bg-gray-700': isActive.bold() }"
                    @click="commands.bold"
                >
                    <svg class="h-4 w-4 fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17.194 10.962A6.271 6.271 0 0012.844.248H4.3a1.25 1.25 0 000 2.5h1.013a.25.25 0 01.25.25V21a.25.25 0 01-.25.25H4.3a1.25 1.25 0 100 2.5h9.963a6.742 6.742 0 002.93-12.786zm-4.35-8.214a3.762 3.762 0 010 7.523H8.313a.25.25 0 01-.25-.25V3a.25.25 0 01.25-.25zm1.42 18.5H8.313a.25.25 0 01-.25-.25v-7.977a.25.25 0 01.25-.25H14.264a4.239 4.239 0 010 8.477z"/></svg>

                </button>

                <button
                    class="inline-flex items-center px-2 py-1 hover:bg-gray-700 transition duration-200 rounded focus:outline-none"
                    :class="{ 'bg-gray-700': isActive.italic() }"
                    @click="commands.italic"
                >
                    <svg class="h-4 w-4 fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22.5.248h-7.637a1.25 1.25 0 000 2.5h1.086a.25.25 0 01.211.384L4.78 21.017a.5.5 0 01-.422.231H1.5a1.25 1.25 0 000 2.5h7.637a1.25 1.25 0 000-2.5H8.051a.25.25 0 01-.211-.384L19.22 2.98a.5.5 0 01.422-.232H22.5a1.25 1.25 0 000-2.5z"/></svg>
                </button>

                <button
                    class="inline-flex items-center px-2 py-1 hover:bg-gray-700 transition duration-200 rounded focus:outline-none"
                    :class="{ 'bg-gray-700': isActive.underline() }"
                    @click="commands.underline"
                >
                    <svg class="h-4 w-4 fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22.5 21.248h-21a1.25 1.25 0 000 2.5h21a1.25 1.25 0 000-2.5zM1.978 2.748h1.363a.25.25 0 01.25.25v8.523a8.409 8.409 0 0016.818 0V3a.25.25 0 01.25-.25h1.363a1.25 1.25 0 000-2.5H16.3a1.25 1.25 0 000 2.5h1.363a.25.25 0 01.25.25v8.523a5.909 5.909 0 01-11.818 0V3a.25.25 0 01.25-.25H7.7a1.25 1.25 0 100-2.5H1.978a1.25 1.25 0 000 2.5z"/></svg>
                </button>

            </div>
        </editor-menu-bubble>

        <input type="file" ref="fileInput" class="hidden" @change="OnFileChange">
        <editor-content class="editor__content" :editor="editor" />
    </div>
</template>

<script>
    import { Editor, EditorContent, EditorFloatingMenu, EditorMenuBubble } from 'tiptap'
    import {
        Heading,
        Image,
        Bold,
        Italic,
        Underline,
        // TrailingNode
    } from 'tiptap-extensions'

    export default {
        components: {
            EditorContent,
            EditorFloatingMenu,
            EditorMenuBubble
        },
        props: ['content'],
        data() {
            return {
                inserImageCommand: null,
                keepInBounds: true,
                editor: new Editor({
                    extensions: [
                        new Heading({ levels: [1, 2, 3] }),
                        new Image(),
                        new Bold(),
                        new Italic(),
                        new Underline(),
                        // new TrailingNode({
                        //     node: 'paragraph',
                        //     notAfter: ['paragraph'],
                        // }),
                    ],
                    editorProps: { 
                        handleDOMEvents: {
                        drop: (view, e) => { e.preventDefault(); },
                        } 
                    },
                    // hide the drop position indicator
                    dropCursor: { width: 0, color: 'transparent' },
                    content: this.content,
                    onUpdate: ({ state, getHTML, getJSON, transaction }) => {
                        let content = this.editor.getHTML(),
                        json = this.editor.getJSON().content;

                        if (
                            Array.isArray(json) &&
                            json.length === 1 &&
                            !json[0].hasOwnProperty('content')
                        ) {
                            content = '';
                        }
                        this.$emit('input', content);
                    },
                }),
            }
        },
        methods: {
            insertImage(command) {
                this.inserImageCommand = command;
                this.$refs.fileInput.click();
                // const src = prompt('Enter the url of your image here')
                // if (src !== null) {
                //   command({ src })
                // }
            },
            async OnFileChange(event) {
                const file = event.target.files[0];
                let formData = new FormData();
                formData.append('file', file);
                const headers = {'Content-Type': 'multipart/form-data'};
                const response = await axios.post('/admin/editor/upload', formData, {headers: headers} );
                const data = {
                    src: response.data.src
                }
                
                this.inserImageCommand(data);
            }

        },
        beforeDestroy() {
            this.editor.destroy()
        },
    }
</script>

