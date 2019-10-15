require('./bootstrap');

import Vue from 'vue';

import Auth from './auth.js';


const auth=new Auth(window.user);
Vue.prototype.$auth=auth
window.auth=auth
//vue router


import VueRouter from 'vue-router';
Vue.use(VueRouter);

import {routes} from './routes';

// Support vuex
import Vuex from 'vuex'
Vue.use(Vuex)
import storeData from "./store/index"
const store = new Vuex.Store(
    storeData
)

Vue.component('admin-main', require('./components/admin/AdminMaster.vue').default);

// V-form
import { Form, HasError, AlertError } from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
window.Form = Form;

// Sweet alert 2
import Swal from 'sweetalert2'
import { Script } from 'vm';
window.swal = Swal;
const toast = swal.mixin({
    toast: true,
    position:'top-right',
    showConfirmButton:false,
    timer: 3000
});

const confirm=swal.mixin({
    title:'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    position:'center',
    showCancelButton: true,
    showConfirmButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
    });
window.confirm=confirm
window.toast = toast
const router = new VueRouter({
    routes,
    mode:'hash',

})

import NProgress from 'nprogress'
Vue.use(NProgress)
router.beforeResolve((to,from,next)=>{
    NProgress.start();
    next()
})
window.nprogress=NProgress;
router.afterEach((to,from)=>{
    NProgress.done()
})

const app = new Vue({
    el: '#app',
    router,
    store
});
