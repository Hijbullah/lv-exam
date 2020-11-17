<template>
    <app-layout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-gray-900 text-2xl font-semibold border-b-2 border-gray-900">My Batch</h2>
                <div class="w-full overflow-hidden mt-8">
                    <div v-if="hasBatch">
                        <div v-if="isBatchApproved" class="flex flex-col items-center justify-center">
                            <p class="text-xl text-gray-900 font-semibold">You Batch is: <span class="text-indigo-600 font-extrabold border-b-2 border-indigo-700">{{ current_batch.name }}</span>.</p>
                            <p class="text-xl text-gray-900 font-semibold">You can now participate in exam and see your result.</p>
                        </div>                  
                        <div v-else class="text-center">
                            <p class="text-xl text-gray-900 font-semibold">You have Requested For Batch <span class="text-indigo-600 font-extrabold border-b-2 border-indigo-700">{{ current_batch.name }}</span>.</p>
                            <p class="text-xl text-gray-900 font-semibold">Wait for Approval.</p>
                        </div>                
                    </div>
                    <div v-else>
                        <div class="max-w-md mx-auto">
                            <p class="mb-4 text-red-700 text-center text-xl font-semibold">You have no Batch! Request for One </p>
                            <div>
                                <h2 class="mb-5 text-xl">Select a batch: </h2>
                                <button 
                                    v-for="batch in batches" :key="batch.id"
                                    @click.prevent="selectBatch(batch.batch_id)"
                                    class="inline-flex items-center px-2 py-1 bg-white text-gray-800 text-base font-bold uppercase tracking-widest border-2 border-gray-700 rounded hover:bg-indigo-600 hover:text-white hover:border-indigo-700 focus:outline-none focus:border-indigo-700 focus:bg-indigo-600 focus:text-white"
                                >
                                    {{ batch.name }}
                                </button>
                            </div>
                            <div v-if="form.batch_id" class="mt-4 space-y-4">
                                <jet-input-error :message="form.error('batch_code')"  class="mt-2" />
                                <button @click.prevent="requestForBatch" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="inline-flex items-center px-3 py-2 bg-gray-900 text-white text-sm font-bold tracking-widest uppercase rounded hover:bg-gray-700 focus:outline-none">Send Request</button>
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
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetButton from '@/Jetstream/Button'

    export default {
        components: {
            AppLayout,
            JetInput,
            JetInputError,
            JetButton
        },
        props: {
            current_batch: Object,
            batches: Array,
        },
        data() {
            return {
                form: this.$inertia.form({
                    batch_id: ''
                }, {
                    bag: 'requestBatch',
                })
            }
        },
        methods: {
            requestForBatch() {
                this.form.post(route('app.batches.request'), {
                    preserveScroll: true
                }).then(() => {
                    if(! this.form.hasErrors()) {
                        this.form.batch_id = '';
                    }
                });
            },
            selectBatch(batchId) {
                this.form.batch_id = batchId;
            }
        },
        computed: {
            hasBatch() {
                return !_.isEmpty(this.current_batch);
            },
            isBatchApproved() {
                return this.current_batch.is_batch_approved;
            }
        }
    }
</script>
