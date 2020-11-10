<template>
    <jet-action-section @submitted="updateExamSchedule">
        <template #title>
            Exam Schedule
        </template>

        <template #description>
            Add or Update all the information about the exam schedule.
        </template>

        <template #content>
            <div class="flex justify-around items-center">
                <div class="text-center">
                    <p class="mb-3 font-semibold uppercase tracking-widest">Exam Start At</p>
                    <v-date-picker v-model="form.started_at" mode="dateTime" :model-config="modelConfig" />
                </div>
                <div class="text-center">
                    <p class="mb-3 font-semibold uppercase tracking-widest">Exam End At</p>
                    <v-date-picker v-model="form.ended_at" mode="dateTime" :model-config="modelConfig" />
                </div>
            </div>
            <div v-if="form.error('started_at') || form.error('ended_at')" class="flex flex-col justify-center items-center mt-5">
                <jet-input-error :message="form.error('started_at')"  class="mt-2" />
                <jet-input-error :message="form.error('ended_at')"  class="mt-2" />
            </div>
            <div class="mt-5 flex justify-center items-center">
                <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                    Saved.
                </jet-action-message>

                <jet-button @click.native="updateExamSchedule" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </jet-button>
            </div>
        </template>
    </jet-action-section>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetActionSection,
            JetInput,
            JetInputError,
            JetLabel,
        },

        props: ['exam'],
        
        data() {
            return {
                form: this.$inertia.form({
                    started_at: this.exam.started_at,
                    ended_at: this.exam.ended_at
                }, {
                    bag: 'updateExamSchedule',
                    resetOnSuccess: false
                }),
                modelConfig: {
                    type: 'string',
                    mask: 'YYYY-MM-DD HH:mm',
                },
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
