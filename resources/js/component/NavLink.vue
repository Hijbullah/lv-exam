<template>
    <inertia-link :href="href" :class="classes">
        <slot></slot>
    </inertia-link>
</template>

<script>
    export default {
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                    ? 'flex flex-col items-end px-1 pt-1 text-base font-bold leading-5 text-gray-900 focus:outline-none transition duration-150 ease-in-out'
                    : 'flex flex-col items-end px-1 pt-1 text-base font-medium leading-5 text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out'
            }
        }
    }
</script>
