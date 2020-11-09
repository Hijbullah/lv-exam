<template>
    <admin-layout>
        <div class="flex py-8">
            <div class="w-64 mt-12 pr-8 text-right">
                 <app-nav-link 
                    :href="route('exams.show', [batch.batch_id, exam.exam_id])" 
                    :active="$page.currentRouteName == 'exams.show'"
                >
                    Exam Dashboard
                </app-nav-link>
            </div>
            <div class="flex-1 px-5">
                <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">All Result</h2>
                <div class="mt-5">
                    <div class="mb-6 flex justify-between items-center">
                        <search-filter v-model="form.search" class="w-full max-w-lg mr-4" @reset="reset"></search-filter>
                        <div>
                            <loading-button 
                                v-if="results.data.length"
                                class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                                @click.native="publishResult"
                                :loading="sending"
                            >Publish Result</loading-button>
                        </div>
                    </div>

                    <div class="bg-white rounded shadow overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <tr class="text-left font-bold">
                                <th class="px-6 pt-4 pb-4">Name</th>
                                <th class="px-6 pt-4 pb-4">Exam Date</th>
                                <th class="px-6 pt-4 pb-4">Total Mark</th>
                                <th class="px-6 pt-4 pb-4">Position</th>
                                <th class="px-6 pt-4 pb-4">Action</th>
                            </tr>
                            <tr v-for="result in results.data" :key="result.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                                <td class="border-t px-6 py-2">
                                    {{ result.student.name }}
                                </td>
                                <td class="border-t px-6 py-2">
                                    {{ result.exam_taken_at }}
                                </td>
                                <td class="border-t px-6 py-2">
                                    {{ result.total_mark }}
                                </td>
                                <td class="border-t px-6 py-2">
                                    {{ result.position ? result.position : 'not published yet'}}
                                </td>
                                <td class="border-t px-6 py-2">
                                     <inertia-link 
                                        :href="route('results.show', result.result_id)" 
                                        class="inline-flex items-center px-2 py-1 bg-gray-900 text-white text-xs uppercase tracking-widest rounded hover:bg-gray-700 focus:outline-none"
                                    >
                                        Details
                                    </inertia-link>
                                </td>
                            </tr>
                            <tr v-if="results.data.length === 0">
                                <td class="border-t px-6 py-4" colspan="5">No results found.</td>
                            </tr>
                        </table>
                    </div>

                    <pagination v-if="results.data.length" :links="results.links" />
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppNavLink from '@/component/NavLink'
    import LoadingButton from '@/Shared/LoadingButton'
    import mapValues from 'lodash/mapValues'
    import Pagination from '@/Shared/Pagination'
    import pickBy from 'lodash/pickBy'
    import SearchFilter from '@/Shared/SearchFilter'
    import throttle from 'lodash/throttle'
    
    export default {
        components: {
            AdminLayout,
            AppNavLink,
            LoadingButton,
            Pagination,
            SearchFilter,
        },
        props: {
            batch: Object,
            exam: Object,
            results: Object,
            filters: Object,
        },
        data() {
            return {
                sending: false,
                form: {
                    search: this.filters.search
                },
            }
        },
        watch: {
            form: {
                handler: throttle(function() {
                    let query = pickBy(this.form);
                    query.exam = this.exam.exam_id;
                    
                    this.$inertia.replace(route('results.index', Object.keys(query).length ? query : { remember: 'forget' }))
                }, 150),
                deep: true,
            },
        },
        methods: {
            reset() {
                this.form = mapValues(this.form, () => null)
            },
            publishResult() {
                this.$inertia.post(route('results.publish-result', this.exam.exam_id), {}, {
                    preserveScroll: true,
                    onStart: () => this.sending = true,
                    onFinish: () => this.sending = false,
                });
            }
        }
    }
</script>