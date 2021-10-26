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
                <custom-select :options="vueSelectOptionsSource"
                               @updateSelectValue="updateSourceSettings"
                />
            </div>
        </div>

        <div class="container mx-auto py-16">
            <div class="source-selector">
                <h2>
                    Where will you upload this collection? (You may choose multiple targets)
                </h2>
                <custom-select :options="vueSelectOptionsTarget" @updateSelectValue="updateTargetSettings"/>
            </div>
        </div>

        <div class="container mx-auto py-16">
            <csv-importer @readCsv="test" />
        </div>
    </div>
</template>

<script>
    import CustomSelect from '../Components/CustomSelect.vue';
    import CsvImporter from '../Components/CsvImporter.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import VueNextSelect from 'vue-next-select';

    export default {
        components: {
            Head,
            Link,
            'vue-select': VueNextSelect,
            CsvImporter,
            CustomSelect,
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
                isConstructor: true,
                vueSelectSource: null,
                vueSelectTarget: null,
                vueSelectOptionsSource: [
                    {label: 'Mana Box', 'slug': 'manabox', image: '../../images/mana-box-logo.png'},
                    {label: 'Aetherhub', 'slug': 'aetherhub', image: '../../images/mana-box-logo.png'},
                    {label: 'MTG Goldfish', 'slug': 'mtggoldfish', image: '../../images/mana-box-logo.png'},
                    {label: 'Deck Box', 'slug': 'deckbox', image: '../../images/mana-box-logo.png'},
                ],
                vueSelectOptionsTarget: [
                    {label: 'Untapped.gg', 'slug': 'untappedgg', image: '../../images/mana-box-logo.png'},
                    {label: 'Top Decked', 'slug': 'topdecked', image: '../../images/mana-box-logo.png'},
                ],
            };
        },

        methods: {
            updateSourceSettings(event) {
                console.log('source !');
                console.log(event.value);
            },

            updateTargetSettings(event) {
                console.log('target !');
                console.log(event.value);
            },

            test(event) {
                console.log('csv !');
                console.log(event.value);
            },

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
