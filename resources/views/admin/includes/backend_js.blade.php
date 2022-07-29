<script>
function removeData(dataType, dataId) {
    htmlText = 'This data will not be retrived once deleted';
    if(dataType == "product"){
        routeUrl = '{{route('admin.destroy_product')}}';
    }else if(dataType == "category"){
        routeUrl = '{{route('admin.destroy_category')}}';
        htmlText = '<span style="color:red">All related Category & Product will be removed<span>';
    }else if(dataType == "subcategory"){
        routeUrl = '{{route('admin.destroy_subcategory')}}';
    }else if(dataType == "user"){
        routeUrl = '{{route('admin.destroy_user')}}';
    }else if(dataType == "admin"){
        routeUrl = '{{route('admin.destroy_admin')}}';
    }

    removeSingleData(routeUrl, htmlText, dataId);
}

<?php if( in_array(\Request::route()->getName(), ['admin.create_product', 'admin.edit_product'])) { ?>
function setCategory(selectedId='') {
    $.ajax({
        type : "POST",
        url : '{{route('ajax.getCat')}}',
        data : { selectedId:selectedId },
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success : function(response) {
            if(response.success){
                $("#category").html(response.subCatData);
            }
        }
    });
}

function setSubCategory(categoryId, selectedId = '') {
    if(categoryId != '') {
        $.ajax({
            type : "POST",
            url : '{{route('ajax.getSubCat')}}',
            data : {
                categoryId:categoryId,
                selectedId:selectedId
            },
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success : function(response) {
                if(response.success){
                    $("#subCategory").html(response.subCatData);
                }else{
                    $("#subCategory").html("<option>Whoops</option>");
                }
            }
        });
    }
}
<?php  } ?>
</script>
