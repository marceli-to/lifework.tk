export default {

  methods: {

    moneyFormat(amount) {
      if (amount > 0) {
        return amount.toFixed(2);
      }
      return 0;
    },

    shorten(str, length = 10, suffix = "...") {
      return str.substring(0, length) + suffix;
    },

    randomString() {
      return Math.random().toString(36).slice(2);
    },
  }
};