<template>
</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import router from '../router';

    const token = ref(null)

    onMounted(() => {
        token.value = localStorage.getItem('token') || null
        if (token.value != null) {
            localStorage.removeItem('token')
            localStorage.removeItem('email')
        }
        router.push('/login');
    })

</script>
