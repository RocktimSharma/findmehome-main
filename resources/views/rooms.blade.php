@extends('layouts.app')

@section('content')
<div>
    @include('layouts.navbar')
    <div class="container">


        <div class="d-flex justify-content-between align-items-center">
            <p class="fs-3 fw-bold mt-3">{{$pg->name}}</p> <a href="/room/create/{{ $pg->pg_id }}" class="btn
                primary-btn"><i class="fa-solid fa-plus"></i> Add Room</a> </div>
                @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
            <div class="row"> @if(count($rooms)>0)
                @foreach ($rooms as $room)
                <div class="col-md-4 mb-3">

                <div class="card"> 
                    
                <img src="{{ asset('storage/' . $room->image1) }}" class="card-img-top pg-img" alt="">
                 <div class="card-body"> 
                    
                    


                    <div class="chips position-absolute top-0 start-0 mt-2 ms-2"> @if($room->amenities)
                    @foreach(explode(",", $room->amenities) as $amenity)
                    <span class="badge rounded-pill transparent-chips">{{ $amenity }}</span><br>
                    @endforeach
                    @endif

                </div>
                <p class="mb-1 fw-light">Room Id: <span class="fw-bold">{{$room->room_id}}</span></p>
                <div class="d-flex justify-content-between">
              
                <small class="fw-light">Room Type: <span class="fw-bold">{{ $room->room_type }}</span></small>
                <p class="card-text"><i class="fa-solid fa-indian-rupee-sign"></i> {{ $room->room_price }}</p>
                </div>
                <p class="fw-light mb-0">Availability Status: <span class="text-capitalize fw-bold"> {{ $room->availability_status }}</span></p>

                </div>
                <div class="card-footer btn-group p-0" role="group" aria-label="Basic example">
                <a href="{{ route('showRoomUpdate', $room->room_id) }}" class="btn route-btn show-route-button w-50">
        <i class="fa-solid fa-pen-to-square"></i> Edit
</a>
        <form method="POST" action="{{ route('roomDelete', $room->room_id) }}" class="w-50">
        @csrf
    @method('DELETE')
    <button type="submit" class="btn  w-100 chat-btn"><i class="fa-solid fa-trash"></i> Delete</button>
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