<template>
    <div class="h-56 w-ull flex flex-col justify-center items-center border-2 rounded">
            <input ref="questions_file" @change="handleUploadedFile" type="file" class="hidden">
            <div class="flex justify-center items-center space-x-1">
                <jet-button @click.native.prevent="selectQuestionFile">
                    {{ form.uploadFile ? 'Change' : 'Select A File' }}
                </jet-button>
                <span v-show="fileName">{{ fileName }}</span>
            </div>
            <div class="mt-5 flex space-x-2 justify-center items-center">
                <loading-button 
                    class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                    @click.native.prevent="uploadQuestionFile"
                    :loading="sending"
                >Upload Questions</loading-button>

                <jet-danger-button @click.native.prevent="hideUploadZone">Cancel</jet-danger-button>
            </div>
            <jet-input-error :message="form.error('uploadFile')"  class="mt-2" />

        </div>
</template>

<script>
    import JetInputError from '@/Jetstream/InputError'
    import JetButton from '@/Jetstream/Button'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import LoadingButton from '@/Shared/LoadingButton'

    export default {
        components: {
            JetInputError,
            JetButton,
            JetDangerButton,
            LoadingButton  
        },

        props: {
            examId: String
        },

        data() {
            return {
                sending: false,
                fileName: '',

                form: this.$inertia.form({
                   uploadFile: null,
                }, {
                    bag: 'uploadQuestionFile',
                }),
            }
        },

        methods: {
            selectQuestionFile() {
                this.$refs.questions_file.click();
            },

            handleUploadedFile(event) {
                this.form.uploadFile = event.target.files[0];
                this.fileName = this.form.uploadFile.name;
                console.log(this.form.uploadFile);
            },

            uploadQuestionFile() {
                this.sending = true;
                this.form.post(route('questions.upload-questions-file', this.examId), {
                    preserveScroll: true,
                }).then(() => {
                    this.sending = false;
                    if(! this.form.hasErrors()) {
                        this.$emit('hide-question-uploadzone')
                    }
                });
            },

            hideUploadZone() {
                this.form.uploadFile = false;
                if(this.form.error('uploadFile')) {
                    this.$inertia.reload();
                }
                this.$emit('hide-question-uploadzone');
            }
        }

    }
</script>
