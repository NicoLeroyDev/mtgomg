<template>
    <nav class="navigation bg-tertiary">
        <!-- Logo -->
        <div class="logo-wrapper">
            <Link :href="route('dashboard')">
                <jet-application-mark class="block h-9 w-auto" />
            </Link>
        </div>

        <!-- Navigation Links -->
        <div class="navlinks flex flex-col">
            <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                Dashboard
            </jet-nav-link>

            <jet-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                Profile
            </jet-nav-link>
        </div>

        <!-- Hamburger -->
        <div class="-mr-2 flex items-center sm:hidden">
            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <jet-responsive-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                    Dashboard
                </jet-responsive-nav-link>

                <jet-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                    Profile
                </jet-nav-link>
            </div>
        </div>
    </nav>
</template>

<style lang="scss" scoped>
.navigation {

    .logo-wrapper {
        display: flex;
        justify-content: center;
    }

    .navlinks {
        margin-top: 20px;
    }
}
</style>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
    import JetDropdown from '@/Jetstream/Dropdown.vue'
    import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
    import JetNavLink from '@/Jetstream/NavLink.vue'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        components: {
            JetApplicationMark,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            Link,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },
        }
    }
</script>
