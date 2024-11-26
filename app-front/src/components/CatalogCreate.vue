<template>
    <Nav/>
    
    <div class="container">
        <router-link to="/catalogs" class="nav-link">
            <button class="btn btn-primary">Catalog List</button>
        </router-link>
    </div>
    
    <div class="auth-wrapper">
      <div class="auth-inner">
        <form @submit.prevent="handleSubmit">
            <Error v-if="error" :error="error" />

            <h3>Create a catalog</h3>
            <div class="mb-3">
                <label>Name</label>
                <input type="text" v-model="name" class="form-control" placeholder="Name" />
            </div>

            <div class="mb-3">
                <label>Products</label>
                <multiselect 
                    v-model="products" 
                    :options="options" 
                    :multiple="true" 
                    :close-on-select="false"
                    label="name"
                    track-by="name"/>
            </div>

            <button class="btn btn-primary btn-block">Create</button>
        </form>
      </div>
    </div>
</template>

<script setup>
    import axios from 'axios';
    import { ref, onMounted } from 'vue';
    import router from '../router';
    import Nav from './Nav.vue';
    import Error from './Error.vue';
    import Multiselect from 'vue-multiselect';

    const name = ref('')
    const error = ref(null)
    const options = ref([])
    const products = ref([])

    onMounted(() => {
        axios.get('product?sortType=nameASC&limit=15').then( response => {
            options.value = response.data
        });
    })

    async function handleSubmit () {
        try {
            await axios.post('catalog', {
                name: name.value,
                products: products.value.map((product) => product.id)
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