import Vue from 'vue';
import Router from 'vue-router';

import Login from '../views/login';

Vue.use(Router);

const constantRouterMap = [
  {
    name: 'Login',
    path: '/login',
    component: Login,
  },
];

export default new Router({
  // mode: 'history',  // require service support
  routes: constantRouterMap,
});
