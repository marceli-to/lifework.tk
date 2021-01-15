<template>
  <div>
    <header>
      <h2>{{l18n('basket')}}</h2>
      <a href="" @click.prevent="hide()">
        <x-icon size="24"></x-icon>
      </a>
    </header>
    <div v-if="items">
      <article v-for="(i, index) in items" :key="index">
        <basket-item :item="i"></basket-item>
      </article>
      <div class="basket__total">
        <div>Total<sup>*</sup></div>
        <div>{{moneyFormat(total)}}</div>
      </div>
      <div class="basket__info">
        <div><sup>*</sup>{{l18n('excl-vat')}}</div>
        <div>{{l18n('amounts-chf')}}</div>
      </div>
      <footer>
        <a :href="'/' + lang + '/shop/'">{{l18n('shop-more')}}</a>
        <a :href="'/' + lang + '/shop/' + l18n('basket-route')" class="btn-primary">{{l18n('checkout')}}</a>
      </footer>
    </div>
  </div>
</template>
<script>
import { XIcon, TrashIcon } from 'vue-feather-icons';
import Helpers from "@events/mixins/Helpers";
import l18n from "@events/config/l18n";

export default {

  mixins: [Helpers, l18n],

  data() {
    return {
      lang: this.$route.params.lang,
    };
  },

  components: {
    XIcon, TrashIcon
  },

  props: {
    items: null,
    total: {
      type: Number,
      default: 0
    }
  },

  methods: {
    remove(id) {
      this.$parent.remove(id);
    },

    update(id, qty) {
      this.$parent.update(id, qty);
    },

    hide() {
      this.$parent.hide();
    }
  }
}
</script>
