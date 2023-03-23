@extends('layouts.app')

@section('content')
<section id="home-section" class="hero">
  <div class="home-slider owl-carousel"> @foreach ($data['bannerData'] as $banner) <div class="slider-item" style="background-image: url({{ asset('storage/banner/'.$banner->path) }});">
      <div class="overlay"></div>
      <div class="container">
        <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
          <div class="col-md-12 ftco-animate text-center">
            <h1 class="mb-2">{{$banner->title}}</h1>
          </div>
        </div>
      </div>
    </div> @endforeach </div>
</section>
<section class="ftco-section">
  <div class="container">
    <div class="homeSearchBox row text-center" style="">
        {{ Form::open(['method' => 'post', 'class' => 'homeSearchForm', 'url' => 'store-listing']) }}
            <p>Browse Store-based Deliveries in Your Area</p>
            <div class="deliver-address">
                <input type="hidden" name="userStoreLat" id="home-location-lat">
                <input type="hidden" name="userStoreLong" id="home-location-long">
                <input type="text" name="userStoreAddress" class="" style="width:90%" id="home-location-search">
                <input type="submit" class="home-location-btn btn-danger" style="width:10%" value="search">
            </div>
        </div>
        {{ Form::close() }}
    </div>
    <div class="row no-gutters ftco-services">
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
            <span class="flaticon-shipped"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Free Shipping</h3>
            <span>On order over $100</span>
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-2 d-flex justify-content-center align-items-center mb-2">
            <span class="flaticon-diet"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Always Fresh</h3>
            <span>Product well package</span>
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
            <span class="flaticon-award"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Superior Quality</h3>
            <span>Quality Products</span>
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
            <span class="flaticon-customer-service"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Support</h3>
            <span>24/7 Support</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="ftco-section ftco-category ftco-no-pt">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-6 order-md-last align-items-stretch d-flex">
            <div class="category-wrap-2 ftco-animate img align-self-stretch d-flex" style="background-image: url(images/category.jpg);">
              <div class="text text-center">
                <h2>Vegetables</h2>
                <p>Protect the health of every home</p>
                <p>
                  <a href="#" class="btn btn-primary">Shop now</a>
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="category-wrap ftco-animate img mb-4 d-flex align-items-end" style="background-image: url(images/category-1.jpg);">
              <div class="text px-3 py-1">
                <h2 class="mb-0">
                  <a href="#">Fruits</a>
                </h2>
              </div>
            </div>
            <div class="category-wrap ftco-animate img d-flex align-items-end" style="background-image: url(images/category-2.jpg);">
              <div class="text px-3 py-1">
                <h2 class="mb-0">
                  <a href="#">Vegetables</a>
                </h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="category-wrap ftco-animate img mb-4 d-flex align-items-end" style="background-image: url(images/category-3.jpg);">
          <div class="text px-3 py-1">
            <h2 class="mb-0">
              <a href="#">Juices</a>
            </h2>
          </div>
        </div>
        <div class="category-wrap ftco-animate img d-flex align-items-end" style="background-image: url(images/category-4.jpg);">
          <div class="text px-3 py-1">
            <h2 class="mb-0">
              <a href="#">Dried</a>
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center mb-3 pb-3">
      <div class="col-md-12 heading-section text-center ftco-animate">
        <span class="subheading">Featured Products</span>
        <h2 class="mb-4">Our Products</h2>
        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row"> @foreach ($data['productList'] as $key => $item) <div class="col-md-6 col-lg-3 ftco-animate">
        <div class="product">
          <a href="{{$item->product_slug}}" class="img-prod">
            <img class="img-fluid" src="storage/product/{{$item->product_image}}" alt="Colorlib Template">
            <span class="status">Bestseller</span>
            <div class="overlay"></div>
          </a>
          <div class="text py-3 pb-4 px-3 text-center">
            <h3>
              <a href="#">{{$item->product_name}}</a>
            </h3>
            <div class="d-flex">
              <div class="pricing">
                <p class="price">
                  <span class="mr-2 price-dc">{{formatNum($item->price)}}</span>
                  <span class="price-sale">{{formatNum($item->price)}}</span>
                </p>
              </div>
            </div>
            <div class="bottom-area d-flex px-3">
              <div class="m-auto d-flex">
                <a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
                  <span>
                    <i class="ion-ios-menu"></i>
                  </span>
                </a>
                <a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">
                  <span>
                    <i class="ion-ios-cart"></i>
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div> @endforeach </div>
  </div>
