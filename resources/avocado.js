
import Vue from 'vue';

import App from './Admin.vue';
import router from './router';

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
