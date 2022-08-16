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
          <div class="col-sm-12">
            <h1>{{$data['pageTitle']}}</h1><hr>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           @include('includes.alert_msg')
            <div class="card">
            @if ($action == "Edit")
                {{Form::open(['action' => ['admin\BannerController@update_banner',$pageData->id],'method'=>'PUT','enctype'=>'multipart/form-data'])}}
            @else
              {{Form::open(['action' => ['admin\BannerController@store_banner'],'method'=>'post','enctype'=>'multipart/form-data'])}}
            @endif
              <div class="card-body">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Banner Title</label>
                        <input required type="text" name="title" value="{{old('title',$pageData->title)}}" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" placeholder="Enter Title">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Banner Order</label>
                        <input required type="text" name="order" value="{{old('order',$pageData->order)}}"
                            class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" placeholder="Enter order">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Banner Image</label><br>
                        @if ($pageData->path != "")
                        <img src="{{Storage::url('public/banner/'.$pageData->path)}}" alt="Banner Image" class="img-thumbnail" style="height: 150px;width: 350px;">
                        @endif
                        <input type="file" name="path" class="form-control {{ $errors->has('path') ? 'is-invalid' : '' }}" >
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
      </div>
    </section>
  </div>
@endsection
