<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <form @submit.prevent="submit" v-if="isFetched">
    <header class="content-header">
      <h1>{{title}}</h1>
    </header>
    <tabs :tabs="tabs" :errors="errors"></tabs>
    <div v-show="tabs.data.active">
      <div class="form-row">
        <label>Datum</label>
        <input type="text" v-model="post.date">
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
    </div>
    <div v-show="tabs.image.active">
      <div>
        <div class="form-row">
          <image-upload
            :restrictions="'jpg, png | max. 8 MB'"
            :maxFiles="99"
            :maxFilesize="8"
            :acceptedFiles="'.png,.jpg'"
          ></image-upload>
        </div>
        <div class="form-row">
          <image-edit 
            :images="post.images"
            :imagePreviewRoute="'cache'"
            :aspectRatioW="4"
            :aspectRatioH="3"
          ></image-edit>
        </div>
      </div>
    </div>
    <div v-show="tabs.settings.active">
      <div> 
        <div class="form-row is-last">
          <radio-button 
            :label="'Publizieren?'"
            v-bind:publish.sync="post.publish"
            :model="post.publish"
            :name="'publish'">
          </radio-button>
        </div>
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

// TinyMCE
import tinyConfig from "@/config/tiny.js";
import TinymceEditor from "@tinymce/tinymce-vue";

// Components
import RadioButton from "@/components/ui/RadioButton.vue";
import LabelRequired from "@/components/ui/LabelRequired.vue";
import Tabs from "@/components/ui/Tabs.vue";
import ImageUpload from "@/components/images/Upload.vue";
import ImageEdit from "@/views/post/images/Edit.vue";

// Tabs config
import tabsConfig from "@/views/post/config/tabs.js";

export default {
  components: {
    ArrowLeftIcon,
    TinymceEditor,
    RadioButton,
    LabelRequired,
    Tabs,
    ImageUpload,
    ImageEdit
  },

  mixins: [ErrorHandling],

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
        images: [],
        publish: 0,
      },

      // Validation
      errors: {
        title: false,
      },

      // Loading states
      isFetched: true,
      isLoading: false,

      // Tabs config
      tabs: tabsConfig,

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
      this.axios.put(uri, this.post).then(response => {
        this.$router.push({ name: "posts" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
        this.isLoading = false;
      });
    },

    // Store uploaded image
    storeImage(upload) {
      let image = {
        id: null,
        name: upload.name,
        caption: null,
        coords_w: 0,
        coords_h: 0,
        coords_x: 0,
        coords_y: 0,
        orientation: upload.orientation,
        order: 0,
        publish: 1,
      }

      if (this.$props.type == "edit") {
        image.post_id = this.$route.params.id;
        this.axios.post('/api/post/image', image).then(response => {
          this.$notify({ type: "success", text: "Bild gespeichert!" });
          image.id = response.data.postImageId;
          this.post.images.push(image);
        });
      }
      else {
        this.post.images.push(image);
      }
    },

    // Delete by name
    destroyImage(image, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/post/image/${image}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          const index = this.post.images.findIndex(x => x.name === image);
          this.post.images.splice(index, 1);
          this.isLoading = false;
        });
      }
    },

    // Toggle image status
    toggleImage(image, event) {
      if (image.id === null) {
        const index = this.post.images.findIndex(x => x.name === image.name);
        this.post.images[index].publish = image.publish == 1 ? 0 : 1;
      } else {
        let uri = `/api/post/image/state/${image.id}`;
        this.isLoading = true;
        this.axios.get(uri).then(response => {
          const index = this.post.images.findIndex(x => x.id === image.id);
          this.post.images[index].publish = response.data;
          this.isLoading = false;
        });
      }
    },

    // Save coords
    saveImageCoords(image) {
      if (image.id === null) {
        const index = this.post.images.findIndex(x => x.name === image.name);
        this.post.images[index].coords = image.coords;
      } 
      else {
        let uri = `/api/post/image/${image.id}`;
        this.isLoading = true;
        this.axios.put(uri, image).then(response => {
          this.$notify({ type: "success", text: "Änderungen gespeichert!" });
          this.isLoading = false;
        });
      }
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
