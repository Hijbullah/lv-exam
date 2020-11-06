<template>
    <jet-action-section>
        <template #title>
            Batch Information
        </template>

        <template #description>
            All information about the batch
        </template>

        <template #content>
            <h3 class="mb-5 text-xl font-bold">Batch Name: {{ batch.name }}</h3>
            <div v-html="batch.detail"></div>
        </template>
    </jet-action-section>
</template>

<script>
    import JetActionSection from '@/Jetstream/ActionSection'

    export default {
        components: {
            JetActionSection
        },

        props: ['batch'],    
    }
</script>
