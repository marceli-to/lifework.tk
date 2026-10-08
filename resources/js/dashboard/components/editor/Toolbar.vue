<template>
  <div class="editor__toolbar">
    <button
      v-for="action in actions"
      :key="action.title"
      type="button"
      :class="['editor__button', { 'is-active': action.active && action.active() }]"
      :disabled="action.disabled && action.disabled()"
      :title="action.title"
      @click="action.run()"
    >
      <icon :name="action.icon" />
    </button>
  </div>
</template>
<script>
import Icon from './Icon.vue';

export default {
  components: {
    Icon,
  },

  props: {
    editor: { type: Object, required: true },
  },

  computed: {
    actions() {
      const editor = this.editor;
      const chain = () => editor.chain().focus();
      const heading = level => ({
        title: `Überschrift ${level}`,
        icon: `h${level}`,
        active: () => editor.isActive('heading', { level }),
        run: () => chain().toggleHeading({ level }).run(),
      });

      return [
        {
          title: 'Rückgängig',
          icon: 'undo',
          disabled: () => !editor.can().undo(),
          run: () => chain().undo().run(),
        },
        {
          title: 'Wiederholen',
          icon: 'redo',
          disabled: () => !editor.can().redo(),
          run: () => chain().redo().run(),
        },
        heading(1),
        heading(2),
        heading(3),
        {
          title: 'Fett',
          icon: 'bold',
          active: () => editor.isActive('bold'),
          run: () => chain().toggleBold().run(),
        },
        {
          title: 'Aufzählung',
          icon: 'list',
          active: () => editor.isActive('bulletList'),
          run: () => chain().toggleBulletList().run(),
        },
        {
          title: 'Hochgestellt',
          icon: 'superscript',
          active: () => editor.isActive('superscript'),
          run: () => chain().toggleSuperscript().run(),
        },
        {
          title: 'Worttrennung deaktivieren',
          icon: 'nowrap',
          active: () => editor.isActive('noWordBreak'),
          run: () => chain().toggleNoWordBreak().run(),
        },
        {
          title: 'Link',
          icon: 'link',
          active: () => editor.isActive('link'),
          run: () => this.$emit('link'),
        },
        {
          title: 'Formatierung entfernen',
          icon: 'eraser',
          run: () => chain().unsetAllMarks().clearNodes().run(),
        },
      ];
    },
  },
};
</script>
