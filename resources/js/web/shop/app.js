require('@shop/bootstrap');

// Vue
window.Vue = require('vue');

// Axios Interceptors
require('vue-axios-interceptors');

// Axios, Vue-Axios
import VueAxios from 'vue-axios';
import axios from 'axios';
window.axios = require('axios');
Vue.use(VueAxios, axios);

// Filters
require('@shop/mixins/Filters');

// Vue-Axios defaults
Vue.axios.defaults.withCredentials = true;

// Vue-Notifications
import Notifications from 'vue-notification';
Vue.use(Notifications);

// Vue-Router
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// Loading indicator
import LoadingIndicator from "@shop/components/ui/LoadingIndicator";
Vue.component('LoadingIndicator', LoadingIndicator);

// Store
// import store from '@shop/config/store';

// Routes
import routes from '@shop/config/routes';
const router = new VueRouter({ mode: 'history', routes: routes});

// App component
// import AppComponent from '@shop/App.vue';

Vue.component('product-add', require('@shop/views/shop/ProductAdd.vue').default);
Vue.component('product-view', require('@shop/views/shop/Product.vue').default);
Vue.component('basket-preview', require('@shop/views/shop/BasketPreview.vue').default);
Vue.component('basket-view', require('@shop/views/shop/Basket.vue').default);
Vue.component('basket-summary-view', require('@shop/views/shop/BasketSummary.vue').default);
Vue.component('basket-item', require('@shop/views/shop/BasketItem.vue').default);
Vue.component('payment-view', require('@shop/views/shop/Payment.vue').default);

// Mount App
if (document.getElementById("shop")) {
  const app = new Vue({
    mixins: [],
    components: { 
    },
    router,
    // store
  }).$mount('#shop');
}
