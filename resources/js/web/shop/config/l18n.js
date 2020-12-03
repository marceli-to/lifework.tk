export default {
  
  data() {
    return {
      de: {
        'basket': 'Warenkorb',
        'basket-route': 'warenkorb',
        'shop-more': 'Weiter Einkaufen',
        'checkout': 'Zur Kasse',
        'amounts-chf': 'Beträge in CHF',
        'excl-vat': 'exkl. Versandkosten + MwSt.',
        'vat': 'MwSt. 7.7%',
        'delivery-fee': 'Versandkosten',
        'order': 'Bestellung',
        'item-updated': 'Artikel aktualisiert',
        'item-removed': 'Artikel entfernt',
        'item-added': 'Artikel hinzugefügt',
        'confirm-payment-by-card': 'Zahlung per Kreditkarte bestätigen',
        'redirect-to-payment-gateway': 'Für die Zahlungsabwicklung wirst du auf die Seite des Zahlungsanbieters weitergeleitet.',
        'confirm': 'Bestätigen',
        'unit': 'Stk',
        'add-to-basket': 'Hinzufügen',
        'basket-empty-notice': 'Dein Warenkorb ist leer...',
        'at-least-one': 'Anzahl muss mind. 1 sein!',
      },
      en: {
        'basket': 'Basket',
        'basket-route': 'basket',
        'shop-more': 'Shop more',
        'checkout': 'Checkout',
        'amounts-chf': 'Amounts in CHF',
        'excl-vat': 'excl. shipping costs + VAT',
        'vat': 'VAT 7.7%',
        'delivery-fee': 'Delivery fee',
        'order': 'Order',
        'item-updated': 'Item updated',
        'item-removed': 'Item removed',
        'item-added': 'Item added',
        'confirm-payment-by-card': 'Confirm payment by card',
        'redirect-to-payment-gateway': 'For the payment processing you will be redirected to the page of the payment provider.',
        'confirm': 'Confirm',
        'unit': 'pcs.',
        'add-to-basket': 'Add',
        'basket-empty-notice': 'Your basket is empty...',
        'at-least-one': 'Quantity must be at least 1!',
      },
      lang: null,
    }
  },

  mounted() {
  },

  methods: {
    l18n(key) {
      return this[this.getLocale()][key];
    },

    getLocale() {
      let ll = this.$route.params.lang !== undefined ? this.$route.params.lang : document.documentElement.lang;
      return ll;
    },
  }
};