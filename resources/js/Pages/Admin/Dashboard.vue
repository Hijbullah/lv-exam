<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class=" overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- <welcome /> -->

                    <editor v-model.lazy="content"/>
                   
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import Welcome from '@/Jetstream/Welcome'
    import Editor from '@/Shared/Editor'

    export default {
        components: {
            AdminLayout,
            Welcome,
            Editor,
        },
        data() {
            return {
                content: `
                    <h1>Hello! How are you?</h1>
                    <p>this is some text</p>                
                `
            }
        },
        methods: {
            updateContent(event) {
                console.log(event);
            }
        }
    }
</script>
