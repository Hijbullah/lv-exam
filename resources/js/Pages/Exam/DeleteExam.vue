<template>
    <jet-action-section>
        <template #title>
            Delete Exam
        </template>

        <template #description>
            Permanently delete this Exam.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once This exam is deleted, all of its resources and data will be permanently deleted. Before deleting this exam, please download any data or information that you wish to retain.
            </div>

            <div class="mt-5">
                <jet-danger-button @click.native="confirmExamDeletion">
                    Delete exam
                </jet-danger-button>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <jet-dialog-modal :show="confirmingExamDeletion" @close="confirmingExamDeletion = false">
                <template #title>
                    Delete Exam
                </template>

                <template #content>
                    Are you sure you want to delete this Exam? Once Exam is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete this exam.

                    <div class="mt-4">
                        <jet-input type="password" class="mt-1 block w-3/4" placeholder="Password"
                                    ref="password"
                                    v-model="form.password"
                                    @keyup.enter.native="deleteExam" />

                        <jet-input-error :message="form.error('password')" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button @click.native="confirmingExamDeletion = false">
                        Nevermind
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click.native="deleteExam" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Exam
                    </jet-danger-button>
                </template>
            </jet-dialog-modal>
        </template>
    </jet-action-section>
</template>

<script>
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionSection,
            JetDangerButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
        },

        props: ['exam_id', 'batch_id'],

        data() {
            return {
                confirmingExamDeletion: false,
                deleting: false,

                form: this.$inertia.form({
                    '_method': 'DELETE',
                    password: '',
                    batch_id: this.batch_id,
                }, {
                    bag: 'deleteExam',
                    resetOnSuccess: true
                })
            }
        },

        methods: {
            confirmExamDeletion() {
                this.form.password = '';

                this.confirmingExamDeletion = true;

                setTimeout(() => {
                    this.$refs.password.focus()
                }, 250)
            },

            deleteExam() {
                this.form.post(route('exams.destroy', this.exam_id), {
                    preserveScroll: true
                }).then(response => {
                    if (! this.form.hasErrors()) {
                        this.confirmingExamDeletion = false;
                    }
                })
            },
        }
    }
</script>
