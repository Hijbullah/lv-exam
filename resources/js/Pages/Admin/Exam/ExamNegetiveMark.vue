<template>
    <jet-action-section>
        <template #title>
            Exam Negetive Mark
        </template>

        <template #description>
            This is Completely optional. If you have negetive marking in this exam then you can enable it. If you enable, default negetive mark is 0.25. But You can change it.
        </template>

        <template #content>
            <h3 class="text-lg font-medium text-gray-900" v-if="hasNegetiveMark">
                You have enabled Negetive Mark. 
            </h3>

            <h3 class="text-lg font-medium text-gray-900" v-else>
                You have not stll enabled Negetive Mark.
            </h3>

            <div class="mt-5">
                <div v-if="!hasNegetiveMark">
                    <jet-button type="button" @click.native="enabledNegetiveMark" :class="{ 'opacity-25': enabling }" :disabled="enabling">
                        Enable
                    </jet-button>
                </div>

                <div v-else>
                    <jet-danger-button @click.native="disabledNegetiveMark" :class="{ 'opacity-25': disabling }" :disabled="disabling">
                        Disable
                    </jet-danger-button>
                </div>
            </div>

             <div v-if="hasNegetiveMark">
                <div class="mt-4">
                    <p v-if="negetiveMark == '0.25'">Default Negetive Mark is: <span class="font-semibold">0.25</span></p>
                    <p v-else>Negetive Mark is: <span class="font-semibold">{{ negetiveMark }}</span></p>

                    <button v-if="!showNegetiveForm" @click.prevent="showNegetiveForm = true" class="inline-flex items-center mt-2 px-2 py-1 bg-gray-900 text-white text-xs font-semibold tracking-widest uppercase rounded hover:bg-gray-700 focus:outline-none">
                        Change
                    </button>

                    <button v-else @click.prevent="showNegetiveForm = false" class="inline-flex items-center mt-2 px-2 py-1 bg-red-700 text-white text-xs font-semibold tracking-widest uppercase rounded hover:bg-red-600 focus:outline-none">
                        Cancel
                    </button>

                    <div v-if="showNegetiveForm" class="mt-4">
                        <div class="flex items-center">
                            <input v-model="form.negetive_mark" type="text" class="w-48 h-8 px-2 text-sm border border-gray-600 rounded" placeholder="Ex. 0.5">
                            <button @click.prevent="updateNegetiveMark" class="inline-flex items-center ml-3 px-2 py-1 bg-gray-900 text-white text-xs font-semibold tracking-widest uppercase rounded hover:bg-gray-700 focus:outline-none">
                                Save
                            </button>
                        </div>
                        <jet-input-error :message="form.error('negetive_mark')"  class="mt-2" />
                    </div>
                </div>
            </div>

        </template>
    </jet-action-section>
</template>

<script>
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetButton from '@/Jetstream/Button'
    import JetConfirmsPassword from '@/Jetstream/ConfirmsPassword'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetInputError from '@/Jetstream/InputError'

    export default {
        components: {
            JetActionSection,
            JetButton,
            JetConfirmsPassword,
            JetDangerButton,
            JetSecondaryButton,
            JetInputError
        },

        props: ['examId', 'hasNegetiveMark' , 'negetiveMark'],

        data() {
            return {
                showNegetiveForm: false,
                enabling: false,
                disabling: false,

                form: this.$inertia.form({
                    negetive_mark: ''
                }, {
                    bag: 'updateNegetiveMark',
                }),
            }
        },

        methods: {
            enabledNegetiveMark() {
                this.enabling = true

                this.$inertia.post(route('exams.enable-negetive-mark', this.examId), {}, {
                    preserveScroll: true,
                }).then(() => {
                    this.enabling = false
                })
            },

            disabledNegetiveMark() {
                this.disabling = true

                this.$inertia.post(route('exams.enable-negetive-mark', this.examId), {}, {
                    preserveScroll: true,
                }).then(() => {
                    this.disabling = false
                })
            },

            updateNegetiveMark(){
                 this.form.post(route('exams.update-negetive-mark', this.examId), {
                    preserveScroll: true,
                }).then(() => {
                    if (! this.form.hasErrors()) {
                        this.showNegetiveForm = false;
                    }
                });
            }
        },

        computed: {
            twoFactorEnabled() {
                return ! this.enabling && this.$page.user.two_factor_enabled
            }
        }
    }
</script>
