<template>
    <app-layout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col justify-center items-center">
                    <h2 class="font-bold uppercase tracking-widest">Result Summery</h2>
                    <div class="mt-12">
                        <p>{{ result.exam_type }}: {{ result.exam_name }}</p>
                        <p>Correct Answer: {{ result.correct_answer }}</p>
                        <p>Wrong Answer: {{ result.wrong_answer }}</p>
                        <p>Total Mark: {{ result.total_mark }}</p>
                        <p v-if="result.position">Position: {{ result.position }}</p>
                    </div>
                    <div v-if="!result.is_published" class="mt-6">
                        <p>Details result will be published after exam Schedule.</p>
                    </div>
                    <div class="mt-6">
                        <inertia-link 
                            v-if="result.is_published"
                            :href="route('app.results.details', result.result_id)" 
                            class="inline-flex items-center px-2 py-1 bg-gray-900 text-white text-xs uppercase tracking-widest rounded hover:bg-gray-700 focus:outline-none"
                        >
                            Details Result
                        </inertia-link>

                        <inertia-link 
                            :href="route('app.results.index')" 
                            class="inline-flex items-center px-2 py-1 bg-gray-900 text-white text-xs uppercase tracking-widest rounded hover:bg-gray-700 focus:outline-none"
                        >
                           Back To All Results
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout
        },
        props: ['result']
    }
</script>
