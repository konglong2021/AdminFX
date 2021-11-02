import { createApp } from 'vue';
import 'bootstrap';
import '@/styles/app.scss';
import App from './App.vue';
import store from './store';
import layout from '@/layouts';
import configs from '@/configs';

const app = createApp(App);
app.use(store);
app.use(configs);
app.use(layout);
app.mount('#app');
