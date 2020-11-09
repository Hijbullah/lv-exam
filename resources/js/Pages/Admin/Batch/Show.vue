<template>
    <admin-layout>
        <div class="flex py-8">
           <div class="w-64 mt-12 pr-8 text-right">

                <app-nav-link 
                    :href="route('batches.show', batch.batch_id)" 
                    :active="$page.currentRouteName == 'batches.show'"
                    >
                    Batch Dashboard
                </app-nav-link>

                <app-nav-link 
                    :href="route('exams.index', batch.batch_id)" 
                    :active="$page.currentRouteName == 'exams.index'"
                >
                    Exams
                </app-nav-link>

                <app-nav-link 
                    :href="route('students.index', batch.batch_id)" 
                    :active="$page.currentRouteName == 'students.index'"
                >
                    Students
                </app-nav-link>

                <app-nav-link 
                    :href="route('batches.index')" 
                    :active="$page.currentRouteName == 'batches.index'"
                >
                    Return To All batch
                </app-nav-link>
           </div>
           <div class="flex-1 px-5">
               <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Details about {{ batch.name }}</h2>
                <div class="mt-5">
                    <batch-details :batch="batch" />
                    <jet-section-border />
                    <delete-batch :batch_id="batch.batch_id" class="mt-10 sm:mt-0" />
                </div>
           </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppNavLink from '@/component/NavLink'
    import BatchDetails from './BatchDetails'
    import DeleteBatch from './DeleteBatch'
    import JetSectionBorder from '@/Jetstream/SectionBorder'

    export default {
        components: {
            AdminLayout,
            AppNavLink,
            BatchDetails,
            DeleteBatch,
            JetSectionBorder
            
        },
        props: ['batch']
    }
</script>