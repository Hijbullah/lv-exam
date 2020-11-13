<template>
    <div class="w-full">
        <div class="p-5 bg-white shadow-md">
            <div class="w-full">
                <div class="flex flex-col">
                    <input v-model="form.question" placeholder="Question" class="form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                </div>
                <jet-input-error :message="form.error('question')"  class="mt-2" />
            </div>
            
            <div class="pl-8 py-4 space-y-4">
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="a" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="w-1/2">
                        <div class="flex flex-col">
                            <input v-model="form.option_a" placeholder="Option 1" class="form-input block w-full py-1 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        <jet-input-error :message="form.error('option_a')"  class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="b" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="w-1/2">
                        <div class="flex flex-col">
                            <input v-model="form.option_b" placeholder="Option 1" class="form-input block w-full py-1 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        <jet-input-error :message="form.error('option_b')"  class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="c" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="w-1/2">
                        <div class="flex flex-col">
                            <input v-model="form.option_c" placeholder="Option 1" class="form-input block w-full py-1 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        <jet-input-error :message="form.error('option_c')"  class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="d" type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="w-1/2">
                        <div class="flex flex-col">
                            <input v-model="form.option_d" placeholder="Option 1" class="form-input block w-full py-1 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
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
    import JetInputError from '@/Jetstream/InputError'

    export default {
        components: {
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
            }
        }
    }
</script>
