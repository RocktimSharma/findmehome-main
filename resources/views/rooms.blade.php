@extends('layouts.app')

@section('content')
<div>
    @include('layouts.navbar')
    <div class="container">


        <div class="d-flex justify-content-between align-items-center">
            <p class="fs-3 fw-bold mt-3">{{$pg->name}}</p> <a href="/room/create/{{ $pg->pg_id }}" class="btn
                primary-btn">Add Room</a> </div>

            <div class="row"> @if(count($rooms)>0)
                @foreach ($rooms as $room)
                <div class="col-md-4 mb-3">

                <div class="card"> 
                    
                <img src="storage/{{$room->image1}}" class="card-img-top" alt=""> <div
                    class="card-body"> 
                    
                    
                    <div id="carouselExample" class="carousel slide">
  <div class="carousel-inner room-card">
  <div class="carousel-item active">
    @if($room->image1 && file_exists(public_path("storage/" . $room->image1)))
    <img src="{{ asset('storage/' . $room->image1) }}" class="" alt="...">

@endif
    </div>
    <div class="carousel-item">
    @if($room->image2 && file_exists(public_path("storage/" . $room->image2)))
    <img src="{{ asset('storage/' . $room->image2) }}" class="" alt="...">

@endif
    </div>
    <div class="carousel-item">
    @if($room->image3 && file_exists(public_path("storage/" . $room->image3)))
    <img src="{{ asset('storage/' . $room->image3) }}" class="" alt="...">

@endif
    </div>
    <div class="carousel-item">
    @if($room->image4 && file_exists(public_path("storage/" . $room->image4)))
    <img src="{{ asset('storage/' . $room->image4) }}" class="" alt="...">

@endif
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

                    <div class="chips mb-2"> @if($room->amenities)
                    @foreach(explode(",", $room->amenities) as $amenity)
                    <span class="badge rounded-pill text-bg-info">{{ $amenity }}</span>
                    @endforeach
                    @endif

                </div>

                <div class="d-flex justify-content-between">
                <small>{{ $room->room_type }}</small>
                <p class="card-text"><i class="fa-solid fa-indian-rupee-sign"></i> {{ $room->room_price }}</p>
                </div>
                <p>Availability Status: {{ $room->availability_status }}</p>

                </div>


                <div class="btn-group card-footer p-0" role="group" aria-label="Basic example">
                <a type="button" class="btn chat-btn"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                <form action="{{ route('roomDelete', $room->room_id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn primary-btn"><i class="fa-solid fa-trash"></i> Delete</button>
</form>
               



                </div>
            </div>

    </div>
    @endforeach
@else

@endif
</div>

</div>


</div>
</div>
@endsection