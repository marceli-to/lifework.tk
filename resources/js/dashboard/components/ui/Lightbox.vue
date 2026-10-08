<template>
  <!-- Moved to <body> on mount: escapes forms and overflow/stacking of the page -->
  <div class="lightbox-portal">
    <transition name="lightbox">
      <div class="lightbox" v-if="open" @mousedown.self="close()">
        <div :class="['lightbox__dialog', `is-${size}`]" role="dialog" aria-modal="true" :aria-label="title">
          <header class="lightbox__header">
            <h2 v-if="title">{{ title }}</h2>
            <a href="javascript:;" class="lightbox__close" title="Schliessen" @click.prevent="close()">
              <x-icon size="22"></x-icon>
            </a>
          </header>
          <div class="lightbox__body">
            <slot></slot>
          </div>
          <footer class="lightbox__footer" v-if="$slots.footer">
            <slot name="footer"></slot>
          </footer>
        </div>
      </div>
    </transition>
  </div>
</template>
<script>
import { XIcon } from 'vue-feather-icons';

export default {
  components: {
    XIcon,
  },

  props: {
    open: { type: Boolean, default: false },
    title: { type: String, default: '' },
    size: { type: String, default: 'small' },
  },

  watch: {
    open(open) {
      document.documentElement.classList.toggle('has-overlay', open);
      if (open) {
        document.addEventListener('keydown', this.onKeydown);
      } else {
        document.removeEventListener('keydown', this.onKeydown);
      }
    },
  },

  mounted() {
    document.body.appendChild(this.$el);
  },

  beforeDestroy() {
    if (this.open) {
      this.$emit('close');
      document.documentElement.classList.remove('has-overlay');
    }
    document.removeEventListener('keydown', this.onKeydown);
    if (this.$el.parentNode) {
      this.$el.parentNode.removeChild(this.$el);
    }
  },

  methods: {
    close() {
      this.$emit('close');
    },

    onKeydown(event) {
      if (event.key === 'Escape') {
        event.preventDefault();
        this.close();
      }
    },
  },
};
</script>
