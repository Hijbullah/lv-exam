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
                                <jet-input v-model="form.name" id="name" type="text" class="mt-1 block w-full" placeholder="Batch Name" autocomplete="name" />
                                <jet-input-error :message="form.error('name')"  class="mt-2" />
                            </div>
                            <div class="w-full mt-4 editor">
                                <jet-label for="detail" value="Details About Batch" />
                                <editor class="mt-2 bg-white border border-gray-300 rounded-md"
                                    :content="form.detail" 
                                    @input="inputChange"
                                />
                                <jet-input-error :message="form.error('detail')"  class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-4 text-right">
                            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
    import Editor from '@/Shared/Editor'
    import JetButton from '@/Jetstream/Button'

    export default {
        components: {
            AdminLayout,
            AppNavLink,
            JetInput,
            JetInputError,
            JetLabel,
            Editor,
            JetButton
        },
        
        data() {
            return {
                form: this.$inertia.form({
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
                 this.form.post(route('batches.store'), {
                    preserveScroll: true,
                });
            }, 
            inputChange(event) {
                this.form.detail = event;
            }
        }
        
        
    }
</script>