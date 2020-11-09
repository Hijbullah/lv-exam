<template>
    <jet-action-section @submitted="updateExamSchedule">
        <template #title>
            Exam Schedule
        </template>

        <template #description>
            Add or Update all the information about the exam schedule.
        </template>

        <template #content>
            <!-- <div class="col-span-6">
                <jet-label for="exam_date" value="Exam Date" />
                <jet-input id="exam_date" type="date" class="mt-1 block w-full" v-model="form.exam_date" placeholder="Exam Date" />
                <jet-input-error :message="form.error('exam_date')" class="mt-2" />
            </div>

            <div class="col-span-6 flex space-x-4">
                <div class="w-1/2">
                    <jet-label for="exam_start" value="Exam Start time" />
                    <jet-input id="exam_start" type="time" class="mt-1 block w-full" v-model="form.exam_start" placeholder="Exam Start Time" />
                    <jet-input-error :message="form.error('exam_start')" class="mt-2" />
                </div>
                <div class="w-1/2">
                    <jet-label for="exam_end" value="Exam End Time" />
                    <jet-input id="exam_end" type="time" class="mt-1 block w-full" v-model="form.exam_end" placeholder="Exam End Time" />
                    <jet-input-error :message="form.error('exam_end')" class="mt-2" />
                </div> -->
            <!-- </div> -->
            <div class="">
                <date-time-picker />
            </div>

        </template>

        <!-- <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template> -->
    </jet-action-section>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import DateTimePicker from '@/Shared/DateTimePicker'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetActionSection,
            JetInput,
            JetInputError,
            JetLabel,
            DateTimePicker
        },

        props: ['exam'],
        
        data() {
            return {
                form: this.$inertia.form({
                    exam_date: this.exam.exam_date,
                    exam_start: this.exam.exam_start,
                    exam_end: this.exam.exam_end
                }, {
                    bag: 'updateExamSchedule',
                    resetOnSuccess: false
                })
            }
        },

        methods: {
            updateExamSchedule() {
                this.form.put(route('exams.update-schedule', this.exam.exam_id), {
                    preserveScroll: true,
                })
            },
        },
    }
</script>
