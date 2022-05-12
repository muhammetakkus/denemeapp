/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue').default;

/**/
function loggedIn() {
  return localStorage.getItem('token');
}
function isAdmin() {
  return localStorage.getItem('admin_token');
}


import { createApp } from 'vue'

import App from './App.vue'

import router from './router'
/**/
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!loggedIn()) {
            next({
              path: '/login',
              // query: { redirect: to.fullPath }
            })
        } else {
            next()
        }
    } else if(to.matched.some(record => record.meta.guest)) {
        if (loggedIn()) {
            next({
              path: '/dashboard',
            })
        } else {
            next()
        }
    } else if(to.matched.some(record => record.meta.requiresAdminAuth)) {
        if (!isAdmin()) {
            next({
              path: '/admin/login',
            })
        } else {
            next()
        }
    } else if(to.matched.some(record => record.meta.admin_login)) {
        if (isAdmin()) {
            next({
              path: '/admin/dashboard',
            })
        } else {
            next()
        }
    } else {
        next() // make sure to always call next()!
    }
    window.scrollTo(0, 0)
})

/**/
import store from "./store"

/**/
import Toast, { POSITION } from "vue-toastification";
import "vue-toastification/dist/index.css";
const options = {
    timeout: 2500,
    draggable: true,
    draggablePercent: 0.6,
    hideProgressBar: true,
    maxToasts: 2,
    position: POSITION.TOP_CENTER
};

// import Pagination from 'v-pagination-3';
/**/
createApp(App).use(store).use(router).use(Toast, options).mount('#app')
// createApp(App).component('pagination', Pagination).use(store).use(router).use(Toast, options).mount('#app')
// createApp(App).use(store).use(router).mount('#app')
