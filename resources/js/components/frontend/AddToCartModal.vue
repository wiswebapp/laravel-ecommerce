<template>
    <div id="product-cart-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{productDetail.name}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>{{productDetail.image}}</p>
                <p>{{productDetail.sdesc}}</p>
                <p>{{productDetail.ldesc}}</p>
                <p>{{productDetail.price}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: [product],
    data(){
        return {

        }
    },
    methods: {
        loadProductCartModal() {
            console.log(productDetail);
        }
    }
}
</script>
