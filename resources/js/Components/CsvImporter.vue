<template>
    <div class="csv-importer">
        <vue-csv-import
            v-model="csv"
            :fields="{
                name: {
                    required: false,
                    label: 'Name'
                },
                edition: {
                    required: true,
                    label: 'Edition'
                }
            }"
        >
            <vue-csv-toggle-headers></vue-csv-toggle-headers>
            <vue-csv-errors></vue-csv-errors>
            <vue-csv-input name="file"></vue-csv-input>
            <vue-csv-map></vue-csv-map>
            <button @click.prevent="readCsv">Go!</button>
        </vue-csv-import>
    </div>
</template>

<script>
    import { VueCsvToggleHeaders, VueCsvSubmit, VueCsvMap, VueCsvInput, VueCsvErrors, VueCsvImport } from 'vue-csv-import';

    export default {
        components: {
            VueCsvImport,
            VueCsvErrors,
            VueCsvInput,
            VueCsvMap,
            VueCsvSubmit,
            VueCsvToggleHeaders,
        },

        data() {
            return {
                csv: null,
            };
        },

        methods: {
            readCsv() {
                console.log(this.csv, this.csv[1]);
            }
        },
    }
</script>