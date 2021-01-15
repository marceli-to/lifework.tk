<template>
  <div>
    <notifications classes="notification" :position="'top left'" />
    <loading-indicator v-if="isLoading"></loading-indicator>
    <section class="shop">
      <div>
        <div class="checkout">
          <div class="checkout__card-payment">
            <h2>{{l18n('confirm-payment-by-card')}}</h2>
            <p>{{l18n('redirect-to-payment-gateway')}}</p>
            <button type="submit" class="btn-primary" @click.prevent="submitPayment()">{{l18n('confirm')}}</button>
          </div>   
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import l18n from "@events/config/l18n";

export default {
  
  mixins: [l18n],

  data() {
    return {
      isLoading: false,
      stripe: null,
      csrfToken: null,
    };
  },
  
  created() {
    this.stripe = Stripe(document.querySelector('meta[name="stripe-public-key"]').getAttribute("content"));
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
  },

  methods: {

    submitPayment() {
      let _that = this;
      this.isLoading = true;
      fetch(`/api/payment/card`, {
        headers: {
          "X-CSRF-TOKEN": _that.csrfToken
        },
        method: "POST",
      })
      .then(function (response) {
        return response.json();
      })
      .then(function (session) {
        return _that.stripe.redirectToCheckout({ sessionId: session.id });
      })
      .then(function (result) {
        _that.isLoading = false;
        if (result.error) {
          _that.$notify({ type: "error", text: result.error.message });
        }
      })
      .catch(function (error) {
        _that.isLoading = false;
        _that.$notify({ type: "error", text: error });
      });
    }
  }
}
</script>