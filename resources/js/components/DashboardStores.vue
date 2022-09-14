<template lang="pug">
    <div class="col-md-8" v-if="storeData.length">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recently Added Stores</h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    <li class="item" v-for="store in storeData" style="cursor:pointer">
                        <div @click="getStoreInformations(store.id)" class="store-items">
                            <div class="product-img">
                                <img v-if="store.image" :src="'/storage/store/' + store.image" alt="Product Image" class="img-size-50">
                                <img v-else :src='"https://dummyimage.com/128x128/343a40/fff?text=store"' alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                <span class="product-title">{{store.name}}</span>
                                <span class="product-description">{{store.owner}} (<small><i>{{store.email}}</i></small>)</span>
                                <span class="badge" :class="(store.status == 'Active' ? 'badge-success' : 'badge-danger')">{{store.status}}</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="card-footer text-center">
                <a href="javascript:" @click="redirectToStore" class="btn btn-sm btn-default">View All <em class=" fa fa-arrow-circle-right"></em></a>
            </div>
        </div>
        <div class="modal fade show" id="store-modal" aria-modal="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Store Detail</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordred">
                            <tr><th>Store Name</th><td>{{quickStoreDetail.name}}</td></tr>
                            <tr><th>Store Email</th><td>{{quickStoreDetail.email}}</td></tr>
                            <tr><th>Owner</th><td>{{quickStoreDetail.owner}}</td></tr>
                            <tr><th>Address</th><td>{{quickStoreDetail.address}}</td></tr>
                            <tr><th>Zip Code</th><td>{{quickStoreDetail.zipcode}}</td></tr>
                            <tr><th>Status</th><td><span class="badge" :class="(quickStoreDetail.status == 'Active' ? 'badge-success' : 'badge-danger')">{{quickStoreDetail.status}}</span></td></tr>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a @click="redirectToStore(quickStoreDetail.id)" type="button" class="btn btn-link">View Full Detail</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StoreMixin from '../mixins/StoreMixin'

export default {
    data(){
        return {
            storeData : [],
        }
    },
    mixins:[
        StoreMixin
    ],
    created() {
        this.fetchStoreData();
    },
    methods: {
        fetchStoreData() {
            fetch('vue/getDashboardStores')
                .then(res => res.json())
                .then(res => {
                    this.storeData = res
                })
        }
    }
}
</script>
