<template>
    <app-layout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-gray-900 text-2xl font-semibold border-b-2 border-gray-900">My Results</h2>
                <div class="w-full overflow-hidden mt-8">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden">
                                    <table class="min-w-full">
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="result in results.data" :key="result.id">
                                                <td class="px-6 py-4 whitespace-no-wrap">
                                                    <div class="flex items-center">
                                                        <h4>{{ result.exam }}</h4>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap">
                                                    <p>Date: {{ result.exam_date }}</p>
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap">
                                                    <p>Total Mark: {{ result.total_mark }}</p>
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                                    <inertia-link 
                                                        :href="route('app.exams.result-summary', result.result_id)" 
                                                        class="inline-flex items-center px-2 py-1 bg-gray-900 text-white text-xs uppercase tracking-widest rounded hover:bg-gray-700 focus:outline-none"
                                                    >
                                                        Summary
                                                    </inertia-link>

                                                    <inertia-link 
                                                        :href="route('app.results.details', result.result_id)" 
                                                        class="inline-flex items-center px-2 py-1 bg-gray-900 text-white text-xs uppercase tracking-widest rounded hover:bg-gray-700 focus:outline-none"
                                                    >
                                                        Details
                                                    </inertia-link>
                                                </td>
                                            </tr>
                                            <tr v-if="results.data.length === 0">
                                                <td class="px-6 py-4" colspan="4">No results found.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <pagination v-if="results.data.length" :links="results.links" />
                                </div>
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
    import JetButton from '@/Jetstream/Button'
    import Pagination from '@/Shared/Pagination'

    export default {
        components: {
            AppLayout,
            JetButton,
            Pagination
        },
        props: {
            results: Object
        }
    }
</script>
