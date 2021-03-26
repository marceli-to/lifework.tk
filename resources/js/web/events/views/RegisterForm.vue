<template>
  <div v-if="isVisible">
    <notifications classes="notification" :position="'top left'" />
    <loading-indicator v-if="isLoading"></loading-indicator>
    <form>
      <div>
        <header>Ja, ich melde mich an</header>
        <div class="form-group">
          <label>Anmeldung für</label>
          <div class="select-wrapper">
            <select v-model="form.type">
              <option value="0">Bitte wählen...</option>
              <option value="1">mich selbst</option>
              <option value="2">jemand anderes</option>
            </select>
          </div>
        </div>
        <div v-if="form.type == 1 || form.type == 2">
          <div v-if="form.type == 2">
            <header class="form__header">Daten Teilnehmer*in</header>
            <div :class="[this.errors.participant_firstname ? 'has-error' : '', 'form-group']">
              <label>Vorname *</label>
              <input type="text" v-model="form.participant_firstname" name="firstname">
            </div>
            <div :class="[this.errors.participant_name ? 'has-error' : '', 'form-group']">
              <label>Name *</label>
              <input type="text" v-model="form.participant_name" name="name">
            </div>
          </div>

          <header class="form__header" v-if="form.type == 2">Meine Daten</header>
          <div :class="[this.errors.firstname ? 'has-error' : '', 'form-group']">
            <label>Vorname *</label>
            <input type="text" v-model="form.firstname" name="firstname">
          </div>
          <div :class="[this.errors.name ? 'has-error' : '', 'form-group']">
            <label>Name *</label>
            <input type="text" v-model="form.name" name="name">
          </div>
          <div :class="[this.errors.email ? 'has-error' : '', 'form-group']">
            <label>E-Mail *</label>
            <input type="text" v-model="form.email" name="email">
          </div>
          <div :class="[this.errors.phone ? 'has-error' : '', 'form-group']">
            <label>Telefon *</label>
            <input type="text" v-model="form.phone" name="phone">
          </div>
          <div :class="[this.errors.organisation ? 'has-error' : '', 'form-group']">
            <label v-if="form.type == 1">Organisation</label>
            <label v-if="form.type == 2">Organisation *</label>
            <input type="text" v-model="form.organisation" name="organisation">
          </div>
          <div :class="[this.errors.address ? 'has-error' : '', 'form-group']">
            <label>Rechnungsadresse *</label>
            <textarea v-model="form.address" name="address"></textarea>
          </div>
          <div class="form-group">
            <label>Bemerkungen</label>
            <textarea v-model="form.remarks" name="remarks"></textarea>
          </div>
          <div class="form-group-checkbox">
            <div>
              <input type="checkbox" name="is_member" value="1" id="is_member" ref="is_member" v-model="form.is_member">
              <div class="checkbox"><span></span></div>
            </div>
            <label for="is_member">Mitglied Netzwerk Bildungsort Kita</label>
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
        email: null,
        phone: null,
        address: null,
        organisation: null,
        event_id: null,
        is_member: 0,
        type: 0,
        participant_firstname: null,
        participant_name: null,
        remarks: null,
      },

      // Validation
      errors: {
        firstname: false,
        name: false,
        email: false,
        phone: false,
        address: false,
        organisation: false,
        participant_firstname: false,
        participant_name: false,
      },

      // States
      isLoading: false,
      isVisible: true,
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

      // Reset errors
      this.resetErrors();
      
      // Reset v-model
      var _that = this;
      Object.keys(this.form).forEach(function(key,index) {
        _that.form[key] = '';
      });

      // Reset event id
      this.form.event_id = this.$props.eventId

      // Reset form
      this.$el.querySelector('form').reset();

      // Reset selects to first element
      this.$el.querySelectorAll('select').forEach(e => e.selectedIndex = 0);

      // hide form
      this.isVisible = false;
    },

    resetErrors() {
      var _that = this;
      Object.keys(this.errors).forEach(function(key,index) {
        _that.form[key] = false;
      });
    }

  }
}
</script>

