<template>
    <div class="csv-importer">
        <vue-csv-import
            v-model="csv"
            :fields="csvImportFields"
        >
            <vue-csv-toggle-headers></vue-csv-toggle-headers>
            <vue-csv-errors></vue-csv-errors>
            <vue-csv-input name="file">
                <input ref="csv" type="file" @change="customChange" :name="name" v-bind="$attrs">
            </vue-csv-input>
            <button @click.prevent="readCsv">Go!</button>
        </vue-csv-import>
        <div>{{ csv }}</div>
    </div>
</template>

<script>
    import { defineComponent, ref, inject } from 'vue';
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
            csvImportFields: Object,
            tableAttributes: Object,
        },

        emits: [
            'readCsv',
        ],

        setup(props, { emit }) {
            console.log('1');

            const csv = ref(null);
            const fields = props.fields;
            const VueCsvImportData = inject('VueCsvImportData');

            const readCsv = () => {
                emit('readCsv', csv);
            }

            const customChange = function () {
                console.log("dfdd");
                if (!csv || !csv.value) {
                    //VueCsvImportData.file = null;
                    return;
                }

                let tmpFile = csv.value.files ? csv.value.files[0] : null;
                if (validate(tmpFile)) {
                    VueCsvImportData.file = tmpFile;
                }
            }


            return {
                readCsv,
                csv,
                customChange,
            }
        }
    })
</script>
