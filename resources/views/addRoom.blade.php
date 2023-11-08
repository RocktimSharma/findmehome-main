@extends('layouts.app')

@section('content')
<div>
    @include('layouts.navbar')
    <div class="container">

        <div class="card my-5"> <div class="card-header secondary-bg">
            <p class="fs-4 mb-0 fw-bold">{{ __('Add Room') }}</p> </div> <div class="card-body px-4">
            <form action="/room/store/{{ $pg_id }}" method="POST" enctype="multipart/form-data"> @csrf
                @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif <div
                class="form-group mb-3">
                <label for="image">Select an Image:</label>
                <input type="file" class="form-control-file" id="image1" name="image1" accept="image/*" required>
        </div>
        <div class="form-group mb-3">
            <label for="image">Select an Image:</label>
            <input type="file" class="form-control-file" id="image2" name="image2" accept="image/*" required>
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
                <option value="Single">Single</option>
                <option value="Double">Double</option>
                <option value="Triple">Triple</option>
                <option value="Other">Other</option>

            </select>
        </div>

        <div class="form-group mb-3">
            <label for="amenities">Amenities</label><br>
            <div class="d-flex justify-content-between">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="amenities[]" id="wifi" value="Wi-Fi">
                <label class="form-check-label" for="wifi">Wi-Fi</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="amenities[]" id="tv" value="TV">
                <label class="form-check-label" for="tv">TV</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="amenities[]" id="ac" value="Air Conditioning">
                <label class="form-check-label" for="ac">Air Conditioning</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="amenities[]" id="water" value="24-hour Water">
                <label class="form-check-label" for="water">24-hour Water</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="amenities[]" id="electricity"
                    value="24-hour Electricity">
                <label class="form-check-label" for="electricity">24-hour Electricity</label>
            </div>

</div>            <!-- Add more amenities as needed -->
        </div>


        <div class="form-group mb-3">
            <label for="room_price">Room Price</label>
            <input type="text" class="form-control" id="room_price" name="room_price" required>
        </div>

        <div class="form-group mb-3">
            <label for="availability_status">Availability Status</label>
            <select name="availability_status" id="availability_status" class="form-control" required>
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
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