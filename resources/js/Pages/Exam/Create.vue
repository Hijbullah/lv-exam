<template>
    <admin-layout>
        <div class="flex py-8">
            <div class="w-64 mt-12 pr-8 text-right">
                <app-nav-link 
                        :href="route('exams.index', batch.batch_id)" 
                        :active="$page.currentRouteName == 'exams.index'"
                >
                    Exams
                </app-nav-link>

                <app-nav-link 
                        :href="route('exams.create', batch.batch_id)" 
                        :active="$page.currentRouteName == 'exams.create'"
                >
                    Create New Exams
                </app-nav-link>

                <app-nav-link 
                    :href="route('batches.show', batch.batch_id)" 
                    :active="$page.currentRouteName == 'batches.show'"
                >
                    Batch Dashboard
                </app-nav-link>

                <app-nav-link 
                    :href="route('batches.index')" 
                    :active="$page.currentRouteName == 'batches.index'"
                >
                    Return To All batch
                </app-nav-link>
            </div>

            <div class="flex-1 px-5">
                <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Creat new Exam for batch: {{ batch.name }}</h2>
                <div class="pt-5">
                    <form @submit.prevent="createExam">
                        <div class="flex flex-col ">
                            <div class="w-full flex items-center mt-4">
                                <div class="w-1/2">
                                    <jet-label for="exam_type" value="Exam Type" />
                                    <jet-input v-model="form.exam_type" id="exam_type" type="text" class="mt-1 block w-full" placeholder="Ex. Assignment Text" />
                                    <jet-input-error :message="form.error('exam_type')"  class="mt-2" />
                                </div>
                            </div>

                            <div class="w-full mt-4">
                                <jet-label for="name" value="Exam Name" />
                                <jet-input v-model="form.name" id="name" type="text" class="mt-1 block w-full" placeholder="Exam Name" />
                                <jet-input-error :message="form.error('name')"  class="mt-2" />
                            </div>

                            <div class="mt-8">
                                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Save Exam
                                </jet-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppNavLink from '@/component/NavLink'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetButton from '@/Jetstream/Button'

    export default {
        components: {
            AdminLayout,
            AppNavLink,
            JetInput,
            JetInputError,
            JetLabel,
            JetButton
        },
        props: ['batch'],
        data() {
            return {
                hasNegetiveMark: false,
                showSubjectForm: false,

                form: this.$inertia.form({
                    batch_id: this.batch.id,
                    name: '',
                    exam_type: ''
                }, {
                    bag: 'createExam',
                }),
            }
        },
        methods: {
            createExam(){
                this.form.post(route('exams.store', this.batch.batch_id), {
                    preserveScroll: true,
                });
            }
        } 
    }
</script>