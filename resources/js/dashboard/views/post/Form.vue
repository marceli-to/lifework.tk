<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <form @submit.prevent="submit" v-if="isFetched">
    <header class="content-header">
      <h1>{{title}}</h1>
    </header>
    <div>
      <div :class="[this.errors.date ? 'has-error' : '', 'form-row']">
        <label>Datum*</label>
        <datepicker v-model="post.date" :language="de" :format="dateFormat"></datepicker>
        <label-required />
      </div>
      <div :class="[this.errors.title ? 'has-error' : '', 'form-row']">
        <label>Titel*</label>
        <input type="text" v-model="post.title">
        <label-required />
      </div>
      <div class="form-row">
        <label>Text</label>
        <tinymce-editor
          :api-key="tinyApiKey"
          :init="tinyConfig"
          v-model="post.text"
        ></tinymce-editor>
      </div>
      <div class="form-row is-last">
        <radio-button 
          :label="'Publizieren?'"
          v-bind:publish.sync="post.publish"
          :model="post.publish"
          :name="'publish'">
        </radio-button>
      </div>
    </div>
    <footer class="module-footer">
      <div>
        <button type="submit" class="btn-primary">Speichern</button>
        <router-link :to="{ name: 'posts' }" class="btn-secondary">
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
import DateTime from "@/mixins/DateTime";

// TinyMCE
import tinyConfig from "@/config/tiny.js";
import TinymceEditor from "@tinymce/tinymce-vue";

// Components
import RadioButton from "@/components/ui/RadioButton.vue";
import LabelRequired from "@/components/ui/LabelRequired.vue";

// Datepicker
import Datepicker from "vuejs-datepicker";
import { de } from "vuejs-datepicker/dist/locale";

export default {
  components: {
    ArrowLeftIcon,
    TinymceEditor,
    RadioButton,
    LabelRequired,
    Datepicker,
  },

  mixins: [ErrorHandling, DateTime],

  props: {
    type: String
  },

  data() {
    return {
      
      // Model
      post: {
        date: null,
        title: null,
        text: null,
        publish: 0,
      },

      // Validation
      errors: {
        date: false,
        title: false,
      },

      // Datepicker language
      de: de,

      // Loading states
      isFetched: true,
      isLoading: false,

      // TinyMCE
      tinyConfig: tinyConfig,
      tinyApiKey: 'vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro',
    };
  },

  created() {
    if (this.$props.type == "edit") {
      this.isFetched = false;
      let uri = `/api/post/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.post = response.data;
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
      this.axios.post('/api/post', this.post).then(response => {
        this.$router.push({ name: "posts" });
        this.$notify({ type: "success", text: "Post erfasst!" });
        this.isLoading = false;
      });
    },

    update() {
      let uri = `/api/post/${this.$route.params.id}`;
      this.isLoading = true;
      this.post.date = this.dateFormat(this.post.date);
      this.axios.put(uri, this.post).then(response => {
        this.$router.push({ name: "posts" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
        this.isLoading = false;
      });
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" 
        ? "Post bearbeiten" 
        : "Post hinzufügen";
    }
  }
};
</script>
