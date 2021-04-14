<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <form @submit.prevent="submit" class="half-width" v-if="isFetched">
      <header class="content-header">
        <h1>Veranstaltungen</h1>
      </header>
      <div>
        <div class="form-row">
          <file-upload
            :restrictions="'xlsx | max. 16 MB'"
            :maxFiles="99"
            :maxFilesize="16"
            :acceptedFiles="'.xlsx'"
          ></file-upload>
        </div>
      </div>
      <div v-if="hasError">
        <div class="error-box">
          Beim Import ist ein Fehler aufgetreten. <a href="javascript:;" @click.prevent="restore()">Daten zurücksetzen?</a>
        </div>
      </div>
      <div v-else>
        <div class="listing" v-if="files.length">
          <div
            class="listing__item"
            v-for="f in files"
            :key="f.id"
          >
            <div class="listing__item-body">
              <a :href="'/storage/uploads/files/' + f.name" target="_blank"> {{ f.name }}</a> <separator /> {{ f.size}} <separator /> {{ f.type }}
            </div>
            <list-actions 
              :id="f.id" 
              :record="f"
              :isDraggable="false"
              :hasEdit="false"
              :hasImport="true"
              :hasToggle="false">
            </list-actions>
          </div>
        </div>
        <div v-else>
          <p class="no-records">Es sind keine Daten zum importieren vorhanden...</p>
        </div>
      </div>
    </form>
  </div>
</template>
<script>

import FileUpload from "@/components/files/Upload.vue";
import FileEdit from "@/components/files/Edit.vue";
import ListActions from "@/components/ui/ListActions.vue";

// Mixins
import Helpers from "@/mixins/Helpers";
import ErrorHandling from "@/mixins/ErrorHandling";

export default {

  components: {
    FileUpload,
    FileEdit,
    ListActions
  },

  mixins: [Helpers, ErrorHandling],

  data() {
    return {
      isFetched: false,
      isLoading: false,
      hasError: false,
      files: [],
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.isFetched = true;
      this.isLoading = true;
      this.axios.get(`/api/files/fetch`).then(response => {
        this.files = response.data.data;
        this.isFetched = true;
        this.isLoading = false;
      });
    },

    store(upload) {

      let file = {
        id: null,
        name: upload.name,
        size: upload.size,
        type: upload.type
      };

      this.axios.post('/api/file/store', file).then(response => {
        this.$notify({ type: "success", text: "Datei gespeichert!" });
        file.id = response.data.id;
        this.files.push(file);
      });
    },

    import(id) {
      this.isFetched = false;
      this.isLoading = true;
      let _that = this;
      this.axios.get(`/api/file/import/${id}`)
      .then(response => {
        this.$notify({ type: "success", text: "Veranstaltungen importiert!" });
        this.fetch();
      })
      .catch(function(error) {
        _that.hasError = true;
        _that.isFetched = true;
        _that.isLoading = false;
      })
    },

    restore() {
      this.isFetched = false;
      this.isLoading = true;
      this.axios.get(`/api/file/restore`).then(response => {
        this.isFetched = true;
        this.isLoading = false;
        this.hasError = false;
        this.fetch();
        this.$notify({ type: "success", text: "Veranstaltungen wiederhergestellt!" });
      });
    },

    destroy(id,$event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/file/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.isLoading = false;
        });
      }
    }
  }
}
</script>
<style>
.error-box {
  background-color: #DA2C38;
  border: 1px solid red;
  color: #fff;
  margin-bottom: 25px;
  padding: 10px;
}

.error-box a {
  color: #fff;
}
</style>
