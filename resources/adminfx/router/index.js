import Home from '@/views/Home.vue';
import Login from '@/views/Auth/Login.vue';
import Register from '@/views/Auth/Register.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/login',
    name: 'Login',
    meta: {
      layout: 'full',
    },
    component: Login,
  },
  {
    path: '/register',
    name: 'Register',
    meta: {
      layout: 'full',
    },
    component: Register,
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('@/views/About.vue'),
  },
  {
    path: '/user',
    name: 'User',
    component: () => import('@/views/user/index.vue'),
    meta: {
      can: 'user.index',
    },
  },
  {
    path: '/role',
    name: 'Role',
    component: () => import('@/views/role/index.vue'),
    meta: {
      can: 'role.index',
    },
  },
  {
    path: '/permission',
    name: 'Permission',
    component: () => import('@/views/permission/index.vue'),
    meta: {
      can: 'permission.index',
    },
  },
];
export default routes;
