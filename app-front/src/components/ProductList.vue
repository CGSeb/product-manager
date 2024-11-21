<template>
    <Nav />
    <div class="container">
        <h2>Product list</h2>

        <div class="col-12" style="margin-bottom: 10px;margin-top: 30px;">
            <div class="row">
                <div class="col-2">
                    <input class="form-control" v-model="search" type="text" placeholder="Search...">
                </div>
                <div class="col-2">
                    <select class="form-select" v-model="sortType">
                        <option value="nameASC" selected>Name ASC</option>
                        <option value="nameDESC">Name DESC</option>
                        <option value="priceASC">Price ASC</option>
                        <option value="priceDESC">Price DESC</option>
                    </select>
                </div>
                <div class="col-2">
                    <select class="form-select" v-model="limit">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20" selected>20</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products">
                    <td>{{ product.name }}</td>
                    <td>{{ product.price }} €</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
    import axios from 'axios';
    import { onMounted, ref, watch } from 'vue';
    import Nav from './Nav.vue';

    const products = ref([]);
    const search = ref();
    const sortType = ref('nameASC');
    const limit = ref(20);

    function getProductList()
    {
        var queryParams = '?sortType=' + sortType.value + '&limit=' + limit.value;
        if (search.value != null) {
            queryParams += '&q=' + search.value;
        }

        axios.get('product'+queryParams).then( response => {
            products.value = response.data
        });
    }

    onMounted(() => {
        getProductList()
    })

    watch(search, async (newSearch) => getProductList());
    watch(sortType, async (newSortType) => getProductList());
    watch(limit, async (newLimit) => getProductList());

</script>