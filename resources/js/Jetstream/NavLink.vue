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
                    ? 'navlink text-white transition current'
                    : 'navlink text-white transition'
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
