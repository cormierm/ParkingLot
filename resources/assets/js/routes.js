import VueRouter from 'vue-router';

let routes = [
    {
        path: '/',
        component: require('./views/Home')
    },
    {
        path: '/ticket',
        component: require('./views/Ticket')
    },
    {
        path: '/ticket/pay',
        component: require('./views/Pay')
    },
    {
        path: '/exit',
        component: require('./views/Exit')
    },
    {
        path: '/waitlist',
        component: require('./views/Waitlist')
    }
];

export default new VueRouter({
    routes,
    linkActiveClass:  'active'
});