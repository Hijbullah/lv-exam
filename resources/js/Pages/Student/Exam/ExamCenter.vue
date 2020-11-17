<template>
    <app-layout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-gray-900 text-2xl font-semibold border-b-2 border-gray-900">Exam Center</h2>
                <div class="w-full overflow-hidden mt-8">
                    
                        <div class="flex">
                            <div class="flex-1 bg-white shadow-md">
                                <h4 class="bg-gray-900 px-3 py-2 text-white font-bold uppercase tracking-widest">Current Exam</h4>
                                <div v-if="exam" class="flex justify-between items-center mt-4 px-3 py-3">
                                    <div class="flex items-center">
                                        <p class="text-dark-800 text-xl font-semibold">{{ exam.exam_type }}:</p>
                                        <p class="ml-3 text-dark-800 text-xl font-semibold">{{ exam.name }}</p>
                                    </div>
                                    <div>
                                        <p>Exam Start at: {{ exam.exam_date }} {{ exam.exam_start }}</p>
                                        <p>Exam End at: {{ exam.exam_date }} {{ exam.exam_end }}</p>
                                    </div>
                                    <div>
                                        <button 
                                            @click.prevent="takeExam"
                                            class="px-3 py-2 inline-flex items-center bg-gray-900 text-white text-sm font-semibold uppercase tracking-widest rounded hover:bg-gray-700 focus:outline-none"
                                        >
                                            Take Exam
                                        </button>
                                    </div>
                                </div>
                                <div v-else class="flex flex-col justify-center items-center mt-4 px-4 py-3">
                                    You have no Exam at this time.
                                    <button @click.prevent="reloadPage" class="mt-3 px-2 py-1 inline-flex items-center bg-gray-900 text-white text-sm font-semibold uppercase tracking-widest rounded hover:bg-gray-700">Refresh</button>
                                </div>
                            </div>
                        </div>         
                    
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout
        },
        props: ['exam'],
        computed: {
            hasBatch() {
                return !_.isEmpty(this.$page.batch);
            },
            isBatchApproved() {
                return this.hasBatch && this.$page.batch.is_approved;
            }
        },
        methods: {
            takeExam() {
                if(!confirm('Are you Sure?')) {
                    return;
                };

                this.$inertia.get(route('app.exams.take-exam', this.exam.exam_id));
            },
            reloadPage() {
                this.$inertia.reload();
            }
        },
        mounted() {
            console.log(this.exam);
        }
    }
</script>
