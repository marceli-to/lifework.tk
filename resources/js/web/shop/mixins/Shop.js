export default {

  data() {
    return {
      counter: '.js-cart-counter',
    };
  },

  methods: {
    updateCounter(count) {
      let el = document.querySelector(this.counter);
      el.innerHTML = count;
      if (count > 0) {
        el.parentElement.style.display = 'block';
      }
      else {
        el.parentElement.style.display = 'none';
      }
    },
  }
};