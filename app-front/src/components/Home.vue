<template>
    <Nav/>
    <h1>Home</h1>
    <div class="container">
        <router-link to="/product-create" class="nav-link">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    Product
                </div>
            </div>
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