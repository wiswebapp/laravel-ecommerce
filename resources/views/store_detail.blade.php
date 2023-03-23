@extends('layouts.app')

@section('content')
<section class="ftco-section" style="padding:2em">

    <store-detail-listing
        :storemorningtime="'{{$data['storeMorningTime']}}'"
        :storeeveningtime="'{{$data['storeEveningTime']}}'"
        :storedata="{{ $data['storeData'] }}"
        :storeproducts="{{ $data['storeData']->getProducts }}"
        :categorydata="{{ $data['categoryData'] }}"
    />

</section>
@endsection
