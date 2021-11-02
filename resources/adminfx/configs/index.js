import i18n from '@/configs/i18n';
import routerConfig from '@/configs/router';
import http from '@/configs/http';

export default (app) => {
  app.use(i18n);
  app.use(routerConfig);
  app.use(http);
};
