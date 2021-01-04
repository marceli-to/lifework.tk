import ErrorForbidden from '@/views/errors/Forbidden.vue';
import ErrorNotFound from '@/views/errors/NotFound.vue';

// Welcome
import Home from '@/views/home/Index.vue';

// Post
import PostIndex from '@/views/post/Index.vue';
import PostCreate from '@/views/post/Create.vue';
import PostEdit from '@/views/post/Edit.vue';


const routes = [

  // Home
  {
    name: 'home',
    path: '/administration',
    component: Home,
  },

  // Post
  {
    name: 'posts',
    path: '/administration/post',
    component: PostIndex,
  },
  {
    name: 'post-create',
    path: '/administration/post/create',
    component: PostCreate,
  },
  {
    name: 'post-edit',
    path: '/administration/post/edit/:id',
    component: PostEdit,
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