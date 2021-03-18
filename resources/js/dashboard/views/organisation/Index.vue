<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Organisationen</h1>
      <router-link :to="{ name: 'organisation-create' }" class="feather-icon feather-icon--prepend">
        <plus-icon size="16"></plus-icon>
        <span>Hinzufügen</span>
      </router-link>
    </header>
    <div class="listing" v-if="organisations.length">
      <draggable 
        :disabled="false"
        v-model="organisations" 
        @end="order()"
        ghost-class="draggable-ghost"
        draggable=".listing__item">
        <div
          :class="[o.publish == 0 ? 'is-disabled' : '', 'listing__item is-draggable']"
          v-for="o in organisations"
          :key="o.id"
        >
          <div class="listing__item-body">
          {{ o.title }}
          </div>
          <list-actions 
            :id="o.id" 
            :record="o"
            :isDraggable="true"
            :routes="{edit: 'organisation-edit'}">
          </list-actions>
        </div>
      </draggable>
    </div>
    <div v-else>
      <p class="no-records">Es sind noch keine Organisationen vorhandet..</p>
    </div>
  </div>
</div>
</template>
<script>

// Icons
import { PlusIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/components/ui/ListActions.vue";
import draggable from "vuedraggable";

// Mixins
import ErrorHandling from "@/mixins/ErrorHandling";
import Helpers from "@/mixins/Helpers";
import DateTime from "@/mixins/DateTime";

export default {

  components: {
    ListActions,
    PlusIcon,
    draggable
  },

  mixins: [ErrorHandling, Helpers],

  data() {
    return {
      isLoading: false,
      isFetched: false,
      organisations: []
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/organisations`).then(response => {
        this.organisations = response.data.data;
        this.isFetched = true;
      });
    },

    toggle(id,event) {
      let uri = `/api/organisation/state/${id}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const index = this.organisations.findIndex(x => x.id === id);
        this.organisations[index].publish = response.data;
        this.$notify({ type: "success", text: "Status geändert" });
        this.isLoading = false;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/organisation/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },

    order() {
      let organisations = this.organisations.map(function(t, index) {
        t.order = index;
        return t;
      });
      if (this.debounce) return;
      this.debounce = setTimeout(function() {
        this.debounce = false 
        this.axios.post(`/api/organisations/order`, {organisations: organisations}).then((response) => {
          this.$notify({type: 'success', text: 'Reihenfolge angepasst'});
        });
      }.bind(this, organisations), 500);
    },
  }
}
</script>