<template>
    <Nav/>
    <h1>Home</h1>
</template>

<script setup>
    import { onMounted } from 'vue';
    import router from '../router';
    import Nav from './Nav.vue'

    onMounted(() => {
        const token = localStorage.getItem('token') || null

        if (token == null) {
            router.push('/login');
        }
    })
</script>