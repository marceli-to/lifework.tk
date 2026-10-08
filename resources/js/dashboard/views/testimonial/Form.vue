<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <form @submit.prevent="submit" v-if="isFetched">
    <header class="content-header">
      <h1>{{title}}</h1>
    </header>
    <tabs :tabs="tabs" :errors="errors"></tabs>
    <div v-show="tabs.data.active">
      <div :class="[this.errors.title ? 'has-error' : '', 'form-row']">
        <label>Titel*</label>
        <input type="text" v-model="testimonial.title">
        <label-required />
      </div>
      <div :class="[this.errors.text ? 'has-error' : '', 'form-row']">
        <label>Text</label>
        <rich-text-editor v-model="testimonial.text"></rich-text-editor>
      </div>
    </div>
    <div v-show="tabs.settings.active">
      <div> 
        <div class="form-row is-last">
          <radio-button 
            :label="'Publizieren?'"
            v-bind:publish.sync="testimonial.publish"
            :model="testimonial.publish"
            :name="'publish'">
          </radio-button>
        </div>
      </div>
    </div>
    <footer class="module-footer">
      <div>
        <button type="submit" class="btn-primary">Speichern</button>
        <router-link :to="{ name: 'testimonials' }" class="btn-secondary">
          <span>Zurück</span>
        </router-link>
      </div>
    </footer>
  </form>
</div>
</template>
<script>

// Icons
import { ArrowLeftIcon } from 'vue-feather-icons';

// Mixins
import ErrorHandling from "@/mixins/ErrorHandling";

// Editor
import RichTextEditor from "@/components/editor/Editor.vue";

// Components
import RadioButton from "@/components/ui/RadioButton.vue";
import LabelRequired from "@/components/ui/LabelRequired.vue";
import Tabs from "@/components/ui/Tabs.vue";

// Tabs config
import tabsConfig from "@/views/testimonial/config/tabs.js";

export default {
  components: {
    ArrowLeftIcon,
    RichTextEditor,
    RadioButton,
    LabelRequired,
    Tabs
  },

  mixins: [ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      
      // Model
      testimonial: {
        title: null,
        text: null,
        publish: 0,
      },

      // Validation
      errors: {
        title: false,
        text: false,
      },

      // Loading states
      isFetched: true,
      isLoading: false,

      // Tabs config
      tabs: tabsConfig,
    };
  },

  created() {
    if (this.$props.type == "edit") {
      this.isFetched = false;
      let uri = `/api/testimonial/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.testimonial = response.data;
        this.isFetched = true;
      });
    }
  },

  methods: {

    // Submit form
    submit() {
      if (this.$props.type == "edit") {
        this.update();
      }

      if (this.$props.type == "create") {
        this.store();
      }
    },

    store() {
      this.isLoading = true;
      this.axios.post('/api/testimonial', this.testimonial).then(response => {
        this.$router.push({ name: "testimonials" });
        this.$notify({ type: "success", text: "Daten erfasst!" });
        this.isLoading = false;
      });
    },

    update() {
      let uri = `/api/testimonial/${this.$route.params.id}`;
      this.isLoading = true;
      this.axios.put(uri, this.testimonial).then(response => {
        this.$router.push({ name: "testimonials" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
        this.isLoading = false;
      });
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" 
        ? "Artikel bearbeiten" 
        : "Artikel hinzufügen";
    }
  }
};
</script>
