import Home from './components/Home.vue'
import Login from './components/Login.vue'
import ProductCreate from './components/ProductCreate.vue'
import ProductList from './components/ProductList.vue'
import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {path: '/', component: Home},
    {path: '/login', component: Login},
    {path: '/product-create', component: ProductCreate},
    {path: '/products', component: ProductList}
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;