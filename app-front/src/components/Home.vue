<template>
    <Nav/>
    <h1>Product Manager</h1>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <router-link to="/product-create" class="nav-link">
                    <button class="btn btn-primary">Create a Product</button>
                </router-link>
            </div>
            <div class="col-4">
                <router-link to="/products" class="nav-link">
                    <button class="btn btn-primary">Product List</button>
                </router-link>
            </div>
            <div class="col-4">
                <router-link to="/catalog-create" class="nav-link">
                    <button class="btn btn-primary">Create a Catalog</button>
                </router-link>
            </div>
        </div>
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