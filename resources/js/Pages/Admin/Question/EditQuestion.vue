<template>
    <div class="w-full">
        <div class="p-5 shadow-md">
            <div class="w-full">
                <div class="flex flex-col">
                    <question-editor class="border-2 border-gray-600 rounded bg-white" :content="form.question" @input="inputChange($event, 'question')"></question-editor>
                </div>
                <jet-input-error :message="form.error('question')"  class="mt-2" />
            </div>
            
            <div class="pl-8 py-4 space-y-4">
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="a" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="flex-1">
                        <div class="flex flex-col">
                            <question-editor class="border border-gray-600 bg-white rounded-md" :content="form.option_a" @input="inputChange($event, 'option_a')"></question-editor>
                        </div>
                        <jet-input-error :message="form.error('option_a')"  class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="b" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="flex-1">
                        <div class="flex flex-col">
                            <question-editor class="border border-gray-600 bg-white rounded-md" :content="form.option_b" @input="inputChange($event, 'option_b')"></question-editor>
                        </div>
                        <jet-input-error :message="form.error('option_b')"  class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="c" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="flex-1">
                        <div class="flex flex-col">
                            <question-editor class="border border-gray-600 bg-white rounded-md" :content="form.option_c" @input="inputChange($event, 'option_c')"></question-editor>
                        </div>
                        <jet-input-error :message="form.error('option_c')"  class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="d" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="flex-1">
                        <div class="flex flex-col">
                            <question-editor class="border border-gray-600 bg-white rounded-md" :content="form.option_d" @input="inputChange($event, 'option_d')"></question-editor>
                        </div>
                        <jet-input-error :message="form.error('option_d')"  class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <button @click.prevent="updateQuestion" class="inline-flex items-center px-2 py-1 bg-gray-900 text-white text-xs font-bold tracking-widest uppercase rounded hover:bg-gray-600 focus:outline-none">
                    Update
                </button>
                <button @click.prevent="$emit('cancel-update')" class="inline-flex items-center ml-3 px-2 py-1 bg-red-700 text-white text-xs font-bold tracking-widest uppercase rounded hover:bg-red-500 focus:outline-none">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import QuestionEditor from "@/Shared/Editor"
    import JetInputError from '@/Jetstream/InputError'

    export default {
        components: {
            QuestionEditor,
            JetInputError
        },

        props: ['question'],

        data() {
            return {
                form: this.$inertia.form({
                    question: this.question.question,
                    option_a: this.question.option_a,
                    option_b: this.question.option_b,
                    option_c: this.question.option_c,
                    option_d: this.question.option_d,
                    answer: this.question.answer
                }, {
                    bag: 'updateQuestion',
                }),
            }
        },

        methods: {
            updateQuestion() {
                this.form.put(route('questions.update', this.question.id), {
                    preserveScroll: true,
                }).then(() => {
                    if(! this.form.hasErrors()) {
                        this.$emit('cancel-update');
                    }
                });
            },
            inputChange(event, property) {
                this.form[property] = event;
            }
        }
    }
</script>
