<template>
    <div class="csv-importer">
        <vue-csv-import
            v-model="csv"
            :fields="csvImportFields"
        >
            <vue-csv-toggle-headers></vue-csv-toggle-headers>
            <vue-csv-errors></vue-csv-errors>
            <vue-csv-input name="file"></vue-csv-input>
            <vue-csv-map v-slot="{sample, map, fields}" :table-attributes="tableAttributes">
                <table>
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Column</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(field, fieldIndex) in fields">
                            <td>
                                {{ field.label }}
                                <span v-if="field.required">*</span>
                            </td>
                            <td>
                                <select :name="`csv_uploader_map_${fieldIndex}`">
                                    <option v-if="!field.required" :value="null">&nbsp;</option>
                                    <option v-for="(item, sampleIndex) in sample"
                                            :key="sampleIndex"
                                            :value="sampleIndex"
                                    >
                                        {{ item }}
                                    </option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
<!--                <div class="sample" v-for="item in sample">-->
<!--                    {{ item }}-->
<!--                </div>-->
<!--                <div class="fields" v-for="field in fields">-->
<!--                    {{ field }}-->
<!--                </div>-->
<!--                <div class="map" v-for="item in map">-->
<!--                    {{ item }}-->
<!--                </div>-->
            </vue-csv-map>
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
            csvImportFields: Object,
            tableAttributes: Object,
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
