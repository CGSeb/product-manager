<template>
    <Nav />

    <div class="auth-wrapper">
      <div class="auth-inner">
        <form @submit.prevent="handleSubmit">
            <h3>Login</h3>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" v-model="email" class="form-control" placeholder="Email" />
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" v-model="password" class="form-control" placeholder="Password" />
            </div>

            <button class="btn btn-primary btn-block">Login</button>
        </form>
      </div>
    </div>
</template>

<script setup>
    import axios from 'axios';
    import { onMounted, ref } from 'vue';
    import router from '../router';
    import Nav from './Nav.vue'

    const email = ref('')
    const password = ref('')
    const token = ref('')

    onMounted(() => {
        token.value = localStorage.getItem('token') || null
        if (token.value != null) {
            router.push('/');
        }
    })

    async function handleSubmit () {
        if (email.value == '' || password.value == '') {
            return
        }

        const response = await axios.post('login_check', {
            email: email.value,
            password: password.value
        })

        localStorage.setItem('token', response.data.token);
        localStorage.setItem('email', email.value);

        router.push('/');
    }
</script>
