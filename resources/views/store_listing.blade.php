@extends('layouts.app')

@section('content')
<section class="ftco-section" style="padding:2em">
  <div class="container">
    <div class="row">
      <div class="col-md-12 storeListingBox">
        <div class="subscribe-form">
            <div class="form-group d-flex">
            <input type="submit" value="Showing Stores From Location" class="submit px-3">
            <input type="text" class="form-control" readonly value="{{$data['shownAddress']}}">
            </div>
        </div>
        </div>
      @foreach ($data['storeData'] as $store)
      <div class="col-md-6 col-lg-3 ftco-animate">
        <div class="product">
          <a href="/store-detail/{{$store->id}}" class="img-prod">
            <img class="img-fluid" src="{{asset('storage/store/'.$store->image)}}" alt="{{$store->name}}">
            <span class="status">{{rand(5,50)}}% Offer Now</span>
            <div class="overlay"></div>
          </a>
          <div class="text py-3 pb-4 px-3">
            <h3><a href="/store-detail/{{$store->id}}">{{$store->name}}</a> <label class="badge badge-success">{{rand(1,4)}}.5 ⭐</label></h3>
            <p><a>Delivers In {{rand(10,30)}} Minutes</a></p>
            <hr>
            <p style="margin:0px;"><strong>Address :</strong>{{$store->address}}</p>
            {{$store->id}}
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="row mt-5">
      <div class="col text-center">
        <div class="block-27">
            @if ( count($data['storeData']) > 0)
                {{$data['storeData']->links('pagination::bootstrap-4')}}
            @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
