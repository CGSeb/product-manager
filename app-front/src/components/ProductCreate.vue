<template>
    <Nav/>
    <div class="container">
        <router-link to="/products" class="nav-link">
            <button class="btn btn-primary">Product List</button>
        </router-link>
    </div>

    <div class="auth-wrapper">
      <div class="auth-inner">
        <form @submit.prevent="handleSubmit">
            <Error v-if="error" :error="error" />

            <h3>Create a product</h3>
            <div class="mb-3">
                <label>Name</label>
                <input type="text" v-model="name" class="form-control" placeholder="Name" />
            </div>

            <div class="mb-3">
                <label>Price</label>
                <input type="number" step=any v-model="price" class="form-control" placeholder="0" />
            </div>

            <button class="btn btn-primary btn-block">Create</button>
        </form>
      </div>
    </div>
</template>

<script setup>
    import axios from 'axios';
    import { ref } from 'vue';
    import router from '../router';
    import Nav from './Nav.vue';
    import Error from './Error.vue';
    
    const name = ref('')
    const price = ref(0)
    const error = ref(null)

    async function handleSubmit () {
        try {
            await axios.post('product', {
                name: name.value,
                price: price.value
            })

            router.push('/');
        } catch (e) {
            const data = e.response.data
            if (e.status == 422) {
                var messages = []
                data.violations.forEach(element => {
                    messages.push('- ' + element.propertyPath + ': ' + element.title)
                });

                error.value = messages.join('\r\n')
            }
        }
    }

</script>