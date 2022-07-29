@php
    $routeUrl = route('admin.product');
    $routeCreateUrl = route('admin.create_product');
    $routeEditUrl = url(config('app.admin_path_name').'/product/edit/');
@endphp

@section('title','Product')

@extends('admin.layouts.app_admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>{{$data['pageTitle']}}
              @can('Create Product')
              <a href="{{$routeCreateUrl}}" class="float-right btn btn-sm btn-info"><i class="fa fa-plus fa-sm"></i> Add {{$data['pageTitle']}}</a>
              @endcan
            </h1>
            <hr>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              @include('includes.alert_msg')
              <div class="card-header">
                <!-- Filter Area -->
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-1"><p style="margin-top: 7px;">Filter Data</p></div>
                        <div class="col-2">
                        <input type="text" name="name" class="form-control" placeholder="Filter by Name" value="{{isset($_GET['name']) ? $_GET['name'] : ""}}">
                        </div>
                        <div class="col-2">
                            <select name="status" class="form-control">
                                <option value="">Filter By Status</option>
                                <option <?=(@$_GET['status'] == "Active") ? "selected" : ""?> value="Active">Active</option>
                                <option <?=(@$_GET['status'] == "InActive") ? "selected" : ""?> value="InActive">InActive</option>
                            </select>
                        </div>
                        <div class="col-2">
                          <button type="submit" class="btn btn-default">Filter</button>
                          <a href="{{$routeUrl}}" class="btn btn-default">Reset</a>
                        </div>
                        <div class="col-5">
                            {!! generateExportSection('product') !!}
                        </div>
                    </div>
                </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered text-nowrap">
                  <thead>
                    <tr>
                      <th><input type="checkbox" class="select-all-cb"></th>
                      <th>Image</th>
                      <th>Category</th>
                      <th>Product name</th>
                      <th>Product Price</th>
                      <th>Availiblity</th>
                      <th>Stock Count</th>
                      <th>Status</th>
                      <th style="width: 15%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($data['pageData']) > 0)
                        @foreach($data['pageData'] as $pageData)
                            <tr>
                                <td><input type="checkbox" data-id="{{$pageData->id}}" class="data-cb"></td>
                                <td><img style="height:100px;width:100px;" class="img img-thumbnail" src="<?=(! empty($pageData->product_image) ? '/storage/product/'.$pageData->product_image : "https://dummyimage.com/100x100/000/fff&text=No+Image")?>" alt="No Image Availble"></td>
                                <td><?=$pageData->category->category_name?></td>
                                <td><?=$pageData->product_name?></td>
                                <td><?=formatNum($pageData->price)?></td>
                                <td><?=$pageData->is_available?></td>
                                <td><?=$pageData->stock_count?></td>
                                <td>
                                    {!! generateStatusRow($pageData) !!}
                                </td>
                                <td>
                                  @can('Edit Product')
                                  {!! generateEditButton($routeEditUrl.'/'.$pageData->id) !!}
                                  @endcan
                                  @can('Delete Product')
                                  {!! generateDeleteButton('product', $pageData->id) !!}
                                  @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                    <tr class="text-danger">
                      <td colspan="10">Sorry No Data Found</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div>
              <div class="pull-right">
                @if (count($data['pageData']) > 0)
                {{$data['pageData']->links('pagination::bootstrap-4')}}
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
