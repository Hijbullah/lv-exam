<template>
    <div class="w-full">
        <div v-if="showAddQuestionForm" class="p-5  shadow-md">
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
                <button @click.prevent="saveQuestion" class="inline-flex items-center px-2 py-1 bg-gray-900 text-white text-xs font-bold tracking-widest rounded hover:bg-gray-700 focus:outline-none">Save Question</button>
            </div>
        </div>
        <div class="mt-5">
            <jet-button v-if="!showAddQuestionForm" @click.native="showAddQuestionForm = true">Add Question</jet-button>
            <jet-danger-button v-else @click.native="hideQuestionForm">Cancel</jet-danger-button>
        </div>
    </div>
</template>

<script>
    import QuestionEditor from "@/Shared/Editor"
    import JetInputError from '@/Jetstream/InputError'
    import JetButton from '@/Jetstream/Button'
    import JetDangerButton from '@/Jetstream/DangerButton'

    export default {
        components: {
            QuestionEditor,
            JetInputError,
            JetButton,
            JetDangerButton
            
        },

        props: ['examId'],

        data() {
            return {
                showAddQuestionForm: false,

                form: this.$inertia.form({
                    question: '<p><strong>Question</strong></p>',
                    option_a: '<p>Option 1</p>',
                    option_b: '<p>Option 2</p>',
                    option_c: '<p>Option 3</p>',
                    option_d: '<p>Option 4</p>',
                    answer: 'a'
                }, {
                    bag: 'createQuestion',
                }),
            }
        },

        methods: {
            hideQuestionForm() {
                this.showAddQuestionForm = false;
                this.form.question = '<p><strong>Question</strong></p>',
                this.form.option_a = '<p>Option 1</p>';
                this.form.option_b = '<p>Option 1</p>';
                this.form.option_c = '<p>Option 1</p>';
                this.form.option_d = '<p>Option 1</p>';
                this.form.answer = 'a';
            },
            saveQuestion() {
                this.form.post(route('questions.store', this.examId), {
                    preserveScroll: true,
                }).then(() => {
                    if(! this.form.hasErrors()) {
                        this.showAddQuestionForm = false;
                    }
                });
            },
            inputChange(event, property) {
                this.form[property] = event;
            }
        }
    }
</script>
