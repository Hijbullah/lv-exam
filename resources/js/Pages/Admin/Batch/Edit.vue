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
                    :active="$page.currentRouteName == 'batches.edit'"
                    >
                    Edit Batch
                </app-nav-link>
           </div>
           <div class="flex-1 px-5">
                <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Edit Batch</h2>
                <div class="pt-5">
                    <form @submit.prevent="updateBatch">
                        <div class="flex flex-col ">
                            <div class="w-full">
                                <jet-label for="name" value="Batch Name" />
                                <jet-input v-model="form.name" id="name" type="text" class="mt-1 block w-full" placeholder="Batch Name" autocomplete="name" />
                                <jet-input-error :message="form.error('name')"  class="mt-2" />
                            </div>
                            <div class="w-full mt-4 editor">
                                <jet-label for="detail" value="Batch Name" />
                                <editor class="mt-2 bg-white border border-gray-300 rounded-md"
                                    :content="form.detail" 
                                    @input="inputChange"
                                />                                
                                <jet-input-error :message="form.error('detail')"  class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-4 text-right">
                            <!-- <jet-action-message :on="updateBatchForm.recentlySuccessful" class="mr-3">
                                Saved.
                            </jet-action-message> -->

                            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Update
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
    import Editor from '@/Shared/Editor'
    import JetButton from '@/Jetstream/Button'
    import JetActionMessage from '@/Jetstream/ActionMessage'

    export default {
        components: {
            AdminLayout,
            AppNavLink,
            JetInput,
            JetInputError,
            JetLabel,
            Editor,
            JetButton,
            JetActionMessage
        },
        props: ['batch'],
        data() {
            return {
                form: this.$inertia.form({
                    '_method': 'PUT',
                    name: this.batch.name,
                    detail: this.batch.detail,
                }, {
                    bag: 'updateBatch',
                    resetOnSuccess: true,
                }),
            }
        },
        methods: {
            updateBatch(){
                this.form.post(route('batches.update', this.batch.batch_id), {
                    preserveScroll: true,
                });
            },
            inputChange(event) {
                this.form.detail = event;
            }
        }
        
        
    }
</script>