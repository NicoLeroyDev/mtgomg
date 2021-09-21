<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        components: {
            Link,
        },
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                    ? 'navlink text-white focus:outline-none focus:border-indigo-700 transition'
                    : 'navlink active text-white hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition'
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
