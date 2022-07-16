@php
$routeUrl = route('admin.admin');
$routeCreateUrl = route('admin.create_admin');
$routeEditUrl = url(ADMIN_PATH.'/admin/edit/');
@endphp

@section('title',$data['pageTitle'])

@extends('admin.layouts.app_admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{$data['pageTitle']}}
                    @can('Create Admin')
                    <a href="{{$routeCreateUrl}}" class="float-right btn btn-sm btn-info"><i class="fa fa-plus fa-sm"></i> Add
                        {{$data['pageTitle']}}</a>
                    @endcan</h1>
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
                                    <div class="col-1">
                                        <p style="margin-top: 7px;">Filter Data</p>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" name="name" class="form-control" placeholder="Filter by Name"
                                            value="{{isset($_GET['name']) ? $_GET['name'] : ""}}">
                                    </div>
                                    <div class="col-2">
                                        <select name="status" class="form-control">
                                            <option value="">Filter By Status</option>
                                            <option <?=(@$_GET['status'] == "Active") ? "selected" : ""?>
                                                value="Active">Active</option>
                                            <option <?=(@$_GET['status'] == "InActive") ? "selected" : ""?>
                                                value="InActive">InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button type="submit" class="btn btn-default">Filter</button>
                                        <a href="{{$routeUrl}}" class="btn btn-default">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox"></th>
                                        <th>Created On</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th style="width: 15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['pageData']) > 0)
                                    @foreach($data['pageData'] as $pageData)
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td><?=toDate($pageData->created_at)?></td>
                                        <td><?=$pageData->name?></td>
                                        <td><?=$pageData->email?></td>
                                        <td><?=$pageData->getRoleNames()->toArray()[0]?></td>
                                        <td>
                                            {!! generateStatusRow($pageData) !!}
                                        </td>
                                        <td>
                                            @can('View Admin')
                                            {!! generateEditButton($routeEditUrl.'/'.$pageData->id) !!}
                                            @endcan
                                            @if(Auth::User()->can('Delete Admin') && $pageData->getRoleNames()->toArray()[0] != "Super Admin")
                                            {!! generateDeleteButton('admin', $pageData->id) !!}
                                            @endif
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
