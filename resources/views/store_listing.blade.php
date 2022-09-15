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
          <a href="#" class="img-prod">
            <img class="img-fluid" src="{{asset('storage/store/'.$store->image)}}" alt="{{$store->name}}">
            <span class="status">30% Offer Now</span>
            <div class="overlay"></div>
          </a>
          <div class="text py-3 pb-4 px-3 text-center">
            <h3><a href="#">{{$store->name}}</a></h3>
            <p><a href="#">{{$store->address}}</a></p>
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
          <ul>
            <li><a href="#">&lt;</a></li>
            <li class="active"><span>1</span></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">&gt;</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
