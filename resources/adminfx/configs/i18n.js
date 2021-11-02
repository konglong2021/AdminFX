import { createI18n } from 'vue-i18n';
import messages from '@/locales';

const i18n = createI18n({
  locale: 'vi', // set locale
  fallbackLocale: 'en', // set fallback locale,
  messages,
});
export default (app) => {
  app.$i18n = i18n;
  app.use(i18n);
};
