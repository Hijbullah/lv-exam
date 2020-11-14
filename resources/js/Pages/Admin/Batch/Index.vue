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
                    <div class="mb-6 flex justify-between items-center">
                        <search-filter v-model="form.search" class="w-full max-w-lg mr-4" @reset="reset"></search-filter>
                        <div>
                            <inertia-link 
                                :href="route('batches.create')" 
                                class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                            >
                                Create
                            </inertia-link>
                        </div>
                    </div>

                    <div class="bg-white rounded shadow overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <tr class="text-left font-bold">
                                <th class="px-6 pt-4 pb-4">Name</th>
                                <!-- <th class="px-6 pt-4 pb-4">Exam Date</th>
                                <th class="px-6 pt-4 pb-4">Total Mark</th>
                                <th class="px-6 pt-4 pb-4">Position</th> -->
                                <th class="px-6 pt-4 pb-4">Action</th>
                            </tr>
                            <tr v-for="batch in batches.data" :key="batch.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                                <td class="border-t px-6 py-2">
                                    {{ batch.name }}
                                </td>
                                <!-- <td class="border-t px-6 py-2">
                                    {{ batch.exam_taken_at }}
                                </td>
                                <td class="border-t px-6 py-2">
                                    {{ batch.total_mark }}
                                </td>
                                <td class="border-t px-6 py-2">
                                    {{ batch.position ? batch.position : 'not published yet'}}
                                </td> -->
                                <td class="border-t px-6 py-2">
                                    <inertia-link :href="route('batches.show', batch.batch_id)" class="inline-flex ml-2 px-2 py-1 bg-gray-800 text-white font-semibold text-xs tracking-widest uppercase rounded-md hover:bg-gray-600">Dashboard</inertia-link>
                                    <inertia-link :href="route('batches.edit', batch.batch_id)" class="inline-flex px-2 py-1 bg-gray-800 text-white font-semibold text-xs tracking-widest uppercase rounded-md hover:bg-gray-600">Edit</inertia-link>
                                </td>
                            </tr>
                            <tr v-if="batches.data.length === 0">
                                <td class="border-t px-6 py-4" colspan="5">No batches found.</td>
                            </tr>
                        </table>
                    </div>

                    <pagination v-if="batches.data.length" :links="batches.links" />
                </div>
                <!-- <div class="mt-5">
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
                </div> -->
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppNavLink from '@/component/NavLink'
    import Pagination from '@/Shared/Pagination'
    import SearchFilter from '@/Shared/SearchFilter'

    export default {
        components: {
            AdminLayout,
            AppNavLink,
            Pagination,
            SearchFilter
        },
        props: {
            batches: Object,
            filters: Object
        },
        data() {
            return {
                form: {
                    search: this.filters.search,
                }
            }
        },
        watch: {
            form: {
                handler: _.throttle(function() {
                    let query = _.pickBy(this.form);
                    this.$inertia.replace(route('batches.index', Object.keys(query).length ? query : { remember: 'forget' }))
                }, 150),
                deep: true,
            },
        },
        methods: {
            reset() {
                this.form = _.mapValues(this.form, () => null)
            },
        }
    }
</script>