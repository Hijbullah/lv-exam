<template>
    <jet-form-section @submitted="updateBasicInfo">
        <template #title>
            Exam Basic Information
        </template>

        <template #description>
            Add or Update all the information about the exam.
        </template>

        <template #form>
            <div class="col-span-6">
                <jet-label for="name" value="Exam Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Exam Name" />
                <jet-input-error :message="form.error('name')" class="mt-2" />
            </div>

            <div class="col-span-6">
                <jet-label for="exam_type" value="Exam Type" />
                <jet-input id="exam_type" type="text" class="mt-1 block w-full" v-model="form.exam_type" placeholder="Exam Type" />
                <jet-input-error :message="form.error('exam_type')" class="mt-2" />
            </div>
            <div class="col-span-6 flex space-x-4">
                <div class="w-1/3">
                    <jet-label for="total_question" value="Total No of Question" />
                    <jet-input id="total_question" type="text" class="mt-1 block w-full" v-model="form.total_question" placeholder="Total no of Question" />
                    <jet-input-error :message="form.error('total_question')" class="mt-2" />
                </div>
                <div class="w-1/3">
                    <jet-label for="pass_mark" value="Pass Mark" />
                    <jet-input id="pass_mark" type="text" class="mt-1 block w-full" v-model="form.pass_mark" placeholder="Pass Mark (ex. 50)" />
                    <jet-input-error :message="form.error('pass_mark')" class="mt-2" />
                </div>

                <div class="w-1/3">
                    <jet-label for="duration" value="Exam Duration (in minute)" />
                    <jet-input id="duration" type="text" class="mt-1 block w-full" v-model="form.duration" placeholder="Exam duration in minute" />
                    <jet-input-error :message="form.error('duration')" class="mt-2" />
                </div>
            </div>

        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
        },

        props: ['exam'],
        
        data() {
            return {
                form: this.$inertia.form({
                    name: this.exam.name,
                    exam_type: this.exam.exam_type,
                    total_question: this.exam.total_question,
                    pass_mark: this.exam.pass_mark,
                    duration: this.exam.duration
                }, {
                    bag: 'updateExamBasicInfo',
                    resetOnSuccess: false
                })
            }
        },

        methods: {
            updateBasicInfo() {
                this.form.put(route('exams.update-basic-info', this.exam.exam_id), {
                    preserveScroll: true,
                })
            },
        },
    }
</script>
