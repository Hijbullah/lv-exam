<template>
    <admin-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <h2 class="text-center text-4xl font-bold uppercase tracking-widest">Admin Dashboard</h2>
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
