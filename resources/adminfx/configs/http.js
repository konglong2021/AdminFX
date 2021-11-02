import VueAxios from 'vue-axios';
import api from '@/api';

export default (app) => {
  app.use(VueAxios, api);
  /*
  app.$http = axios;
  app.axios = axios;
  app.config.globalProperties.axios = axios;
  app.config.globalProperties.$http = axios;
  */
};
