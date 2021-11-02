import { createRouter, createWebHashHistory } from 'vue-router';
import routes from '@/router/index';
import api from '@/api/auth';

export const router = createRouter({
  history: createWebHashHistory(),
  /*
  history: createWebHistory('/'),
  */
  routes,
});
export const publicPages = ['/login', '/register'];
router.beforeEach((to, from, next) => {
  const authRequired = !publicPages.includes(to.path);
  const loggedIn = api.checkAuth();
  if (authRequired && !loggedIn) {
    return next('/login');
  }
  if ((loggedIn && to.path === '/login')) {
    return next('/');
  }
  return next();
});
export default (app) => {
  app.router = router;
  router.app = app;
  app.use(router);
};
