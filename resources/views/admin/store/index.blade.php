@php
    $routeUrl = route('admin.store');
    $routeCreateUrl = route('admin.create_store');
    $routeEditUrl = url(config('app.admin_path_name').'/store/edit/');
    $pageData = $data['pageData'];
@endphp
@section('title','Stores')

@extends('admin.layouts.app_admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>{{$data['pageTitle']}}
              @can('Create Store')
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
                <form method="GET" action="" id="filter-form">
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
                            {!! generateExportSection('store') !!}
                        </div>
                    </div>
                </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered text-nowrap">
                            <thead>
                                <tr>
                                <th><input class="select-all-cb" type="checkbox"></th>
                                <th>Created On</th>
                                <th>Store Name</th>
                                <th>Store Owner</th>
                                <th>Email</th>
                                <th>Status</th>
                                @can('Edit Store', 'Delete Store')
                                <th style="width: 15%">Action</th>
                                @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($pageData) > 0)
                                    @foreach($pageData as $row)
                                        <tr>
                                            <td><input type="checkbox" class="data-cb" data-id="<?=$row->id?>"></td>
                                            <td><?=toDate($row->created_at)?></td>
                                            <td><?=$row->name?></td>
                                            <td><?=$row->owner?></td>
                                            <td><?=$row->email?></td>
                                            <td>
                                                {!! generateStatusRow($row) !!}
                                            </td>
                                            @can('Edit Store', 'Delete Store')
                                            <td>
                                            @can('Edit Store')
                                            {!! generateEditButton($routeEditUrl.'/'.$row->id) !!}
                                            @endcan
                                            @can('Delete Store')
                                            {!! generateDeleteButton('store', $row->id) !!}
                                            @endcan
                                            </td>
                                            @endcan
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
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div style="float: right">
                            @if (count($pageData) > 0)
                            {{$pageData->links('pagination::bootstrap-4')}}
                            @endif
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
