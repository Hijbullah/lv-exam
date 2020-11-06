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
                    </div>
                    <div class="mt-6">
                        <p>Details result will be published after exam Schedule.</p>
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
