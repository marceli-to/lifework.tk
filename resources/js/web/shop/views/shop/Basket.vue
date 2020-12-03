<template>
  <div>
    <notifications classes="notification" :position="'top left'" />
    <loading-indicator v-if="isLoading"></loading-indicator>
    <section class="shop" v-if="isFetched">
      <div>
        <div class="checkout" v-if="cart.items && Object.keys(cart.items).length > 0">
          <div class="checkout__basket">
            <div>
              <h1>{{l18n('basket')}}</h1>
              <div v-if="cart.items" class="basket">
                <article v-for="(i, index) in cart.items" :key="index">
                  <basket-item :item="i" :editable="true"></basket-item>
                </article>
                <div class="basket__total">
                  <div>Total<sup>*</sup></div>
                  <div>{{moneyFormat(cart.total)}}</div>
                </div>
                <div class="basket__info">
                  <div><sup>*</sup>{{l18n('excl-vat')}}</div>
                  <div>{{l18n('amounts-chf')}}</div>
                </div>
              </div>
            </div>
          </div>
          <slot></slot>
        </div>
        <div v-else>
          <h1>{{l18n('basket')}}</h1>
          <p>{{l18n('basket-empty-notice')}}</p>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import { XIcon, TrashIcon } from 'vue-feather-icons';
import Shop from "@shop/mixins/Shop";
import Helpers from "@shop/mixins/Helpers";
import l18n from "@shop/config/l18n";

export default {

  components: {
    XIcon, TrashIcon
  },

  mixins: [Shop, Helpers, l18n],

  data() {
    return {
      
      // Product id
      id: this.$route.params.id,

      // Cart
      count: 0,
      cart: {
        items: null,
        total: 0
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

    update(id, qty) {
      this.isLoading = true;
      this.axios.put('/api/cart', {id: id, qty: qty}).then(response => {
        this.cart = response.data.cart;
        this.cart = this.count > 0 ? response.data.cart : {};
        this.isLoading = false;
        if (response.data.status == 422) {
          this.$notify({ type: "warn", text: response.data.message});
        }
        else {
          this.$notify({ type: "success", text: this.l18n('item-updated') });
        }
      });
    },

    remove(id) {
      this.isLoading = true;
      this.axios.delete(`/api/cart/${id}`).then(response => {
        this.count = response.data.count;
        this.updateCounter(this.count);
        this.cart = this.count > 0 ? response.data.cart : {};
        this.isLoading = false;
        this.$notify({ type: "success", text: this.l18n('item-removed') });
      });      
    },
  }
}
</script>
