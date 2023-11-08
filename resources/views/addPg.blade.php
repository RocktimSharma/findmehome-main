@extends('layouts.app')

@section('content')
<div>
    @include('layouts.navbar')

    <div class="container">
    <div class="card my-5">   
    <div class="card-header secondary-bg">
    <p class="fs-4 mb-0 fw-bold">{{ __('Add PG') }}</p>       
</div>
<div class="card-body">
    <form method="POST" action="/add-pg" enctype="multipart/form-data">
         @csrf 
      
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
       

        <div class="form-group mb-3">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>




        <input type="hidden" id="latitude" name="latitude" value="">
        <input type="hidden" id="longitude" name="longitude" value="">

        <div class="form-group mb-3">
            <label for="contact_details">Contact Details:</label>
            <input type="text" class="form-control" id="contact_details" name="contact_details" required>
        </div>


        <div class="form-group mb-3">
            <label for="rules_restrictions">Rules & Restrictions:</label>
            <textarea class="form-control" id="rules_restrictions" name="rules_restrictions" required></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>

   

        <div class="form-group mb-3">
            <label for="map">Location:</label>
            <div id="map" style="height: 300px;"></div>
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