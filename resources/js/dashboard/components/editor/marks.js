import { Mark } from '@tiptap/core';

/**
 * "Worttrennung deaktivieren": keeps words on one line. Stored as the inline
 * style TinyMCE's style format wrote, so the website needs no extra CSS.
 */
export const NoWordBreak = Mark.create({
  name: 'noWordBreak',

  parseHTML() {
    return [{
      tag: 'span[style]',
      getAttrs: element => /white-space:\s*nowrap/i.test(element.getAttribute('style')) && null,
    }];
  },

  renderHTML() {
    return ['span', { style: 'white-space: nowrap;' }, 0];
  },

  addCommands() {
    return {
      toggleNoWordBreak: () => ({ commands }) => commands.toggleMark(this.name),
    };
  },
});
