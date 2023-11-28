@extends('layouts.app')

@section('content')

<div class=""> 

    @include('layouts.navbar')
     <div class="container-fluid mt-5 px-5"> 
        <div class="row no-vscroll"> 
            <div class="col-sm px-5">
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="/storage/{{$room->image1}}" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="/storage/{{$room->image2}}" class="d-block w-100" alt="...">
                    </div>
                    @if(!empty($room->image3))
                    <div class="carousel-item">
                        <img src="/storage/{{$room->image3}}" class="d-block w-100" alt="...">
                    </div>
                    @endif
                    @if(!empty($room->image4))
                    <div class="carousel-item">
                        <img src="/storage/{{$room->image4}}" class="d-block w-100" alt="...">
                    </div>
                    @endif
                    
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                   <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                   <span class="visually-hidden">Previous</span>
                 </button>
                 <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                   <span class="carousel-control-next-icon" aria-hidden="true"></span>
                   <span class="visually-hidden">Next</span>
                 </button>
                </div>
            </div>
            <div class="col-sm px-5 vscroll mb-5 pb-5">
                <p class="fw-bold fs-3 mb-0">{{$room->name}}</p>
                <div class="d-flex justify-content-between align-items-center mb-0">
                    <small>Room Type:<span class="fw-bold">{{$room->room_type}}</span></small>
                     <p class="mb-0">+91-<em>{{$room->contact_details}}</em></p>
                </div> 
             

                <p class="mb-0 fw-bold fs-5 mt-2">
                    <i class="fa-solid fa-indian-rupee-sign"></i> {{$room->room_price}} 
                    <span class="fs-6 fw-normal">/month</span>
                </p> 
                <div class="chips my-2"> 
                    @if($room->amenities)
                        @foreach(explode(",", $room->amenities) as $amenity)
                            <span class="badge rounded-pill text-bg-info">{{ $amenity }}</span> 
                        @endforeach 
                    @endif 
                </div>
                <p>{{$room->description}}</p>
                <p class="mb-0 fw-bold">Rules & Restrictions</p>
                <ul> 
                    @if($room->rules_restrictions)
                        @foreach(explode(",", $room->rules_restrictions) as $rule)
                            <li class="">{{ $rule }}</li>
                        @endforeach
                    @endif
                </ul>
            
            </div>
    
          

        </div>
        <div class="box fixed-bottom card p-3">
            <div class="row">
                <div class="col-sm">
                    <form  method="POST" action="/send/{{$room->owner_id}}/{{$room->room_id}}">
                             @csrf 
                           
                         
                                    <button type="submit" id="sendMessageButton" class="btn btn-lg chat-btn w-100">
                                         <i class="fa-solid fa-comment"></i> Chat
                                    </button>
                               
                    </form>
                </div>
                <div class="col-sm">
                        <button class="btn route-btn btn-lg w-100 show-route-button" id="pgRoute" data-start-lat="{{$room->latitude}}" data-start-lng="{{$room->longitude}}">
                                <i class="fa-solid fa-route"></i> Show Route
                        </button>
     
                </div>
            </div>
        </div>
    </div> 
</div> 
@endsection