@php
  $action = $data['action'];
  if($action == "Edit"){
    $pageData = $data['pageData'];
  }
@endphp

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
                {{Form::open([
                    'action' => ['admin\StoreController@update_store',$pageData->id],
                    'method'=>'PUT',
                    'enctype'=>'multipart/form-data'
                ])}}
            @else
                {{Form::open([
                    'action' => ['admin\StoreController@store_store'],
                    'method'=>'post',
                    'enctype'=>'multipart/form-data'
                ])}}
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Store Name</label>
                                <input type="text" name="name" value="{{old('name',$pageData->name)}}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label>Store Owner</label>
                                <input type="text" name="owner" value="{{old('owner',$pageData->owner)}}" class="form-control {{ $errors->has('owner') ? 'is-invalid' : '' }}" placeholder="Enter owner name">
                            </div>
                            <div class="form-group">
                                <label>Store Email</label>
                                <input type="text" name="email" value="{{old('email',$pageData->email)}}" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label>Product Address</label>
                                <textarea name="address"
                                    class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                    placeholder="Enter Address">{{old('address',$pageData->address)}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Product Location</label>
                                <textarea name="location"
                                    class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}"
                                    placeholder="Enter Location">{{old('location',$pageData->location)}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" value="" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Enter password">
                            </div>
                            <div class="form-group">
                                <label>Store Image</label><br>
                                @if ($pageData->image != "")
                                <img src="{{Storage::url('public/store/'.$pageData->image)}}" alt="Product Image" class="img-thumbnail" style="height: 150px;width: 150px;">
                                @endif
                                <input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Country</label>
                                <select class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country" id="country" onchange="selectState(this.value)">
                                    <option value="">Select Country</option>
                                    @foreach ($data['country'] as $item)
                                    <option <?= ($pageData->country == $item->id) ? 'selected' : ''?> value="<?= $item->id ?>"><?= $item->name ?></option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select State</label>
                                <select disabled class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state" id="state">
                                    <option value="">Select Country first</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Zip Code</label>
                                <input type="text" name="zipcode" value="{{old('zipcode',$pageData->zipcode)}}" class="form-control {{ $errors->has('zipcode') ? 'is-invalid' : '' }}" placeholder="Enter zipcode">
                            </div>
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Manage Store Timing <i class="fa fa-stopwatch"></i></h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body" style="display: block;">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Set Timing For :</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="timingType" onchange="changeTimingSection(this.value)">
                                                <option <?=($data['timingType']->type == "daily") ? "selected" : ""?> value="daily">Daily</option>
                                                <option <?=($data['timingType']->type == "custom") ? "selected" : ""?> value="custom">Custom</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="customTimeBox">
                                        <label class="text-info">Default Timing</label><hr>
                                        <div class="form-group row">
                                            <label class="col-sm-3"> Morning slot:</label>
                                            <input type="text" name="default_morning_start" class="col-sm-4 form-control tpicker" value="{{$pageData['store_timing']->default->morning->start}}">
                                            <label class="col-sm-1"></label>
                                            <input type="text" name="default_morning_end" class="col-sm-4 form-control tpicker" value="{{$pageData['store_timing']->default->morning->end}}">
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3"> Evening slot:</label>
                                            <input type="text" name="default_evening_start" class="col-sm-4 form-control tpicker" value="{{$pageData['store_timing']->default->evening->start}}">
                                            <label class="col-sm-1"></label>
                                            <input type="text" name="default_evening_end" class="col-sm-4 form-control tpicker" value="{{$pageData['store_timing']->default->evening->end}}">
                                        </div>
                                    </div>
                                    <div class="form-group customTimingBox" style="display:<?=($pageData['store_timing']->default->type == "custom") ? "block" : "none"?>">
                                        @foreach ($data['dayArray'] as $day)
                                        @php
                                            $day = strtolower($day);
                                            $dayType = $pageData['store_timing']->$day->type;
                                        @endphp
                                        <div class="form-check">
                                            <input name="{{$day}}[]" data-day="{{$day}}" class="form-check-input daySelectionCB" type="checkbox" <?=($dayType == "custom") ? "checked" : ""?>>
                                            <label class="form-check-label">{{ucfirst($day)}}</label>
                                        </div>
                                        <div class="customTimeBox {{$day}}-box" style="display:<?=($dayType == "custom") ? "block" : "none"?>">
                                        <label class="text-info">Custom Timing for {{ucfirst($day)}}</label><hr>
                                            <div class="form-group row">
                                                <label class="col-sm-3"> Morning slot:</label>
                                                <input type="text" name="{{$day}}[]" class="col-sm-4 form-control tpicker" value="{{$pageData['store_timing']->$day->morning->start}}">
                                                <label class="col-sm-1"></label>
                                                <input type="text" name="{{$day}}[]" class="col-sm-4 form-control tpicker" value="{{$pageData['store_timing']->$day->morning->end}}">
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3"> Evening slot:</label>
                                                <input type="text" name="{{$day}}[]" class="col-sm-4 form-control tpicker" value="{{$pageData['store_timing']->$day->evening->start}}">
                                                <label class="col-sm-1"></label>
                                                <input type="text" name="{{$day}}[]" class="col-sm-4 form-control tpicker" value="{{$pageData['store_timing']->$day->evening->end}}">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
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
@endsection
@section('customScripts')
<script>
<?php if($action == "Edit"): ?>
selectState('<?=$pageData->country?>', '<?=$pageData->state?>')
<?php endif ?>
$('.tpicker').attr("readonly", true);
$('.tpicker').timepicker()
</script>
@endsection
