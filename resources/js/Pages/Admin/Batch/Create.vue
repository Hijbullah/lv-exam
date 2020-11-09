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
                <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Create New Batch</h2>
                <div class="pt-5">
                    <form @submit.prevent="createBatch">
                        <div class="flex flex-col ">
                            <div class="w-full">
                                <jet-label for="name" value="Batch Name" />
                                <jet-input v-model="createBatchForm.name" id="name" type="text" class="mt-1 block w-full" placeholder="Batch Name" autocomplete="name" />
                                <jet-input-error :message="createBatchForm.error('name')"  class="mt-2" />
                            </div>
                            <div class="w-full mt-4 editor">
                                <jet-label for="detail" value="Batch Name" />
                                <vue-trix v-model="createBatchForm.detail" inputId="detail" class="mt-1 block w-full" placeholder="Details about batch"></vue-trix>
                                <jet-input-error :message="createBatchForm.error('detail')"  class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-4 text-right">
                            <jet-button :class="{ 'opacity-25': createBatchForm.processing }" :disabled="createBatchForm.processing">
                                Save
                            </jet-button>
                        </div>
                    </form>
                </div>
           </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppNavLink from '@/component/NavLink'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import VueTrix from "vue-trix";
    import JetButton from '@/Jetstream/Button'

    export default {
        components: {
            AdminLayout,
            AppNavLink,
            JetInput,
            JetInputError,
            JetLabel,
            VueTrix,
            JetButton
        },
        
        data() {
            return {
                createBatchForm: this.$inertia.form({
                    name: '',
                    detail: '',
                }, {
                    bag: 'createBatch',
                    resetOnSuccess: true,
                }),
            }
        },
        methods: {
            createBatch(){
                 this.createBatchForm.post(route('batches.store'), {
                    preserveScroll: true,
                });
            }
        }
        
        
    }
</script>

<style scoped>
	.editor >>> trix-editor {
		height: 250px !important;
		max-height: 250px !important;
        overflow-y: auto !important;
        background: white !important;
	}
</style>