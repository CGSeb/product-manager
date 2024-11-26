<template>
    <Nav />
    <div class="container">
        <h2>Catalog list</h2>

        <router-link to="/catalog-create" class="nav-link">
            <button class="btn btn-primary">Create a Catalog</button>
        </router-link>

        <div class="col-12" style="margin-bottom: 10px;margin-top: 30px;">
            <div class="row">
                <div class="col-2">
                    <input class="form-control" v-model="search" type="text" placeholder="Search...">
                </div>
                <div class="col-2">
                    <select class="form-select" v-model="sortType">
                        <option value="nameASC" selected>Name ASC</option>
                        <option value="nameDESC">Name DESC</option>
                        <option value="productsASC">Product count ASC</option>
                        <option value="productsDESC">Product count DESC</option>
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
                <th scope="col">Products</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="catalog in catalogs">
                    <td>{{ catalog.name }}</td>
                    <td>{{ catalog.numberOfProducts }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
    import axios from 'axios';
    import { onMounted, ref, watch } from 'vue';
    import Nav from './Nav.vue';

    const catalogs = ref([]);
    const search = ref();
    const sortType = ref('nameASC');
    const limit = ref(20);

    function getCatalogList()
    {
        var queryParams = '?sortType=' + sortType.value + '&limit=' + limit.value;
        if (search.value != null) {
            queryParams += '&q=' + search.value;
        }

        axios.get('catalog'+queryParams).then( response => {
            catalogs.value = response.data
        });
    }

    onMounted(() => {
        getCatalogList()
    })

    watch(search, async (newSearch) => getCatalogList());
    watch(sortType, async (newSortType) => getCatalogList());
    watch(limit, async (newLimit) => getCatalogList());

</script>