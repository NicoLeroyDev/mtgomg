<template>
    <vue-select :options="options" v-model="model" :min="1" @selected="showSelectTarget = true">
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
</template>

<script>
    import VueNextSelect from 'vue-next-select';

    export default {
        components: {
            'vue-select': VueNextSelect,
        },

        props: {
            model: null,
            options: null,
        },
    }
</script>

<style lang="scss" scoped>
  @import "../../css/components/vue-select";
</style>