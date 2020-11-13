<template>
    <jet-action-section>
        <template #title>
            Exam Publication
        </template>

        <template #description>
            By default exam status is pending. You can published or unpublished exam.
        </template>

        <template #content>
            <h3 class="text-lg font-medium text-gray-900" v-if="examPublished">
                You have Published this exam. 
            </h3>

            <h3 class="text-lg font-medium text-gray-900" v-else>
                You have not stll published this Exam.
            </h3>

            <div class="mt-3 max-w-xl text-sm text-gray-600">
                <p>When exam status is published, Student can take the exam as schedule. otherwise they are unable to take the exam.</p>
                <p class="mt-4 text-base font-semibold">Befor Published the exam You must: </p>
                <ul class="mt-2 pl-3 space-y-1">
                    <li class="flex items-center text-base">
                        <span class="mr-2" :class="[updatedBasicInfo ? 'text-green-600' : 'text-red-600']">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>   
                        </span>
                        Update the <a href="#"  v-scroll-to="'#basic-info'" class="ml-2 font-bold border-b-2 border-gray-900 hover:text-gray-900">Basic Information</a> 
                    </li>
                    <li class="flex items-center text-base">
                        <span class="mr-2" :class="[hasEnoughQuestion ? 'text-green-600' : 'text-red-600']">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>   
                        </span>
                        Add Enough 
                        <inertia-link :href="route('questions.index', exam.exam_id)" class="ml-2 font-bold border-b-2 border-gray-900 hover:text-gray-900">Questions</inertia-link>
                    </li>
                    <li class="flex items-center text-base">
                        <span class="mr-2" :class="[updatedExamSchedule ? 'text-green-600' : 'text-red-600']">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>   
                        </span>
                        Update the <a href="#"  v-scroll-to="'#exam-schedule'" class="ml-2 font-bold border-b-2 border-gray-900 hover:text-gray-900">Exam Schedule</a> 
                    </li>
                </ul>
            </div>

            <div class="mt-5">
                <div v-if="! examPublished">
                    <jet-button @click.native="publishExam" type="button" :class="{ 'opacity-25': enabling }" :disabled="enabling">
                        Publish
                    </jet-button>
                </div>

                <div v-else>
                    <jet-danger-button @click.native="publishExam" :class="{ 'opacity-25': enabling }" :disabled="enabling">
                        Unpublish
                    </jet-danger-button>
                </div>
            </div>
        </template>
    </jet-action-section>
</template>

<script>
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetButton from '@/Jetstream/Button'
    import JetDangerButton from '@/Jetstream/DangerButton'

    export default {
        components: {
            JetActionSection,
            JetButton,
            JetDangerButton
        },
        
        props: ['exam'],

        data() {
            return {
                enabling: false
            }
        },

        methods: {
            publishExam() {
                if(this.hasEnoughQuestion && this.publishExam && this.updatedExamSchedule){
                    this.enabling = true

                    this.$inertia.post(route('exams.publish', this.exam.exam_id), {}, {
                        preserveScroll: true,
                    }).then(() => {
                        this.enabling = false
                    })
                }else {
                    alert('complete the requirement');
                }
            },
        },

        computed: {
            examPublished() {
                return !this.enabling && this.exam.status == 'published'
            },
            hasEnoughQuestion() {
                return this.exam.total_question && (this.exam.total_question <= this.exam.questions_count);
            },
            updatedBasicInfo() {
                return this.exam.total_question && this.exam.pass_mark && this.exam.duration;
            },
            updatedExamSchedule() {
                return this.exam.started_at && this.exam.ended_at;
            }
        }
    }
</script>
