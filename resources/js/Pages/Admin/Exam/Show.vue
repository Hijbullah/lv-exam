<template>
    <admin-layout>
        <div class="flex py-8">
           <div class="w-64 mt-12 pr-8 text-right">
                <app-nav-link 
                    :href="route('exams.show', [batch.batch_id, exam.exam_id])" 
                    :active="$page.currentRouteName == 'exams.show'"
                >
                    Dashboard
                </app-nav-link>

                <app-nav-link 
                    :href="route('results.index', exam.exam_id)" 
                    :active="$page.currentRouteName == 'results.index'"
                >
                    Results
                </app-nav-link>

                <app-nav-link 
                    :href="route('questions.index', exam.exam_id)" 
                    :active="$page.currentRouteName == 'questions.index'"
                >
                    Questions
                </app-nav-link>

                <!-- <a class="flex flex-col items-end px-1 pt-1 text-base font-medium leading-5 text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out" href="#" v-scroll-to="'#exam-schedule'">Exam Schedule</a>
                <a class="flex flex-col items-end px-1 pt-1 text-base font-medium leading-5 text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out" href="#" v-scroll-to="'#negetive-mark'">Negetive Mark</a>
                <a class="flex flex-col items-end px-1 pt-1 text-base font-medium leading-5 text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out" href="#" v-scroll-to="'#publish-exam'">Publish Exam</a>
                <a class="flex flex-col items-end px-1 pt-1 text-base font-medium leading-5 text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out" href="#" v-scroll-to="'#delete-exam'">Delete Exam</a> -->

                <app-nav-link 
                    :href="route('exams.index', batch.batch_id)" 
                    :active="$page.currentRouteName == 'exam.index'"
                >
                    Return To All Exam
                </app-nav-link>
           </div>
           <div class="flex-1 px-5">
               <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Details about exam: {{ exam.name }}</h2>
                <div class="mt-5">
                    <exam-basic-info 
                        id="basic-info" 
                        :exam="exam" 
                    />

                    <jet-section-border />

                    <exam-schedule 
                        id="exam-schedule" 
                        :exam="exam"
                    />

                    <jet-section-border />

                    <exam-negetive-mark 
                        id="negetive-mark"
                        :examId="exam.exam_id" 
                        :hasNegetiveMark="exam.has_negetive_mark" 
                        :negetiveMark="exam.negetive_mark" 
                    />

                    <jet-section-border />

                    <exam-publication 
                        id="publish-exam"
                        :exam="exam" 
                    />

                    <jet-section-border />

                    <delete-exam 
                        id="delete-exam"
                        :exam_id="exam.exam_id" 
                        :batch_id = batch.batch_id
                        class="mt-10 sm:mt-0" 
                    />
                </div>
           </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppNavLink from '@/component/NavLink'
    import ExamBasicInfo from './ExamBasicInfo'
    import ExamSchedule from './ExamSchedule'
    import ExamNegetiveMark from './ExamNegetiveMark'
    import ExamPublication from './ExamPublication'
    import DeleteExam from './DeleteExam'
    import JetSectionBorder from '@/Jetstream/SectionBorder'

    export default {
        components: {
            AdminLayout,
            AppNavLink,
            ExamBasicInfo,
            ExamSchedule,
            ExamNegetiveMark,
            ExamPublication,
            DeleteExam,
            JetSectionBorder
            
        },
        props: ['exam', 'batch']
    }
</script>