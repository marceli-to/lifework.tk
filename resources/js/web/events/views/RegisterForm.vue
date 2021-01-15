<template>
  <div>
    <notifications classes="notification" :position="'top left'" />
    <loading-indicator v-if="isLoading"></loading-indicator>
    <form>
      <div>
        <header>Ja, ich melde mich an</header>
        <div class="form-group">
          <label>Vorname *</label>
          <input type="text" v-model="form.firstname" name="firstname">
        </div>
        <div class="form-group">
          <label>Name *</label>
          <input type="text" v-model="form.name" name="name">
        </div>
        <div class="form-group">
          <label>Strasse / Nr. *</label>
          <input type="text" v-model="form.street" name="street">
        </div>
        <div class="form-group">
          <label>PLZ / Ort *</label>
          <input type="text" v-model="form.location" name="location">
        </div>
        <div class="form-group">
          <label>Telefon P *</label>
          <input type="text" v-model="form.phone_private" name="phone_private">
        </div>
        <div class="form-group">
          <label>Telefon G</label>
          <input type="text" v-model="form.phone_business" name="phone_business">
        </div>
        <div class="form-group">
          <label>E-Mail *</label>
          <input type="text" v-model="form.email" name="email">
        </div>
        <div class="form-group-checkbox">
          <div>
            <input type="checkbox" name="toc" value="1" id="toc" ref="toc">
            <div class="checkbox"><span></span></div>
          </div>
          <label for="toc">Ich bin mit den <a href="/agb" target="_blank">AGBs</a> einverstanden</label>
        </div>
        <div class="form-group form-group-button">
          <input type="submit" class="btn-primary" @click.prevent="store()" value="anmelden">
        </div>
      </div>
    </form>
  </div>
</template>
<script>

// Mixins
import LabelRequired from "@/components/ui/LabelRequired.vue";
import Errors from "@events/mixins/Errors";

export default {

  mixins: [Errors],
  
  components: {
    LabelRequired,
  },

  props: {
    eventId: {
      type: String,
      default: 0
    }
  },

  data() {
    return {

      // Form
      form: {
        firstname: null,
        name: null,
        street: null,
        location: null,
        phone_private: null,
        phone_business: null,
        email: null,
        event_id: null,
      },

      // Validation
      errors: {
        firstname: false,
        name: false,
        street: false,
        location: false,
        phone_private: false,
        email: false,
      },

      // States
      isLoading: false,
    };
  },

  created() {
    this.form.event_id = this.$props.eventId;
  },

  methods: {

    store() {

      if (this.$refs.toc.checked == false) {
        this.$notify({ type: "error", text: "Bitte AGB akzeptieren!" });
        return false;
      }

      this.isLoading = true;
      this.axios.post('/api/register', this.form)
      .then(response => {
        this.$notify({ type: "success", text: "Ihre Anmeldung wurde registriert!" });
        this.isLoading = false;
        this.reset();
      }).catch((error) => {
        this.$notify({ type: "error", text: "Bitte alle mit * markierten Felder prüfen!" });
        this.isLoading = false;
      });
    },

    reset() {
      this.form.firstname = null;
      this.form.name = null;
      this.form.street = null;
      this.form.location = null;
      this.form.phone_private = null;
      this.form.phone_business = null;
      this.form.email = null;
    }
  }
}
</script>

