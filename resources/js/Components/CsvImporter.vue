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
                <table v-bind="$attrs" v-if="sample">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Column</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(field, key) in fields" :key="key">
                            <td>
                                {{ field.label }}
                                <span v-if="field.required">*</span>
                            </td>
                            <td>
                                <select :name="`csv_uploader_map_${key}`"
                                        v-model="map[field.key]"
                                >
                                    <option v-if="!field.required" :value="null">&nbsp;</option>
                                    <option v-for="(column, key) in sample"
                                            :key="key"
                                            :value="key"
                                    >
                                        {{ column }}
                                    </option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
