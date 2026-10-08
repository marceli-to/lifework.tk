<template>
  <!-- Inline panel, not a <form>: the editor already sits inside the page's form -->
  <div class="editor-dialog" v-if="isOpen" @keydown.enter.prevent="apply()" @keydown.esc.prevent="close()">
    <div class="editor-dialog__row">
      <label>Typ</label>
      <div class="select-wrapper is-sm">
        <select v-model="link.type">
          <option v-for="(label, type) in types" :key="type" :value="type">{{ label }}</option>
        </select>
      </div>
    </div>

    <div class="editor-dialog__row" v-if="link.type === 'url'">
      <label>URL</label>
      <div class="editor-dialog__url">
        <div class="select-wrapper is-sm">
          <select v-model="link.protocol">
            <option value="https://">https://</option>
            <option value="http://">http://</option>
          </select>
        </div>
        <input type="text" ref="value" v-model="link.value" placeholder="www.example.com">
      </div>
    </div>

    <div class="editor-dialog__row" v-if="link.type === 'email'">
      <label>E-Mail-Adresse</label>
      <input type="text" ref="value" v-model="link.value" placeholder="name@lifework.ch">
    </div>

    <div class="editor-dialog__row" v-if="link.type === 'tel'">
      <label>Telefonnummer</label>
      <input type="text" ref="value" v-model="link.value" placeholder="+41 44 000 00 00">
    </div>

    <div class="editor-dialog__row">
      <label>Titel (optional)</label>
      <input type="text" v-model="link.title">
    </div>

    <div class="editor-dialog__row" v-if="link.type === 'url'">
      <label class="editor-dialog__checkbox">
        <input type="checkbox" v-model="link.blank">
        <span>In neuem Fenster öffnen</span>
      </label>
    </div>

    <div class="editor-dialog__actions">
      <button type="button" class="editor-dialog__apply" @click="apply()">Übernehmen</button>
      <a href="javascript:;" v-if="isEditing" @click.prevent="remove()">Entfernen</a>
      <a href="javascript:;" @click.prevent="close()">Abbrechen</a>
    </div>
  </div>
</template>
<script>
const types = { url: 'URL', email: 'E-Mail', tel: 'Telefon' };

const empty = () => ({ type: 'url', protocol: 'https://', value: '', title: '', blank: false });

// Fill the form from an existing link's href. Relative links (/kontakt)
// stay as they are: the protocol select is skipped for them.
function parse(href) {
  if (href.startsWith('mailto:')) {
    return { type: 'email', value: href.slice(7) };
  }
  if (href.startsWith('tel:')) {
    return { type: 'tel', value: href.slice(4) };
  }
  const match = href.match(/^(https?:\/\/)(.*)$/);
  return match
    ? { type: 'url', protocol: match[1], value: match[2] }
    : { type: 'url', value: href };
}

export default {
  props: {
    editor: { type: Object, required: true },
  },

  data() {
    return {
      types,
      isOpen: false,
      isEditing: false,
      link: empty(),
    };
  },

  methods: {
    open() {
      const attributes = this.editor.getAttributes('link');
      this.isEditing = !!attributes.href;
      this.link = empty();

      if (attributes.href) {
        this.link = Object.assign(empty(), parse(attributes.href), {
          title: attributes.title || '',
          blank: attributes.target === '_blank',
        });
      }

      this.isOpen = true;
      this.$nextTick(() => this.$refs.value && this.$refs.value.focus());
    },

    href() {
      const value = this.link.value.trim();
      if (!value) {
        return null;
      }
      switch (this.link.type) {
        case 'email': return `mailto:${value}`;
        case 'tel': return `tel:${value.replace(/\s+/g, '')}`;
        default: return /^(https?:\/\/|\/|#|\.\.?\/)/.test(value) ? value : this.link.protocol + value;
      }
    },

    apply() {
      const url = this.href();
      if (!url) {
        return;
      }
      const blank = this.link.blank && this.link.type === 'url';
      this.editor.chain().focus().extendMarkRange('link').setLink({
        href: url,
        title: this.link.title.trim() || null,
        target: blank ? '_blank' : null,
        rel: blank ? 'noopener' : null,
      }).run();
      this.isOpen = false;
    },

    remove() {
      this.editor.chain().focus().extendMarkRange('link').unsetLink().run();
      this.isOpen = false;
    },

    close() {
      this.isOpen = false;
      if (!this.editor.isDestroyed) {
        this.editor.commands.focus();
      }
    },
  },
};
</script>
