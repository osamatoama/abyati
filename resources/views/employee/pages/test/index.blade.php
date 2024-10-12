@extends('employee.layouts.master')

@section('title', 'Test')

@section('content')

@endsection

@push('afterScripts')
    <script>
        let screenWidth = window.innerWidth;
        let screenHeight = window.innerHeight;

        alert("Screen width: " + screenWidth + "px" + "\n" + "Screen height: " + screenHeight + "px");
    </script>
@endpush
