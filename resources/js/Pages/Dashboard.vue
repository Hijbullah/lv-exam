<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- <welcome /> -->

                    <editor />
                   
                </div>
            </div>


                     <hr />

                    <div class="mt-12">
                        date picker
                    </div>
                    <div class="w-1/3">
                        <date-picker />

                    </div>
                     <hr />

                    <div class="mt-12">
                        date time picker
                    </div>
                    <div class="w-1/3">
                        <date-time-picker />

                    </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import Welcome from '@/Jetstream/Welcome'
    import Editor from '@/Shared/Editor'
    import DatePicker from '@/Shared/DatePicker'
    import DateTimePicker from '@/Shared/DateTimePicker'

    export default {
        components: {
            AdminLayout,
            Welcome,
            Editor,
            DatePicker,
            DateTimePicker
        },
    }
</script>
