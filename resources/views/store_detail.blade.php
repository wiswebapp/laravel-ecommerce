@extends('layouts.app')

@section('content')
<section class="ftco-section" style="padding:2em">
    <div class="container">
        <div class="row" style="background-color: #FC5859;">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 store-image-box" style="padding: 2em;">
                        <img class="img-thumbnail img-responsive" style="height: 200px;width: 300px;" src="{{asset('storage/store/'.$data['storeData']->image)}}" alt="">
                    </div>
                    <div class="col-md-9 store-detail-box" style="padding: 2em;color:white;">
                        <h3 style="color:white">{{$data['storeData']->name}} <span class="badge badge-success" style="float:right;">4.5 ⭐</span></h3>
                        <p><strong>Address :</strong> {{$data['storeData']->location}} - {{$data['storeData']->zipcode}}</p>
                        <p><strong>Store Timings</strong> </p>
                        <p><strong>Morning :</strong> {{$data['storeMorningTime']}}</p>
                        <p><strong>Evening :</strong> {{$data['storeEveningTime']}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($data['storeData']->getProducts as $product)
            <div class="col-md-6 col-lg-3 ftco-animate">
                <div class="product">
                <a href="/store-detail/{{$product->id}}" class="img-prod">
                    <img class="img-fluid" src="{{asset('storage/product/'.$product->product_image)}}" alt="{{$product->name}}">
                    <span class="status">{{rand(5,50)}}% Offer Now</span>
                    <div class="overlay"></div>
                </a>
                <div class="text py-3 pb-4 px-3">
                    <h3><a href="/store-detail/{{$product->id}}">{{$product->product_name}}</a> <label class="badge badge-success">{{rand(1,4)}}.5 ⭐</label></h3>
                    <p><a>{{$product->category->category_name}}</a></p>
                    <p style="margin:0px;"><strong>$ {{$product->price}}</strong>  <small style="text-decoration: line-through;">$ {{$product->price + 100}}</small></p>
                    <hr>
                    <button class="btn btn-sm btn-danger">Add Now</button>
                </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
