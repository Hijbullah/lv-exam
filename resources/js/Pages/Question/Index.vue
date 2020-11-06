<template>
    <admin-layout>
        <div class="flex py-8">
           <div class="w-64 mt-12 pr-8 text-right">
               <app-nav-link 
                    :href="route('exams.show', [batch_id, exam.exam_id])" 
                    :active="$page.currentRouteName == 'exams.show'"
                >
                    Dashboard
                </app-nav-link>

               <app-nav-link 
                    :href="route('questions.index', exam.exam_id)" 
                    :active="$page.currentRouteName == 'questions.index'"
                >
                    Questions
                </app-nav-link>

                <app-nav-link 
                    :href="route('batches.show', batch_id)" 
                    :active="$page.currentRouteName == 'batches.show'"
                >
                    Result
                </app-nav-link>

                <app-nav-link 
                    :href="route('exams.index', batch_id)" 
                    :active="$page.currentRouteName == 'exam.index'"
                >
                    Return To All Exam
                </app-nav-link>
           </div>
           <div class="flex-1 px-5">
                <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">
                    Questions for exam: {{ exam.name }}
                </h2>
                <div class="mt-5">
                    <div class="flex justify-center items-center px-2 py-3 bg-gray-700 text-white shadow-lg">
                        <p v-if="questions.length > 0">
                            This exam has <span class="text-xl font-semibold">{{ questions.length }} / {{ exam.total_question }}</span> Questions. 
                            After adding required Questions go to the Publish Section in <inertia-link class="border-b-2 border-red-700 hover:text-red-700" :href="route('exams.show', [batch_id, exam.exam_id])">Exam Dashboard</inertia-link>  and then published the Exam.
                        </p>
                        <p v-else>This exam has 0 Question. To add question click the Button bellow!</p>
                    </div>
                    
                    <div class="flex flex-col mt-4 mb-5 space-y-5">
                        <single-question 
                            v-for="(question, index) in questions" 
                            :key="question.id"
                            :question="question"
                            :serial="index + 1"
                        />
                        <add-question :examId="exam.exam_id" />
                    </div>
                </div>
           </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppNavLink from '@/component/NavLink'
    import AddQuestion from './AddQuestion'
    import SingleQuestion from "./Question";
    

    export default {
        components: {
            AdminLayout,
            AppNavLink,
            AddQuestion,
            SingleQuestion
            
        },
        props: ['exam', 'batch_id', 'questions']
    }
</script>