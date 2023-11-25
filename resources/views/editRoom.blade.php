@extends('layouts.app')

@section('content')
<div>
    @include('layouts.navbar')
    <div class="container">

        <div class="card my-5"> 
            <div class="card-header secondary-bg">
                <p class="fs-4 mb-0 fw-bold">{{ __('Edit Room') }} <sup> {{$room->room_id}}</sup></p> 
            </div> 
            <div class="card-body px-4">
                <form action="{{ route('roomUpdate', $room->room_id) }}" method="POST" enctype="multipart/form-data"> 
                    @csrf
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif 
                    <div class="form-group mb-3">
                        <label for="image">Select an Image:</label>
                        <input type="file" class="form-control-file" id="image1" name="image1" accept="image/*">
                    </div>
                    <div class="form-group mb-3">
                        <label for="image">Select an Image:</label>
                        <input type="file" class="form-control-file" id="image2" name="image2" accept="image/*">
                    </div>
                    <div class="form-group mb-3">
                        <label for="image">Select an Image:</label>
                        <input type="file" class="form-control-file" id="image3" name="image3" accept="image/*">
                    </div>
                    <div class="form-group mb-3">
                        <label for="image">Select an Image:</label>
                        <input type="file" class="form-control-file" id="image4" name="image4" accept="image/*">
                    </div>
                    <div class="form-group mb-3">
                        <label for="room_type">Room Type</label>
                        <select name="room_type" id="roomType" class="form-control" required>
                            <option value="Single" @if($room->room_type == 'Single') selected @endif>Single</option>
                            <option value="Double" @if($room->room_type == 'Double') selected @endif>Double</option>
                            <option value="Triple" @if($room->room_type == 'Triple') selected @endif>Triple</option>
                            <option value="Other" @if($room->room_type == 'Other') selected @endif>Other</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="amenities">Amenities</label><br>
                        <div class="d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" id="wifi" value="Wi-Fi" @if(in_array('Wi-Fi', explode(',', $room->amenities))) checked @endif>
                                <label class="form-check-label" for="wifi">Wi-Fi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" id="tv" value="TV" @if(in_array('TV', explode(',', $room->amenities))) checked @endif>
                                <label class="form-check-label" for="tv">TV</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" id="ac" value="Air Conditioning" @if(in_array('Air Conditioning', explode(',', $room->amenities))) checked @endif>
                                <label class="form-check-label" for="ac">Air Conditioning</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" id="water" value="24-hour Water" @if(in_array('24-hour Water', explode(',', $room->amenities))) checked @endif>
                                <label class="form-check-label" for="water">24-hour Water</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" id="electricity" value="24-hour Electricity" @if(in_array('24-hour Electricity', explode(',', $room->amenities))) checked @endif>
                                <label class="form-check-label" for="electricity">24-hour Electricity</label>
                            </div>
                        </div>                            
                    </div>
                    {{$room->amenities}}
                    <div class="form-group mb-3">
                        <label for="room_price">Room Price</label>
                        <input type="text" class="form-control" id="room_price" name="room_price" required value="{{$room->room_price}}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="availability_status">Availability Status</label>
                        <select name="availability_status" id="availability_status" class="form-control" required>
                            <option value="available" @if($room->availability_status == 'available') selected @endif>Available</option>
                            <option value="unavailable" @if($room->availability_status == 'unavailable') selected @endif>Unavailable</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end my-3">
                        <button type="submit" class="btn primary-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection