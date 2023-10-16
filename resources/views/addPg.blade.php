@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add PG/Hostel</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/add-pg">
        @csrf

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

 
     

        <input type="hidden" id="latitude" name="latitude" value="">
        <input type="hidden" id="longitude" name="longitude" value="">

        <div class="form-group">
            <label for="contact_details">Contact Details:</label>
            <input type="text" class="form-control" id="contact_details" name="contact_details" required>
        </div>

        <div class="form-group">
            <label for="amenities">Amenities:</label>
            <textarea class="form-control" id="amenities" name="amenities" required></textarea>
        </div>

        <div class="form-group">
            <label for="rules_restrictions">Rules & Restrictions:</label>
            <textarea class="form-control" id="rules_restrictions" name="rules_restrictions" required></textarea>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>

        <div class="form-group">
            <label for="other_details">Other Details:</label>
            <textarea class="form-control" id="other_details" name="other_details" required></textarea>
        </div>
      
        <div class="form-group">
            <label for="map">Location:</label>
            <div id="map" style="height: 300px;"></div>
        </div>
       

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>



@endsection