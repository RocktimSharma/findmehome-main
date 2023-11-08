@extends('layouts.app')

@section('content')

<div class=""> 
  <!-- Modal --> 
<div class="modal fade" id="exampleModal" tabindex="-1"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl"> 
    <div class="modal-content"> 
      <div class="modal-header"> 
        <h1 class="modal-title fs-5" id="exampleModalLabel">Location</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div> <div class="modal-body"> <div id="map">
  </div>
  </div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
  Close</button>
  <button type="button" class="btn btn-primary">Save changes</button> </div> </div>
    </div> 
  </div> 
  @include('layouts.navbar')


<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('images/1.jpg') }}" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('images/2.jpg') }}" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('images/3.jpg') }}" class="d-block w-100" alt="...">
    </div>
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


<div class="container-fluid content-box"  >
 
<p class="fs-3 fw-bold m-5 mb-0">PGs Avialable near you</p>
<div class="container-fluid px-5 mt-4">
  <div class="row">
    <div class="col-md-2 mb-4 filter-box py-4">
      <form id="filterForm" method="GET">
        <div class="form-group mb-3">
          <label for="minRoomPrice">Minimum Room Price:</label>
          <input type="number" name="minRoomPrice" id="minRoomPrice" class="form-control">
        </div>

        <div class="form-group mb-3">
          <label for="maxRoomPrice">Maximum Room Price:</label>
          <input type="number" name="maxRoomPrice" id="maxRoomPrice" class="form-control">
        </div>

     

        <div class="form-group mb-3">
          <label>Room Type</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="roomType[]" value="Single" id="single">
            <label class="form-check-label" for="single">Single</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="roomType[]" value="Double" id="double">
            <label class="form-check-label" for="double">Double</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="roomType[]" value="" id="other">
            <label class="form-check-label" for="other">Other</label>
          </div>
        </div>

        <div class="form-group mb-3">
          <label>Amenities</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="amenities[]" value="Wi-Fi" id="wifi">
            <label class="form-check-label" for="wifi">Wi-Fi</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="amenities[]" value="TV" id="tv">
            <label class="form-check-label" for="tv">TV</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="amenities[]" value="Air Conditioning" id="ac">
            <label class="form-check-label" for="ac">Air Conditioning</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="amenities[]" value="24-hour Water" id="ac">
            <label class="form-check-label" for="ac">24-hour Water</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="amenities[]" value="24-hour Electricity" id="ac">
            <label class="form-check-label" for="ac">24-hour Electricity</label>
          </div>
        </div>
        <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Apply Filters</button>
</div>
      </form>

    </div>
    <div class="col-sm-10 mb-4 pg-box">

      <div class="row" id="pgList">


      </div>
    </div>
  </div>
</div>

</div>
</div>

@endsection