import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

import App from './Admin.vue';
import router from './router';
import store from './store';

import './styles/index.scss';

import i18n from './lang';
import './permission'; // Load Perission
import '@fortawesome/fontawesome-free/js/all';

Vue.use(ElementUI, {
  i18n: (key, value) => i18n.t(key, value),
});

const app = new Vue({
  el: '#app',
  router,
  store,
  i18n,
  render: h => h(App),
});