</section>
<section class="ftco-section img" style="background-image: url(images/bg_3.jpg);">
  <div class="container">
    <div class="row justify-content-end">
      <div class="col-md-6 heading-section ftco-animate deal-of-the-day ftco-animate">
        <span class="subheading">Best Price For You</span>
        <h2 class="mb-4">Deal of the day</h2>
        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
        <h3>
          <a href="#">Spinach</a>
        </h3>
        <span class="price">$10 <a href="#">now $5 only</a>
        </span>
        <div id="timer" class="d-flex mt-5">
          <div class="time" id="days"></div>
          <div class="time pl-3" id="hours"></div>
          <div class="time pl-3" id="minutes"></div>
          <div class="time pl-3" id="seconds"></div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="ftco-section testimony-section">
  <div class="container">
    <div class="row justify-content-center mb-5 pb-3">
      <div class="col-md-7 heading-section ftco-animate text-center">
        <span class="subheading">Testimony</span>
        <h2 class="mb-4">Our satisfied customer says</h2>
        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
      </div>
    </div>
    <div class="row ftco-animate">
      <div class="col-md-12">
        <div class="carousel-testimony owl-carousel">
          <div class="item">
            <div class="testimony-wrap p-4 pb-5">
              <div class="user-img mb-5" style="background-image: url(images/person_1.jpg)">
                <span class="quote d-flex align-items-center justify-content-center">
                  <i class="icon-quote-left"></i>
                </span>
              </div>
              <div class="text text-center">
                <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <p class="name">Garreth Smith</p>
                <span class="position">Marketing Manager</span>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimony-wrap p-4 pb-5">
              <div class="user-img mb-5" style="background-image: url(images/person_2.jpg)">
                <span class="quote d-flex align-items-center justify-content-center">
                  <i class="icon-quote-left"></i>
                </span>
              </div>
              <div class="text text-center">
                <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <p class="name">Garreth Smith</p>
                <span class="position">Interface Designer</span>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimony-wrap p-4 pb-5">
              <div class="user-img mb-5" style="background-image: url(images/person_3.jpg)">
                <span class="quote d-flex align-items-center justify-content-center">
                  <i class="icon-quote-left"></i>
                </span>
              </div>
              <div class="text text-center">
                <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <p class="name">Garreth Smith</p>
                <span class="position">UI Designer</span>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimony-wrap p-4 pb-5">
              <div class="user-img mb-5" style="background-image: url(images/person_1.jpg)">
                <span class="quote d-flex align-items-center justify-content-center">
                  <i class="icon-quote-left"></i>
                </span>
              </div>
              <div class="text text-center">
                <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <p class="name">Garreth Smith</p>
                <span class="position">Web Developer</span>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimony-wrap p-4 pb-5">
              <div class="user-img mb-5" style="background-image: url(images/person_1.jpg)">
                <span class="quote d-flex align-items-center justify-content-center">
                  <i class="icon-quote-left"></i>
                </span>
              </div>
              <div class="text text-center">
                <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <p class="name">Garreth Smith</p>
                <span class="position">System Analyst</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<hr>
<section class="ftco-section ftco-partner">
  <div class="container heading-section text-center ftco-animate">
    <span class="subheading">Featured Stores on Portal</span>
    <h2 class="mb-4">Populur Stores</h2><hr>
    <div class="row">
      @foreach ($data['storeData'] as $store)
      @if ($store->image)
      <div class="col-md-2 ftco-animate fadeInUp ftco-animated">
        <div class="product">
          <a href="ahmed-reeves" class="store-img-prod">
            <img class="img-fluid" src="{{ asset('storage/store/'.$store->image) }}" alt="{{$store->name}}">
            <div class="overlay"></div>
          </a>
          <div class="text py-3 pb-4 px-3 text-center">
            <h3><a href="/store-detail/{{$store->id}}">{{$store->name}}</a></h3>
          </div>
        </div>
      </div>
      @endif
      @endforeach
    </div>
  </div>
</section>
@endsection
