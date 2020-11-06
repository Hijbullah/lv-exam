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
                                        <p>{{ results.length }}</p>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="result in results" :key="result.id">
                                                <td class="px-6 py-4 whitespace-no-wrap">
                                                    <div class="flex items-center">
                                                        <h4>{{ result.exam_type }}: {{ result.exam_name }}</h4>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap">
                                                    <p>Date: {{ result.created_at }}</p>
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap">
                                                    <p>Total Mark: {{ result.total_mark }}</p>
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Summary</a>
                                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Details</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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

    export default {
        components: {
            AppLayout,
            JetButton
        },
        props: ['results']
    }
</script>
