<template>
    <Nav/>
    <h1>Home</h1>
    <div class="container">
        <router-link to="/product-create" class="nav-link">
            <button class="btn btn-primary">Product</button>
        </router-link>
        <router-link to="/products" class="nav-link">
            <button class="btn btn-primary">Product List</button>
        </router-link>
    </div>
</template>

<script setup>
    import { onMounted } from 'vue';
    import router from '../router';
    import Nav from './Nav.vue';

    onMounted(() => {
        const token = localStorage.getItem('token') || null

        if (token == null) {
            router.push('/login');
        }
    })
</script>