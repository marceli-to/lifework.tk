<template>
  <div>
    <form class="add-product">
      <div>
        <input type="number" min="0" v-model="qty">
        <em>{{l18n('unit')}}</em>
      </div>
      <input type="submit" class="btn-primary" :value="l18n('add-to-basket')" @click.prevent="add()">
    </form>
  </div>
</template>
<script>
import l18n from "@shop/config/l18n";

export default {

  mixins: [l18n],

  data() {
    return {
      qty: 1,
      errors: {
        qty: false,
      },
    };
  },

  methods: {
    add() {
      this.$parent.add(this.qty);
    }
  }
}
</script>