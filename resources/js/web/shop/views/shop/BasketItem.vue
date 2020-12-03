<template>
<div class="basket-item">
  <div>
    <div v-if="editable" >
      <input type="number" min="0" :value="item.qty" @blur.prevent="update(item.id,$event)">
    </div>
    <div v-else>
      {{item.qty}}&nbsp;x&nbsp;
    </div>
    <div class="basket-item__description">
      {{item.title[getLocale()]}} – <strong>{{item.subtitle[getLocale()]}}</strong>
    </div> 
  </div>
  <div class="basket-item__total">
    {{moneyFormat(item.totalPrice)}}
  </div>
  <div class="basket-item__remove" v-if="editable">
    <a href="javascript:;" @click.prevent="remove(item.id)">
      <trash-icon size="18" class="icon-shop"></trash-icon>
    </a>
  </div>
</div>
</template>
<script>
import { TrashIcon } from 'vue-feather-icons';
import Helpers from "@shop/mixins/Helpers";
import l18n from "@shop/config/l18n";

export default {

  mixins: [Helpers, l18n],

  components: {
    TrashIcon
  },

  props: {
    item: null,
    editable: {
      type: Boolean,
      default: true
    }
  },

  data() {
    return {
      errors: {
        qty: false,
      },
    }
  },

  methods: {
    
    update(id, event) {
      let value = event.target.value;
      this.$parent.update(id, value);
    },

    remove(id) {
      this.$parent.remove(id);
    }
  }
}
</script>
