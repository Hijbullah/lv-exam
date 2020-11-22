<template>
    <app-layout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col justify-center items-center">
                    <h2 class="font-bold uppercase tracking-widest">Details Result</h2>
                    <div class="mt-12">
                        <p>{{ result.exam_type }}: {{ result.exam_name }}</p>
                        <p>Correct Answer: {{ result.correct_answer }}</p>
                        <p>Wrong Answer: {{ result.wrong_answer }}</p>
                        <p>Total Mark: {{ result.total_mark }}</p>
                        <p>Position: {{ result.position }}</p>
                    </div>
                </div>    
                    <!-- <div class="mt-6">
                        <inertia-link 
                            :href="route('app.results.index')" 
                            class="inline-flex items-center px-2 py-1 bg-gray-900 text-white text-xs uppercase tracking-widest rounded hover:bg-gray-700 focus:outline-none"
                        >
                           Go Back
                        </inertia-link>
                    </div> -->
                
                <div class="mt-10 ml-20">
                    <div v-for="(question, index) in result.exam_meta_data" :key="index">
                        <div class="flex items-center">
                            <div class="mr-2">{{ index + 1 }}. </div>
                            <div v-html="question.question"></div>
                        </div>
                    
                        <div class="flex ml-10" v-for="(option, key, index) in question.options" :key="index">
                            <div class="mr-2">{{ key }})</div>
                            <div v-html="option"></div>
                        </div>
                        
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
