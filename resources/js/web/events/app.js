require('@events/bootstrap');

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
require('@events/mixins/Filters');

// Vue-Axios defaults
Vue.axios.defaults.withCredentials = true;

// Vue-Notifications
import Notifications from 'vue-notification';
Vue.use(Notifications);

// Vue-Router
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// Loading indicator
import LoadingIndicator from "@events/components/ui/LoadingIndicator";
Vue.component('LoadingIndicator', LoadingIndicator);

// Store
// import store from '@events/config/store';

// Routes
// import routes from '@events/config/routes';
// const router = new VueRouter({ mode: 'history', routes: routes});

// App component
//import AppComponent from '@events/App.vue';
Vue.component('register-form', require('@events/views/RegisterForm.vue').default);

// Mount App
if (document.getElementById("app")) {
  const app = new Vue({
    mixins: [],
    components: { 
    },
    // router,
    // store
  }).$mount('#app');
}
