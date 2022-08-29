<template lang="pug">
    <div class="col-md-8" v-if="storeData.length">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recently Added Stores</h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    <li class="item" v-for="store in storeData">
                        <div class="product-img">
                            <img v-if="store.image" :src="'/storage/store/' + store.image" alt="Product Image" class="img-size-50">
                            <img v-else :src='"https://dummyimage.com/128x128/343a40/fff?text=store"' alt="Product Image" class="img-size-50"></img>
                        </div>
                        <div class="product-info">
                            <span class="product-title">{{store.name}}</span>
                            <span class="product-description">{{store.owner}} (<small><i>{{store.email}}</i></small>)</span>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="card-footer text-center">
                <a href="javascript:" @click="redirectToStore" class="btn btn-sm btn-default">View All <em class=" fa fa-arrow-circle-right"></em></a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            storeData : [],
        }
    },
    created() {
        this.fetchStoreData();
    },
    methods: {
        redirectToStore() {
            window.location.href = "store"
        },
        fetchStoreData(){
            fetch('vue/getDashboardStores')
                .then(res => res.json())
                .then(res => {
                    this.storeData = res
                })
        }
    }
}
</script>
