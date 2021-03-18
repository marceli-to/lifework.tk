<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <form @submit.prevent="submit" v-if="isFetched">
    <header class="content-header">
      <h1>{{title}}</h1>
    </header>
    <tabs :tabs="tabs" :errors="errors"></tabs>
    <div v-show="tabs.data.active">
      <div :class="[this.errors.firstname ? 'has-error' : '', 'form-row']">
        <label>Vorname</label>
        <input type="text" v-model="member.firstname">
        <label-required />
      </div>
      <div :class="[this.errors.name ? 'has-error' : '', 'form-row']">
        <label>Name</label>
        <input type="text" v-model="member.name">
        <label-required />
      </div>
      <div :class="[this.errors.quote ? 'has-error' : '', 'form-row']">
        <label>Zitat</label>
        <input type="text" v-model="member.quote">
        <label-required />
      </div>
      <div class="form-row">
        <label>Beschreibung</label>
        <textarea v-model="member.description"></textarea>
      </div>
      <div class="form-row">
        <label>Text</label>
        <tinymce-editor
          :api-key="tinyApiKey"
          :init="tinyConfig"
          v-model="member.text"
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
            :images="member.images"
            :imagePreviewRoute="'cache'"
            :aspectRatioW="1"
            :aspectRatioH="1.3333"
          ></image-edit>
        </div>
      </div>
    </div>
    <div v-show="tabs.file.active">
      <div class="form-row" v-if="member.files.length == 0">
        <file-upload
          :restrictions="'pdf | max. 16 MB'"
          :maxFiles="99"
          :maxFilesize="16"
          :acceptedFiles="'.pdf'"
        ></file-upload>
      </div>
      <div v-if="member.files.length > 0">
        <div class="listing">
          <div
            class="listing__item"
            v-for="f in member.files"
            :key="f.id"
          >
            <div class="listing__item-body">
              <a :href="'/storage/uploads/' + f.name" target="_blank"> {{ f.name }}</a> <separator /> {{ f.size}} <separator /> {{ f.type }}
            </div>
            <file-actions 
              :id="f.id" 
              :file="f"
              :hasEdit="false"
              :hasDestroy="true">
            </file-actions>
          </div>
        </div>
      </div>
    </div>
    <div v-show="tabs.settings.active">
      <div> 
        <div :class="[this.errors.category_id ? 'has-error' : '', 'form-row']" v-if="isFetchedCategories">
          <label>Kategorie*</label>
          <div class="select-wrapper is-medium">
            <select v-model="member.category_id">
              <option v-for="(category, index) in member_categories" :key="index" :value="category.id">
                {{ category.description }}
              </option>
            </select>
          </div>
        </div> 
        <div class="form-row is-last">
          <radio-button 
            :label="'Publizieren?'"
            v-bind:publish.sync="member.publish"
            :model="member.publish"
            :name="'publish'">
          </radio-button>
        </div>
      </div>
    </div>
    <footer class="module-footer">
      <div>
        <button type="submit" class="btn-primary">Speichern</button>
        <router-link :to="{ name: 'members' }" class="btn-secondary">
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
import ImageEdit from "@/views/member/images/Edit.vue";
import FileUpload from "@/components/files/Upload.vue";
import FileEdit from "@/components/files/Edit.vue";
import FileActions from "@/components/files/Actions.vue";

// Tabs config
import tabsConfig from "@/views/member/config/tabs.js";

export default {
  components: {
    ArrowLeftIcon,
    TinymceEditor,
    RadioButton,
    LabelRequired,
    Tabs,
    ImageUpload,
    ImageEdit,
    FileUpload,
    FileEdit,
    FileActions
  },

  mixins: [ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      
      // Model
      member: {
        firstname: null,
        name: null,
        quote: null,
        description: null,
        text: null,
        images: [],
        files: [],
        publish: 0,
        category_id: null,
      },

      member_categories: [],

      // Validation
      errors: {
        title: false,
      },

      // Loading states
      isFetched: true,
      isFetchedCategories: false,
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
      let uri = `/api/member/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.member = response.data;
        this.isFetched = true;
      });
    }

    this.axios.get(`/api/member/categories`).then(response => {
      this.member_categories = response.data.data;
      this.isFetchedCategories = true;
    });
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
      this.axios.post('/api/member', this.member).then(response => {
        this.$router.push({ name: "members" });
        this.$notify({ type: "success", text: "Daten erfasst!" });
        this.isLoading = false;
      });
    },

    update() {
      let uri = `/api/member/${this.$route.params.id}`;
      this.isLoading = true;
      this.axios.put(uri, this.member).then(response => {
        this.$router.push({ name: "members" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
        this.isLoading = false;
      });
    },

    // Store image
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
        image.member_id = this.$route.params.id;
        this.axios.post('/api/member/image', image).then(response => {
          this.$notify({ type: "success", text: "Bild gespeichert!" });
          image.id = response.data.memberImageId;
          this.member.images.push(image);
        });
      }
      else {
        this.member.images.push(image);
      }
    },

    // Delete image by name
    destroyImage(image, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/member/image/${image}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          const index = this.member.images.findIndex(x => x.name === image);
          this.member.images.splice(index, 1);
          this.isLoading = false;
        });
      }
    },

    // Toggle image status
    toggleImage(image, event) {
      if (image.id === null) {
        const index = this.member.images.findIndex(x => x.name === image.name);
        this.member.images[index].publish = image.publish == 1 ? 0 : 1;
      } else {
        let uri = `/api/member/image/state/${image.id}`;
        this.isLoading = true;
        this.axios.get(uri).then(response => {
          const index = this.member.images.findIndex(x => x.id === image.id);
          this.member.images[index].publish = response.data;
          this.isLoading = false;
        });
      }
    },

    // Save coords
    saveImageCoords(image) {
      if (image.id === null) {
        const index = this.member.images.findIndex(x => x.name === image.name);
        this.member.images[index].coords = image.coords;
      } 
      else {
        let uri = `/api/member/image/${image.id}`;
        this.isLoading = true;
        this.axios.put(uri, image).then(response => {
          this.$notify({ type: "success", text: "Änderungen gespeichert!" });
          this.isLoading = false;
        });
      }
    },

    // Store file
    storeFile(upload) {

      let file = {
        id: null,
        name: upload.name,
        size: upload.size,
        type: upload.type
      };

      if (this.$props.type == "edit") {
        file.member_id = this.$route.params.id;
        this.axios.post('/api/member/file', file).then(response => {
          this.$notify({ type: "success", text: "Datei gespeichert!" });
          file.id = response.data.memberFileId;
          this.member.files.push(file);
        });
      }
      else {
        this.member.files.push(file);
      }
    },

    // Delete file by name
    destroyFile(file,$event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/member/file/${file}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          const index = this.member.files.findIndex(x => x.name === file);
          this.member.files.splice(index, 1);
          this.isLoading = false;
        });
      }
    }

  },

  computed: {
    title: function() {
      return this.$props.type == "edit" 
        ? "Person bearbeiten" 
        : "Person hinzufügen";
    }
  }
};
</script>
