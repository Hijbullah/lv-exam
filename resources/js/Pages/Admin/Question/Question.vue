<template>
    <div>
        <div v-if="!editQuestion" class="relative p-5 bg-white shadow-md">
            <div class="flex items-center mb-2">
                <span class="text-xl font-bold">{{ serial }}.</span>
                <div class="ml-4"
                    v-html="question.question"
                ></div>
            </div>
            <div class="pl-8 space-y-2">
                <div class="flex items-center">
                    <input :checked="question.answer == 'a'" disabled type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="ml-4"
                        v-html="question.option_a"
                    ></div>
                </div>
                <div class="flex items-center">
                    <input :checked="question.answer == 'b'" disabled type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="ml-4"
                        v-html="question.option_b"
                    ></div>
                </div>
                <div class="flex items-center">
                    <input :checked="question.answer == 'c'" disabled type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="ml-4"
                        v-html="question.option_c"
                    ></div>
                </div>
                <div class="flex items-center">
                    <input :checked="question.answer == 'd'" disabled type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="ml-4"
                        v-html="question.option_d"
                    ></div>
                </div>
            </div>
            <div class="absolute right-0 top-0 mt-4 mr-3">
                <button @click.prevent="editQuestion = true" class="inline-flex items-center px-2 py-1 bg-gray-800 text-white text-xs font-bold tracking-widest uppercase rounded hover:bg-gray-600 focus:outline-none">
                    Edit
                </button>
                <button @click.prevent="deleteQuestion(question.id)" class="inline-flex items-center ml-3 px-2 py-1 bg-red-700 text-white text-xs font-bold tracking-widest uppercase rounded hover:bg-red-500 focus:outline-none">
                    Delete
                </button>
            </div>
        </div>
        <div v-else>
            <edit-question :question="question" @cancel-update="editQuestion = false" />
        </div>
    </div>
</template>

<script>
    import EditQuestion from "./EditQuestion";

    export default {
        components: {
            EditQuestion
        },

        props: ['question', 'serial'],

        data() {
            return {
                editQuestion: false
            }
        },

        methods: {
            deleteQuestion(id) {
                this.$inertia.delete(route('questions.destroy', id));
            }
        }
    }
</script>
