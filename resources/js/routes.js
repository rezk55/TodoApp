import Vue from "vue";
import VueRouter from 'vue-router';
import TodoComp from './components/Todo/TodoComp';

Vue.use(VueRouter);

const routes = [
    { path: '/', component: TodoComp }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes,
});

export default router;