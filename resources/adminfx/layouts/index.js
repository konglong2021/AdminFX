import DefaultLayout from './Default.vue';
import FullLayout from './Full.vue';

export default function (app) {
  app.component('default-layout', DefaultLayout);
  app.component('full-layout', FullLayout);
}
