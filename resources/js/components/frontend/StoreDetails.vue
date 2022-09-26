<template>
    <div class="container">
        <div class="row" style="background-color: #FC5859;">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 store-image-box" style="padding: 2em;">
                        <img :src="'/storage/store/' + store.image" :alt="store.name" class="img-thumbnail img-responsive" style="height: 200px;width: 300px;" >
                    </div>
                    <div class="col-md-9 store-detail-box" style="padding: 2em;color:white;">
                        <h3 style="color:white">{{store.name}} <span class="badge badge-success" style="float:right;">4.5 ⭐</span></h3>
                        <p><strong>Address :</strong> {{store.address}} - {{store.zipcode}}</p>
                        <p><strong>Store Timings</strong> </p>
                        <p><strong>Morning :</strong> {{ storemorningtime }}</p>
                        <p><strong>Evening :</strong> {{ storeeveningtime }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:3em;">
            <div class="col-md-9">
                <div class="col-md-4 col-lg-4" v-for="product in storeproducts">
                    <div class="product">
                        <a class="img-prod">
                            <img class="img-fluid" :src="'/storage/product/' + product.product_image" :alt="product.product_name">
                            <span class="status">10% Offer Now</span>
                            <div class="overlay"></div>
                        </a>
                        <div class="text py-3 pb-4 px-3">
                            <h3><a>{{product.product_name}}</a> <label class="badge badge-success">3.5 ⭐</label></h3>
                            <p><a>{{getCategoryName(product.category_id)}}</a></p>
                            <p style="margin:0px;"><strong>$ {{product.price}}</strong>  <small style="text-decoration: line-through;">$ {{product.price + 100}}</small></p>
                            <hr>
                            <button @click="loadProductCartModal(product.id)" class="btn btn-sm btn-danger">Add Now</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cart Data</h3>
                    </div>
                    <hr>
                    <div class="panel-body">
                        <div class="row" style="margin-bottom:1em;">
                            <div class="col-md-2">
                                <img src="https://dummyimage.com/50x50/000/fff" alt="">
                            </div>
                            <div class="col-md-10" align="left">
                                <p style="margin:0px">Item Name 1 <small style="float:right">$ 18.00</small></p>
                                <span>Quantity X <b>3</b> <small style="float:right"> <span class="btn btn-sm btn-info">Edit</span> <span class="btn btn-sm btn-danger">Remove</span></small></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <img src="https://dummyimage.com/50x50/000/fff" alt="">
                            </div>
                            <div class="col-md-10" align="left">
                                <p>Item Longgggggggggg Name 1 <br> <small>Quantity X 2</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <AddToCartModal :product=this.productDetail />
    </div>
</template>

<script>
    import AddToCartModal from './AddToCartModal.vue';
    import generalMixins from './mixins/generalMixins';

    export default {
        components: {
            AddToCartModal
        },
        mixins: [generalMixins],
        props: {
            'categorydata': { type: Array},
            'storedata' : { type: Object },
            'storeproducts': { type: Array },
            'storemorningtime': { type: String, default: "No Timing Available to show" },
            'storeeveningtime': { type: String, default: "" },
        },
        data() {
            return {
                productDetail: {
                    name : '',
                    image : '',
                    sdesc : '',
                    ldesc : '',
                    stock_count : '',
                    price : '',
                },
                store: this.storedata,
                category: this.categorydata,
            }
        },
        methods: {
            loadProductCartModal(productId) {
                axios.post('/get-product-detail', {
                    storeId: productId,
                })
                .then((response) => {
                    this.productDetail.name = response.data.product_name;
                    this.productDetail.image = response.data.product_image;
                    this.productDetail.sdesc = response.data.product_short_description;
                    this.productDetail.ldesc = response.data.product_long_description;
                    this.productDetail.stock_count = response.data.stock_count;
                    this.productDetail.price = response.data.price;
                    $("#product-cart-modal").modal('show')
                })
                .catch(function (error) {
                    console.log(error)
                });
            },
            getCategoryName(catId) {
                let obj = this.category.find(o => o.id === catId);
                return obj.category_name;
            }
        }
    }
</script>
