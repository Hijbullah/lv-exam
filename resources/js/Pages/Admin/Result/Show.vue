<template>
    <admin-layout>
        <div class="flex py-8">
            <div class="w-64 mt-12 pr-8 text-right">
                 <app-nav-link 
                    :href="route('results.index', exam.exam_id)" 
                    :active="$page.currentRouteName == 'results.index'"
                >
                    Go Back
                </app-nav-link>
            </div>
            <div class="flex-1 px-5">
                <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Result</h2>
                <div class="mt-5">
                    <div class="w-1/2 mx-auto">
                        <div class="flex justify-between items-center bg-white px-4 py-3 border-b">
                            <p class="w-1/2 text-right text-xl font-semibold">Exam Name: </p>
                            <p class="w-1/2 text-center font-bold">{{ result.exam_type }}: {{ result.exam_name }}</p>
                        </div>
                        <div class="flex justify-between items-center bg-white px-4 py-3 border-b">
                            <p class="w-1/2 text-right text-xl font-semibold">Total Answered: </p>
                            <p class="w-1/2 text-center font-bold">{{ result.total_answered }} / {{ result.total_question }}</p>
                        </div>
                        <div class="flex justify-between items-center bg-white px-4 py-3 border-b">
                            <p class="w-1/2 text-right text-xl font-semibold">Correct Answer: </p>
                            <p class="w-1/2 text-center font-bold">{{ result.correct_answer }}</p>
                        </div>
                        <div class="flex justify-between items-center bg-white px-4 py-3 border-b">
                            <p class="w-1/2 text-right text-xl font-semibold">Wrong Answer: </p>
                            <p class="w-1/2 text-center font-bold">{{ result.wrong_answer }}</p>
                        </div>
                        <div class="flex justify-between items-center bg-white px-4 py-3 border-b">
                            <p class="w-1/2 text-right text-xl font-semibold">Total Mark: </p>
                            <p class="w-1/2 text-center font-bold">{{ result.total_mark }}</p>
                        </div>
                        <div class="flex justify-between items-center bg-white px-4 py-3 border-b">
                            <p class="w-1/2 text-right text-xl font-semibold">Exam Duration: </p>
                            <p class="w-1/2 text-center font-bold">{{ result.exam_duration }}</p>
                        </div>
                        <div class="flex justify-between items-center bg-white px-4 py-3">
                            <p class="w-1/2 text-right text-xl font-semibold">Position: </p>
                            <p class="w-1/2 text-center font-bold">{{ result.position ? result.position : '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppNavLink from '@/component/NavLink'
    
    export default {
        components: {
            AdminLayout,
            AppNavLink,
        },
        props: {
            exam: Object,
            result: Object,
        }
    }
</script>