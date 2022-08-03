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
      <div class="container">
            @include('includes.alert_msg')
            @if ($action == "Edit")
                {{Form::open(['action' => ['admin\ProductController@update_product',$pageData->id],'method'=>'PUT','enctype'=>'multipart/form-data'])}}
            @else
                {{Form::open(['action' => ['admin\ProductController@store_product'],'method'=>'post','enctype'=>'multipart/form-data'])}}
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control select2" onchange="setSubCategory(this.value)" id="category" required>
                                    <option value="">Select Category</option>
                                    @foreach ($data['pageData']['category'] as $item)
                                        <option <?=(($pageData->parent_id == $item->id) ? "selected" : "")?> value="{{$item->id}}">{{$item->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sub Category</label>
                                <select name="subcategory_id" class="form-control select2" id="subCategory" required>
                                    <option value="">Please Select category</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_name" value="{{old('product_name',$pageData->product_name)}}" class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label>Product Description <small>(Short)</small></label>
                                <textarea name="product_short_description"
                                    class="form-control {{ $errors->has('product_short_description') ? 'is-invalid' : '' }}"
                                    placeholder="Enter Description">{{old('product_short_description',$pageData->product_short_description)}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Product Description <small>(Long)</small></label>
                                <textarea name="product_long_description" class="form-control wysiwyg-ck {{ $errors->has('product_long_description') ? 'is-invalid' : '' }}" placeholder="Enter Description">{{old('product_long_description',$pageData->product_long_description)}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Product Image</label><br>
                                @if ($pageData->product_image != "")
                                <img src="{{Storage::url('public/product/'.$pageData->product_image)}}" alt="Product Image" class="img-thumbnail" style="height: 150px;width: 150px;">
                                @endif
                                <input type="file" name="product_image" class="form-control {{ $errors->has('product_image') ? 'is-invalid' : '' }}" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product Price</label>
                                <input type="text" name="price" value="{{old('price',$pageData->price)}}" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" placeholder="Enter price">
                            </div>
                            <div class="card card-default">
                                <div class="card-header d-flex p-0">
                                    <h3 class="card-title p-3">Options </h3>
                                    <ul class="nav nav-pills ml-auto p-2">
                                        <span onclick="showOptionModal()" class="btn btn-success btn-sm">+ Add</span>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="row option-input">
                                        <div class="col-md-5"><b>Name</b></div>
                                        <div class="col-md-5"><b>Price</b></div>
                                        <hr>
                                        @forelse ($data['pageData']->product_options as $optionData)
                                        <div class="row option-row-{{$optionData->id}}">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input readonly type="text" autocomplete="off" name="option_name[]" value="{{$optionData->option_name}}" class="option-name-{{$optionData->id}} form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input readonly type="text" autocomplete="off" name="option_price[]" value="{{$optionData->option_value}}" class="option-value-{{$optionData->id}} form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-1"><span onclick="editOptionForm({{$optionData->id}})" class="btn btn-sm btn-success"><i class="fa fa-pen"></i></span></div>
                                            <div class="col-md-1"><span onclick="removeOptionForm({{$optionData->id}})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></span></div>
                                        </div>
                                        @empty
                                        <pre class="no-option-text text-danger">No Options Added</pre>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Stock Count</label>
                                <input type="text" name="stock_count" value="{{old('stock_count',$pageData->stock_count)}}"
                                    class="form-control {{ $errors->has('stock_count') ? 'is-invalid' : '' }}" placeholder="Enter Stock Count">
                            </div>
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
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{$data['action']}} Data</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
                </div>
            </div>
            {{Form::close()}}
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

@section('bootstrap-modals')
<div class="modal fade" id="modal-options">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Manage Options</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 alert alert-danger option-error" style="display:none">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Please add proper data</strong>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name </label>
                            <input type="text" autocomplete="off" name="stock_count" value="" class="form-control option-name" placeholder="Option Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" autocomplete="off" name="stock_count" value="" class="form-control option-price" placeholder="Option Price">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="saveOptionForm()" class="submit-optionmodal btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
