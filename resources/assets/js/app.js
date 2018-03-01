import VueRouter from 'vue-router';
import router from './routes';

require('./bootstrap');

window.Vue = require('vue');
window.Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router
});
