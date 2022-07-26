<?php
  $pageData = "";
  $action = $data['action'];
  if($action == "Edit"){
    $pageData = $data['pageData'];
  }
?>

@extends('admin.layouts.app_admin')

@section('title',$data['pageTitle'])

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{$data['pageTitle']}}</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            @include('includes.alert_msg')
            <div class="card">
                <div class="card-body">
                @if ($action == "Edit")
                    {{Form::open(['action' => ['admin\ProductController@update_product',$pageData->id],'method'=>'PUT','enctype'=>'multipart/form-data'])}}
                @else
                {{Form::open(['action' => ['admin\ProductController@store_product'],'method'=>'post','enctype'=>'multipart/form-data'])}}
                @endif
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" class="form-control select2" onchange="setSubCategory(this.value)" id="category" required>
                            <option value="">Select Category</option>
                            @foreach ($data['pageData']['category'] as $item)
                                <option <?=(($pageData->parent_id == $item->id) ? "selected" : "")?> value="{{$item->id}}">{{$item->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label>Sub Category</label>
                        <select name="subcategory_id" class="form-control select2" id="subCategory" required>
                        </select>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" value="{{old('product_name',$pageData->product_name)}}" class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}" placeholder="Enter Name">
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label>Product Description <small>(Short)</small></label>
                        <textarea name="product_short_description"
                            class="form-control {{ $errors->has('product_short_description') ? 'is-invalid' : '' }}"
                            placeholder="Enter Description">{{old('product_short_description',$pageData->product_short_description)}}</textarea>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label>Product Description <small>(Long)</small></label>
                        <textarea name="product_long_description" class="form-control wysiwyg-ck {{ $errors->has('product_long_description') ? 'is-invalid' : '' }}" placeholder="Enter Description">{{old('product_long_description',$pageData->product_long_description)}}</textarea>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label>Product Price</label>
                        <input type="text" name="price" value="{{old('price',$pageData->price)}}" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" placeholder="Enter price">
                    </div>
                </div>

                {{-- <div class="col-md-8">
                    <div class="form-group">
                        <label>Product Image</label><br>
                        @if ($pageData->product_image != "")
                        <img src="{{Storage::url('public/product/'.$pageData->product_image)}}" alt="Product Image" class="img-thumbnail" style="height: 150px;width: 150px;">
                        @endif
                        <input type="file" name="product_image" class="form-control {{ $errors->has('product_image') ? 'is-invalid' : '' }}" >
                    </div>
                </div> --}}

                <div class="col-md-8">
                    <div class="form-group">
                        <label>Stock Count</label>
                        <input type="text" name="stock_count" value="{{old('stock_count',$pageData->stock_count)}}"
                            class="form-control {{ $errors->has('stock_count') ? 'is-invalid' : '' }}" placeholder="Enter Stock Count">
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label>Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" <?=($action=="Add" ) ? "checked" : "" ?>
                            value='Active'
                            <?=($pageData->status == 'Active') ? "checked" : ""?>>
                            <label class="form-check-label">Active</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" name="status" value='InActive' <?=($pageData->status ==
                            'InActive') ? "checked" : ""?>>
                            <label class="form-check-label">InActive</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label>Is Available</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_available" <?=($action=="Add" ) ? "checked" : "" ?>
                            value='Yes'
                            <?=($pageData->is_available == 'Yes') ? "checked" : ""?>>
                            <label class="form-check-label">Yes</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" name="is_available" value='No' <?=($pageData->is_available ==
                            'No') ? "checked" : ""?>>
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>

                </div>
                <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{$data['action']}} Data</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
      </div>
    </section>
  </div>

<script type="application/javascript">
  <?php if($action == "Edit"){ ?>
  setCategory('{{$pageData->category_id}}');
  setSubCategory('{{$pageData->category_id}}','{{$pageData->subcategory_id}}');
  <?php } ?>
</script>
@endsection
