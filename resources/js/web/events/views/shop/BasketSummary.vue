<template>
  <div>
    <notifications classes="notification" :position="'top left'" />
    <loading-indicator v-if="isLoading"></loading-indicator>
    <section class="shop" v-if="isFetched">
      <div>
        <div class="checkout" v-if="cart.items && Object.keys(cart.items).length > 0">
          <div class="checkout__basket">
            <div>
              <h1>{{l18n('order')}}</h1>
              <div v-if="cart.items" class="basket basket--summary">
                <article v-for="(i, index) in cart.items" :key="index">
                  <basket-item :item="i" :editable="false"></basket-item>
                </article>
                <div class="basket__additional-cost">
                  <div>{{l18n('delivery-fee')}}</div>
                  <div v-if="cart.shipping > 0">{{moneyFormat(cart.shipping)}}</div>
                  <div v-else>–</div>
                </div>
                <div v-if="cart.hasVat">
                  <div class="basket__additional-cost">
                    <div>{{l18n('vat')}}</div>
                    <div>{{moneyFormat(cart.vat)}}</div>
                  </div>
                  <div class="basket__total">
                    <div>Total</div>
                    <div>{{moneyFormat(cart.grandTotal)}}</div>
                  </div>
                </div>
                <div v-else>
                  <div class="basket__total">
                    <div>Total</div>
                    <div>{{moneyFormat(cart.shipping + cart.total)}}</div>
                  </div>
                </div>
                <div class="basket__info">
                  <div>{{l18n('amounts-chf')}}</div>
                </div>
              </div>
            </div>
          </div>
          <slot></slot>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import Shop from "@events/mixins/Shop";
import Helpers from "@events/mixins/Helpers";
import l18n from "@events/config/l18n";

export default {

  mixins: [Shop, Helpers, l18n],

  data() {
    return {
      
      // Product id
      id: this.$route.params.id,

      // Language
      lang: this.$route.params.lang,

      // Cart
      count: 0,
      cart: {
        items: null,
        total: 0,
        vat: 0,
        shipping: 0,
        grandTotal: 0,
      },

      // States
      isLoading: false,
      isFetched: false,
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.isLoading = true;
      this.axios.get(`/api/cart`).then(response => {
        this.count = response.data.count;
        this.cart = response.data.cart;
        this.isFetched = true;
        this.isLoading = false;
      });
    },
  }
}
</script>

<style>

</style>
