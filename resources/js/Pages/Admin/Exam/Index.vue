<template>
    <admin-layout>
        <div class="flex py-8">
            <div class="w-64 mt-12 pr-8 text-right">
                <app-nav-link 
                        :href="route('exams.index', batch.batch_id)" 
                        :active="$page.currentRouteName == 'exams.index'"
                >
                    Exams
                </app-nav-link>

                <app-nav-link 
                        :href="route('exams.create', batch.batch_id)" 
                        :active="$page.currentRouteName == 'exams.create'"
                >
                    Create New Exams
                </app-nav-link>

                 <app-nav-link 
                    :href="route('batches.show', batch.batch_id)" 
                    :active="$page.currentRouteName == 'batches.show'"
                >
                    Batch Dashboard
                </app-nav-link>

                <app-nav-link 
                    :href="route('batches.index')" 
                    :active="$page.currentRouteName == 'batches.index'"
                >
                    Return To All batch
                </app-nav-link>
            </div>

            <div class="flex-1 px-5">
                <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">All Exam</h2>
                <div class="mt-5">
                     <div v-if="exams.length == 0" class="flex flex-col items-center">
                        <p class="pt-6 text-xl font-semibold text-red-600">No Exam found! Create a Exam.</p>
                        <inertia-link :href="route('exams.create', batch.batch_id)" class="inline-flex mt-5 px-4 py-2 bg-gray-800 text-white font-semibold text-xs tracking-widest uppercase rounded-md hover:bg-gray-600">Create new Exam</inertia-link>

                    </div>
                    <div v-else>
                        <div v-for="exam in exams" :key="exam.id">
                            <div class="flex justify-between items-center px-4 py-2 mb-2 bg-white rounded">
                                <h2>{{ exam.name }}</h2>
                                <div>
                                    <inertia-link :href="route('exams.show', [batch.batch_id, exam.exam_id])" class="inline-flex px-2 py-1 bg-gray-800 text-white font-semibold text-xs tracking-widest uppercase rounded-md hover:bg-gray-600">Dashboard</inertia-link>
                                </div>
                            </div>
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
            AppNavLink
        },
        props: ['exams', 'batch']
    }
</script>