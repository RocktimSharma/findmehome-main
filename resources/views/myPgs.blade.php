@extends('layouts.app')

@section('content')
<div>
@include('layouts.navbar')


<div class="container">
    <div class="d-flex justify-content-between align-items-center">
    <p class="fs-2 fw-bold mt-3">Your PGs</p>
    <a href="{{route('addPg')}}" class="btn primary-btn">Add PG</a>
</div>
    <table id="yourPgsTable" class="table datatable table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Serial No</th>
            <th>Name</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Add</th>
        </tr>
    </thead>
    <tbody>
    @if (count($pgs) > 0)
        @php
            $serialNo = 1; // Initialize the serial number
        @endphp
        @foreach ($pgs as $pg)
            <tr>
                <td>{{ $serialNo++ }}</td> <!-- Display and increment the serial number -->
                <td><a href="/pg/{{$pg->pg_id}}/rooms">{{ $pg->name }}</a></td>
                <td><a href=''>Edit</a></td>
                <td> <form action="{{ route('pgDelete', $pg->pg_id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn primary-btn"><i class="fa-solid fa-trash"></i> Delete</button>
</form></td>
                <td><a href='/room/create/{{ $pg->pg_id }}'>Add Room</a></td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>



</div>
</div>



@endsection