<template>
  <div class="editor">
    <toolbar v-if="editor" :editor="editor" @link="$refs.linkDialog.open()" />
    <link-dialog v-if="editor" ref="linkDialog" :editor="editor" />
    <editor-content :editor="editor" class="editor__content" />
  </div>
</template>
<script>
import { Editor, EditorContent } from '@tiptap/vue-2';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import Superscript from '@tiptap/extension-superscript';
import Toolbar from './Toolbar.vue';
import LinkDialog from './LinkDialog.vue';
import { serialize } from './serialize';
import { NoWordBreak } from './marks';

// Replaces TinyMCE (and its config/tiny.js), with the same toolbar: undo/redo,
// bold, bullet list, link, superscript, remove formatting and the style formats
// (Worttrennung deaktivieren, Überschrift 1–3). The source code view is gone.
// Ported from the cra.ch editor (Vue 3).

export default {
  components: {
    EditorContent,
    Toolbar,
    LinkDialog,
  },

  props: {
    value: { type: String, default: '' },
  },

  data() {
    return {
      editor: null,
    };
  },

  watch: {
    // Content set from outside (e.g. after loading the record)
    value(value) {
      if (!this.editor || value === serialize(this.editor)) {
        return;
      }
      this.editor.commands.setContent(value || '', { emitUpdate: false });
    },
  },

  mounted() {
    this.editor = new Editor({
      content: this.value || '',
      extensions: [
        StarterKit.configure({
          heading: { levels: [1, 2, 3] },
          blockquote: false,
          code: false,
          codeBlock: false,
          horizontalRule: false,
          orderedList: false,
          italic: false,
          strike: false,
          underline: false,
          link: false,
        }),
        Link.configure({
          openOnClick: false,
          autolink: false,
          HTMLAttributes: { target: null, rel: null },
        }),
        Superscript,
        NoWordBreak,
      ],
      // TinyMCE pasted as plain text; keep pasted Word/web formatting out
      editorProps: {
        transformPastedHTML: html => html.replace(/ style="[^"]*"/gi, '').replace(/ class="[^"]*"/gi, ''),
      },
      onUpdate: ({ editor }) => {
        this.$emit('input', serialize(editor));
      },
    });
  },

  beforeDestroy() {
    if (this.editor) {
      this.editor.destroy();
    }
  },
};
</script>
