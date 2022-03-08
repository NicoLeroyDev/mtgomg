<template>
  <Head title="Collection Converter" />

  <div class="collection-converter">
    <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
      <Link
        v-if="$page.props.user"
        :href="route('dashboard')"
        class="text-sm text-gray-700 underline"
      >
        Dashboard
      </Link>

      <template v-else>
        <Link :href="route('login')" class="text-sm text-gray-700 underline">
          Log in
        </Link>

        <Link
          v-if="canRegister"
          :href="route('register')"
          class="ml-4 text-sm text-gray-700 underline"
        >
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
          Where will you upload this collection? (You may choose multiple
          targets)
        </h2>
        <custom-select
          :options="vueSelectOptionsSource"
          @updateSelectValue="updateSourceSettings"
        />
      </div>
    </div>

    <div class="container mx-auto py-16">
      <div class="target-selector">
        <h2>
          Where will you upload this collection? (You may choose multiple
          targets)
        </h2>
        <custom-select
          :options="vueSelectOptionsTarget"
          @updateSelectValue="updateTargetSettings"
        />
      </div>
    </div>

    <div class="container mx-auto py-16">
      <csv-importer />
    </div>
  </div>
</template>

<script>
import CsvImporter from '../Components/CsvImporter/CsvImporter.vue';
import CustomSelect from '../Components/CustomSelect.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import VueNextSelect from 'vue-next-select';

export default {
  components: {
    Head,
    Link,
    'vue-select': VueNextSelect,
    CustomSelect,
    CsvImporter,
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
      csvForm: '',
      csv: null,
      value: '',
      isConstructor: true,
      vueSelectSource: null,
      vueSelectOptionsSource: [
        {
          label: 'Mana Box',
          slug: 'manabox',
          image: '../../images/mana-box-logo.png',
        },
        {
          label: 'Aetherhub',
          slug: 'aetherhub',
          image: '../../images/mana-box-logo.png',
        },
        {
          label: 'Other',
          slug: 'other',
          image: '../../images/mana-box-logo.png',
        },
      ],
      vueSelectTarget: null,
      vueSelectOptionsTarget: [
        {
          label: 'Mana Box',
          slug: 'manabox',
          image: '../../images/mana-box-logo.png',
        },
        {
          label: 'Aetherhub',
          slug: 'aetherhub',
          image: '../../images/mana-box-logo.png',
        },
        {
          label: 'MTG Goldfish',
          slug: 'mtggoldfish',
          image: '../../images/mana-box-logo.png',
        },
        {
          label: 'Deck Box',
          slug: 'deckbox',
          image: '../../images/mana-box-logo.png',
        },
      ],
    };
  },

  methods: {
    updateSourceSettings(event) {
      this.sourceConfig = event.value.slug;
      console.log(this.sourceConfig);
    },

    updateTargetSettings(event) {
      this.targetConfig = event.value.slug;
      console.log(this.targetConfig);
    },

    readCsv(event) {
      this.csvContent = event.value;
      console.log(this.csvContent);

      this.csvContent.forEach((card) => {
        console.log(card);
      });
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
};
</script>

<style lang="scss" scoped>
@import '../../css/components/vue-select';
</style>
