@extends('layouts.app')

@section('content')
<div>
    @include('layouts.navbar')
    @if(count($wishlists)>0)
      <div class="container mt-5">
   <div class="row">
   @foreach($wishlists as $wishlist)
    <div class="col-sm-4">
     <div class="card position-relative">
        <img src="storage/{{$wishlist->image1}}" class="card-img-top pg-img" alt="">
        <form method="POST" action="/wishlist/remove/{{$wishlist->room_id}}" class="position-absolute top-0 end-0 wishlist-form">
            @csrf
            <button type="submit" class="btn text-danger">
                <i class="fa-solid fa-heart"></i>
            </button>
        </form>

        <div class="chips position-absolute top-0 start-0 mt-2 ms-2">
            @if(!empty($wishlist->amenities))
                @foreach(explode(",", $wishlist->amenities) as $amenity)
                    <span class="badge rounded-pill transparent-chips">{{ $amenity }}</span><br>
                @endforeach
            @endif
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between">
                <a href='/room/{{$wishlist->room_id}}' class="nav-link"><h5 class="card-title mb-1">{{$wishlist->name}}</h5></a>
            </div>
            <div class="d-flex justify-content-between">
                <small><em>Room Type: </em> <span class="fw-bold">{{ $wishlist->room_type }}</span></small>
                <p class="card-text fw-bold"><i class="fa-solid fa-indian-rupee-sign"></i> {{ $wishlist->room_price }}</p>
            </div>
            <p class="card-text"><em>Contact: </em> <span class="fw-bold">{{ $wishlist->contact_details }}</span></p>
        </div>

        <div class="card-footer btn-group p-0" role="group" aria-label="Basic example">
            <form method="POST" action="/send/{{$wishlist->id}}/{{$wishlist->room_id}}" class="w-50">
                @csrf
                <button type="submit" id="sendMessageButton" class="btn chat-btn w-100">
                    <i class="fa-solid fa-comment"></i> Chat
                </button>
            </form>
            <button class="btn route-btn show-route-button w-50" data-start-lat="{{$wishlist->latitude}}" data-start-lng="{{$wishlist->longitude}}">
                <i class="fa-solid fa-route"></i> Show Route
            </button>
        </div>
    </div>
</div>
    @endforeach
</div>
</div>
    @else
        <div class="fill-y d-flex align-items-center justify-content-center">

           <p>Wishlist is empty</p>
</div>
    </div>

@endif

@endsection
