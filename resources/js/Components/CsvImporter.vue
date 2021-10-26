<template>
    <div class="csv-importer">
        <vue-csv-import
            v-model="csv"
            :fields="{
                name: {
                    required: true,
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
        <div>{{ csv }}</div>
    </div>
</template>

<script>
    import { defineComponent, ref } from 'vue';
    import { VueCsvToggleHeaders, VueCsvSubmit, VueCsvMap, VueCsvInput, VueCsvErrors, VueCsvImport } from 'vue-csv-import';

    export default defineComponent({
        components: {
            VueCsvImport,
            VueCsvErrors,
            VueCsvInput,
            VueCsvMap,
            VueCsvSubmit,
            VueCsvToggleHeaders,
        },

        props: {
            csv: Object,
            fields: Object,
        },

        emits: [
            'readCsv',
        ],

        setup(props, { emit }) {
            const csv = ref(null);
            const fields = props.fields;

            const readCsv = () => {
                emit('readCsv', csv);
            }

            return {
                readCsv,
                csv,
            }
        }
    })
</script>
