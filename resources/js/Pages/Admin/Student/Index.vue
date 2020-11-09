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
                <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">All Student</h2>
                <div class="mt-5">
                    <div class="mb-6 flex justify-between items-center">
                        <search-filter v-model="form.search" class="w-full max-w-lg mr-4" @reset="reset">
                            <select v-model="form.type" class="px-4 py-2">
                                <option :value="null">Select a Type</option>
                                <option value="approved">Approved</option>
                                <option value="un_approved">Un Approved</option>
                            </select>
                        </search-filter>
                        <inertia-link :href="route('students.index', {batch: batch.batch_id, search: 'anything'})">
                            <span>Create</span>
                            <span class="hidden md:inline">student</span>
                        </inertia-link>
                    </div>

                    <div class="bg-white rounded shadow overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <tr class="text-left font-bold">
                                <th class="px-6 pt-4 pb-4">Name</th>
                                <th class="px-6 pt-4 pb-4">Email</th>
                                <th class="px-6 pt-4 pb-4">Joined At</th>
                                <th class="px-6 pt-4 pb-4">Status</th>
                                <th class="px-6 pt-4 pb-4">Action</th>
                            </tr>
                            <tr v-for="student in students.data" :key="student.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                                <td class="border-t px-6 py-2">
                                    {{ student.name }}
                                </td>
                                <td class="border-t px-6 py-2">
                                    {{ student.email }}
                                </td>
                                <td class="border-t px-6 py-2">
                                    {{ student.created_at }}
                                </td>
                                <td class="border-t px-6 py-2">
                                    <p v-if="student.is_approved" class="inline-flex items-center px-2 py-1 bg-green-600 text-white text-xs font-bold uppercase tracking-widest rounded-full">Approved</p>
                                    <p v-else class="inline-flex items-center px-2 py-1 bg-red-600 text-white text-xs font-bold uppercase tracking-widest rounded-full">Unapproved</p>
                                </td>
                                <td class="border-t px-6 py-2">
                                    <button 
                                        v-if="student.is_approved"
                                        @click.prevent="approvedStudent(student.id, student.is_approved)"
                                        class="inline-flex items-center px-2 py-1 bg-red-600 text-white text-xs uppercase tracking-widest rounded hover:bg-red-500 focus:outline-none"
                                    >
                                       unapprove
                                    </button>
                                    <button 
                                        v-else
                                        @click.prevent="approvedStudent(student.id, student.is_approved)"
                                        class="inline-flex items-center px-2 py-1 bg-gray-900 text-white text-xs uppercase tracking-widest rounded hover:bg-gray-700 focus:outline-none"
                                    >
                                        approve
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="students.data.length === 0">
                                <td class="border-t px-6 py-4" colspan="4">No students found.</td>
                            </tr>
                        </table>
                    </div>

                    <pagination :links="students.links" />
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppNavLink from '@/component/NavLink'
    import mapValues from 'lodash/mapValues'
    import Pagination from '@/Shared/Pagination'
    import pickBy from 'lodash/pickBy'
    import SearchFilter from '@/Shared/SearchFilter'
    import throttle from 'lodash/throttle'
    
    export default {
    components: {
        AdminLayout,
        AppNavLink,
        Pagination,
        SearchFilter,
    },
    props: {
        batch: Object,
        students: Object,
        filters: Object,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                type: this.filters.type
            },
        }
    },
    watch: {
        form: {
            handler: throttle(function() {
                let query = pickBy(this.form);
                query.batch = this.batch.batch_id;
                
                this.$inertia.replace(route('students.index', Object.keys(query).length ? query : { remember: 'forget' }))
            }, 150),
            deep: true,
        },
    },
    methods: {
        approvedStudent(id, status) {
            this.$inertia.post(route('students.approval', id), {status: !status}, {only: ['students']});
        },
        reset() {
            this.form = mapValues(this.form, () => null)
        },
    },
    }
</script>