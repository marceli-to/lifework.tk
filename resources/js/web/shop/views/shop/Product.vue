<template>
  <div>
    <notifications classes="notification" :position="'top left'" />
    <loading-indicator v-if="isLoading"></loading-indicator>
    <slot></slot>
    <basket-preview :class="[hasBasket ? 'is-visible' : '', 'basket-preview']" :items="cart.items" :total="cart.total" />
  </div>
</template>
<script>

// Mixins
import Errors from "@shop/mixins/Errors";
import Shop from "@shop/mixins/Shop";
import l18n from "@shop/config/l18n";

export default {
  
  mixins: [Shop, l18n, Errors],

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
      hasBasket: false,
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/cart`).then(response => {
        this.count = response.data.count;
        this.cart = response.data.cart;
        this.isFetched = true;
      });
    },

    add(qty) {
      if (qty < 1) {
        this.$notify({ type: "warn", text: this.l18n('at-least-one') });
        return;
      }
      this.isLoading = true;
      this.axios.post('/api/cart', {id: this.id, qty: qty}).then(response => {
        this.count = response.data.count;
        this.updateCounter(this.count);
        this.cart = response.data.cart;
        this.isLoading = false;
        this.hasBasket = true;
        window.scrollTo(0,0);
        if (response.data.status == 422) {
          this.$notify({ type: "warn", text: response.data.message});
        }
        else {
          this.$notify({ type: "success", text: this.l18n('item-added') });
        }
      });
    },

    update(id, qty) {
      if (qty < 1) {
        this.$notify({ type: "warn", text: this.l18n('at-least-one') });
        return;
      }
      this.isLoading = true;
      this.axios.put('/api/cart', {id: id, qty: qty}).then(response => {
        this.count = response.data.count;
        this.updateCounter(this.count);
        this.cart = response.data.cart;
        this.cart = this.count > 0 ? response.data.cart : {};
        if (this.count == 0) {
          this.hasBasket = false;
        }
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
        if (this.count == 0) {
          this.hasBasket = false;
        }
        this.isLoading = false;
        this.$notify({ type: "success", text: this.l18n('item-removed') });
      });      
    },

    show() {
      this.hasBasket = true;
    },

    hide() {
      this.hasBasket = false;
    }
  }
}
</script>

