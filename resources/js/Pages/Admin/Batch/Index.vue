<template>
    <admin-layout>
        <div class="flex py-8">
            <div class="w-64 mt-12 pr-8 text-right">
                    <app-nav-link 
                        :href="route('batches.index')" 
                        :active="$page.currentRouteName == 'batches.index'"
                        >
                        All Batch
                    </app-nav-link>
                    <app-nav-link 
                        :href="route('batches.create')" 
                        :active="$page.currentRouteName == 'batches.create'"
                        >
                        Create New Batch
                    </app-nav-link>
            </div>
            <div class="flex-1 px-5">
                <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">All Batch</h2>
                    <div class="mt-5">
                        <div v-if="batches.length == 0" class="flex flex-col items-center">
                            <p class="pt-6 text-xl font-semibold text-red-600">No batch found! Create a Batch.</p>
                            <inertia-link :href="route('batches.create')" class="inline-flex mt-5 px-4 py-2 bg-gray-800 text-white font-semibold text-xs tracking-widest uppercase rounded-md hover:bg-gray-600">Create new Batch</inertia-link>

                        </div>
                        <div v-else>
                            <div v-for="batch in batches" :key="batch.id">
                                <div class="flex justify-between items-center px-4 py-2 mb-2 bg-white rounded">
                                    <h2>{{ batch.name }}</h2>
                                    <div>
                                        <inertia-link :href="route('batches.edit', batch.batch_id)" class="inline-flex px-2 py-1 bg-gray-800 text-white font-semibold text-xs tracking-widest uppercase rounded-md hover:bg-gray-600">Edit</inertia-link>
                                        <inertia-link :href="route('batches.show', batch.batch_id)" class="inline-flex ml-2 px-2 py-1 bg-gray-800 text-white font-semibold text-xs tracking-widest uppercase rounded-md hover:bg-gray-600">Dashboard</inertia-link>
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
        props: ['batches']
    }
</script>