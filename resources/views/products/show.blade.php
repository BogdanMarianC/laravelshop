@extends('products.layout')

@section('content')
    <h1>Product {{ $product->name }}</h1>


    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="jumbotron text-left">
                <p>
                    <strong>Name:</strong> {{ $product->name }}<br>
                    <strong>Description:</strong> {{ $product->description }}<br>
                    <strong>Price:</strong> {{ $product->price }}
                </p>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">

            <img src="{{ url('/') }}/images/{{ $product->photo }}" style="max-width: 200px;">
        </div>
    </div>
    <a href="{{ URL::previous() }}">Go Back</a>
@endsection