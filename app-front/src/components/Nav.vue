<template>
    <nav class="navbar navbar-expand navbar-light fixed-top">
      <div class="container">
        <router-link to="/" class="navbar-brand">Product Manager</router-link>
        <div class="collapse navbar-collapse">
          <div>{{ email }}</div>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item" v-if="showLogin">
              <router-link to="/login" class="nav-link">Login</router-link>
            </li>
            <li class="nav-item" v-if="showLogout">
              <a href="javascript:void(0)" @click="logout" class="nav-link">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
</template>

<script setup>
    import { ref, onMounted, computed } from 'vue';
    import router from '../router';
    import store from '../vuex';

    const showLogin = ref(true)
    const showLogout = ref(false)
    const token = ref(null)
    const email = computed(() => store.getters.email)

    onMounted(() => {
        token.value = localStorage.getItem('token') || null
        if (token.value != null) {
            showLogin.value = false
            showLogout.value = true
        }
    })

    function logout() {
      localStorage.removeItem('token')
      localStorage.removeItem('email')
      store.dispatch('email', null)
      router.push('/login');
    }
 
</script>