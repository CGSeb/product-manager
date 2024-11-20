<template>
    <nav class="navbar navbar-expand navbar-light fixed-top">
      <div class="container">
        <a href="/" class="navbar-brand">Home</a>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item" v-if="showLogin">
              <a href="/login" class="nav-link">Login</a>
            </li>
            <li class="nav-item" v-if="showLogout">
              <a href="/logout" class="nav-link">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
</template>

<script setup>
    import { ref, onMounted } from 'vue';

    const showLogin = ref(true)
    const showLogout = ref(false)
    const token = ref(null)

    onMounted(() => {
        token.value = localStorage.getItem('token') || null
        if (token.value != null) {
            showLogin.value = false
            showLogout.value = true
        }
    })
 
</script>