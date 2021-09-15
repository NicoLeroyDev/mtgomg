<template>
    <Head title="Collection Converter" />

    <div class="collection-converter">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </Link>
            </template>
        </div>

        <div class="container flex mx-auto">
            <form @submit.prevent="convert">
                <div>
                    <label>json</label>
                    <textarea v-model="jsonForm"></textarea>
                </div>
                <button type="submit">convert</button>
            </form>
            <div>
                <label>csv</label>
                <textarea v-model="csvForm"></textarea>
            </div>
        </div>

        <div class="container mx-auto py-16">
            <div class="source-selector">
                <h2>
                    Where does your collection file come from?
                </h2>
                <vue-select :options="vueSelectOptionsSource" v-model="vueSelectSource" :min="1" @selected="showSelectTarget = true">
                    <template #label="{ selected }">
                        <template v-if="selected">
                            <div class="option">
                                <div class="image">
                                    <img :src="selected.image">
                                </div>
                                <div class="text">
                                    {{ selected.label }}
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            Select option
                        </template>
                    </template>

                    <template #dropdown-item="{ option }">
                        <div class="option">
                            <div class="image">
                                <img :src="option.image">
                            </div>
                            <div class="text">
                                {{ option.label }}
                            </div>
                        </div>
                    </template>
                </vue-select>
            </div>
        </div>

        <div class="container mx-auto py-16" :class="{hidden: !showSelectTarget}">
            <vue-csv-import
                v-model="csv"
                :fields="{
                    name: {
                        required: false,
                        label: 'Name'
                    },
                    age: {
                        required: true,
                        label: 'Age'
                    }
                }"
            >
                <vue-csv-toggle-headers></vue-csv-toggle-headers>
                <vue-csv-errors></vue-csv-errors>
                <vue-csv-input></vue-csv-input>
                <vue-csv-map></vue-csv-map>
            </vue-csv-import>
        </div>

        <div class="container mx-auto py-16">
            <div class="source-selector">
                <h2>
                    Where will you upload this collection? (You may choose multiple targets)
                </h2>
                <vue-select :options="vueSelectOptionsTarget" v-model="vueSelectTarget">
                    <template #label="{ selected }">
                        <template v-if="selected">
                            <div class="option">
                                <div class="image">
                                    <img :src="selected.image">
                                </div>
                                <div class="text">
                                    {{ selected.label }}
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            Select option
                        </template>
                    </template>

                    <template #dropdown-item="{ option }">
                        <div class="option">
                            <div class="image">
                                <img :src="option.image">
                            </div>
                            <div class="text">
                                {{ option.label }}
                            </div>
                        </div>
                    </template>
                </vue-select>
            </div>
        </div>

        <div class="container mx-auto flex justify-center mt-4 sm:items-center sm:justify-between">
            <div class="text-center text-sm text-gray-500 sm:text-left">
                <div class="flex items-center">
                    <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="-mt-px w-5 h-5 text-gray-400">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>

                    <a href="https://laravel.bigcartel.com" class="ml-1 underline">
                        Shop
                    </a>

                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="ml-4 -mt-px w-5 h-5 text-gray-400">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>

                    <a href="https://github.com/sponsors/taylorotwell" class="ml-1 underline">
                        Sponsor
                    </a>
                </div>
            </div>

            <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
            </div>
        </div>
    </div>
</template>

<script>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { VueCsvToggleHeaders, VueCsvSubmit, VueCsvMap, VueCsvInput, VueCsvErrors, VueCsvImport } from 'vue-csv-import';
    import VueNextSelect from 'vue-next-select';
    export default {
        components: {
            Head,
            Link,
            VueCsvImport,
            VueCsvErrors,
            VueCsvInput,
            VueCsvMap,
            VueCsvSubmit,
            VueCsvToggleHeaders,
            VueNextSelect,
        },
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        },
        data() {
            return {
                jsonForm: '',
                csvForm:'',
                csv: null,
                value: '',
                showSelectTarget: false,
                isConstructor: true,
                vueSelectSource: null,
                vueSelectOptionsSource: [
                    {label: 'Mana Box', image: '../../images/mana-box-logo.png'},
                    {label: 'Aetherhub', image: '../../images/mana-box-logo.png'},
                    {label: 'MTG Goldfish', image: '../../images/mana-box-logo.png'},
                    {label: 'Deck Box', image: '../../images/mana-box-logo.png'},
                ],
                vueSelectTarget: null,
                vueSelectOptionsTarget: [
                    {label: 'Mana Box', image: '../../images/mana-box-logo.png'},
                    {label: 'Aetherhub', image: '../../images/mana-box-logo.png'},
                    {label: 'MTG Goldfish', image: '../../images/mana-box-logo.png'},
                    {label: 'Deck Box', image: '../../images/mana-box-logo.png'},
                ],
            };
        },
        methods: {
            convert() {
                const parsedJson = JSON.parse(this.jsonForm);
                if (
                    !Array.isArray(parsedJson) ||
                    !parsedJson.every((p) => typeof p === 'object' && p !== null)
                ) {
                    return;
                }
                const heading = Object.keys(parsedJson[0]).join(',');
                const body = parsedJson.map((j) => Object.values(j).join(',')).join('\n');
                this.csvForm = `${heading}${body}`;
            },
        },
    }
</script>

<style lang="scss" scoped>
  @import "../../css/components/vue-select";
</style>
