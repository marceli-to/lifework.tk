<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Blog</h1>
      <router-link :to="{ name: 'post-create' }" class="feather-icon feather-icon--prepend">
        <plus-icon size="16"></plus-icon>
        <span>Hinzufügen</span>
      </router-link>
    </header>
    <div class="listing" v-if="post.length">
      <div
        :class="[p.publish == 0 ? 'is-disabled' : '', 'listing__item']"
        v-for="p in post"
        :key="p.id"
      >
        <div class="listing__item-body">
          {{ p.date }}<separator />{{ p.title }}
        </div>
        <list-actions 
          :id="p.id" 
          :record="p"
          :routes="{edit: 'post-edit'}">
        </list-actions>
      </div>
    </div>
    <div v-else>
      <p class="no-records">Es sind noch keine Posts vorhanden..</p>
    </div>
  </div>
</div>
</template>
<script>

// Icons
import { PlusIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/components/ui/ListActions.vue";

// Mixins
import ErrorHandling from "@/mixins/ErrorHandling";
import Helpers from "@/mixins/Helpers";
import DateTime from "@/mixins/DateTime";

export default {

  components: {
    ListActions,
    PlusIcon
  },

  mixins: [ErrorHandling, Helpers, DateTime],

  data() {
    return {
      isLoading: false,
      isFetched: false,
      post: []
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/post`).then(response => {
        this.post = response.data.data;
        this.isFetched = true;
      });
    },

    toggle(id,event) {
      let uri = `/api/post/state/${id}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const index = this.post.findIndex(x => x.id === id);
        this.post[index].publish = response.data;
        this.$notify({ type: "success", text: "Status geändert" });
        this.isLoading = false;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/post/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },
  }
}
</script>