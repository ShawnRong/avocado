import Vue from 'vue';
import Router from 'vue-router';

import Layout from '../views/layout/Layout.vue';
import Login from '../views/login';
import Dashboard from '../views/dashboard';

Vue.use(Router);

export const constantRouterMap = [
  {
    name: 'Login',
    path: '/login',
    component: Login,
  },
  {
    path: '',
    component: Layout,
    redirect: 'dashboard',
    children: [
      {
        path: 'dashboard',
        component: Dashboard,
        name: 'Dashboard',
        meta: { title: 'dashboard', icon: 'tachometer-alt', noCache: true },
      },
    ],
  },
];

export default new Router({
  // mode: 'history',  // require service support
  routes: constantRouterMap,
});

export const asyncRouterMap = [
  {
    path: '/users',
    component: Layout,
    redirect: '/users/index',
    alwaysShow: true,
    meta: {
      title: 'users',
      icon: 'users',
      roles: ['admin'],
    },
    children: [
      {
        path: 'page',
        component: resolve => void require(['../views/user/page.vue'], resolve),
        name: 'User List',
        meta: { title: 'users_list' },
      },
    ],
  },
  {
    path: '/role',
    component: Layout,
    redirect: '/role/index',
    alwaysShow: true,
    meta: {
      title: 'role',
      icon: 'user-tag',
      roles: ['admin'],
    },
    children: [
      {
        path: 'page',
        component: resolve => void require(['../views/role/page.vue'], resolve),
        name: 'Role List',
        meta: { title: 'role_list' },
      },
    ],
  },
  {
    path: '/permission',
    component: Layout,
    redirect: '/permission/index',
    alwaysShow: true,
    meta: {
      title: 'permission',
      icon: 'user-lock',
      roles: ['admin'],
    },
    children: [
      {
        path: 'page',
        component: resolve => void require(['../views/permission/page.vue'], resolve),
        name: 'Permission List',
        meta: { title: 'permission_list' },
      },
    ],
  },
];
