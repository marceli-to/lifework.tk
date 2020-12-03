import ErrorForbidden from '@shop/views/errors/Forbidden.vue';
import ErrorNotFound from '@shop/views/errors/NotFound.vue';

const routes = [

  // Shop article detail page
  {
    name: 'product-detail',
    path: '/:lang/shop/:slug/:id',
    //component: Product,
  },

  {
    name: 'product-detail',
    path: '/:lang/shop/:slug/:id',
    //component: Product,
  },

  // Authorization
  {
    name: 'forbidden',
    path: '/forbidden',
    component: ErrorForbidden,
  },
  {
    name: 'not-found',
    path: '/not-found',
    component: ErrorNotFound,
  }
];

export default routes