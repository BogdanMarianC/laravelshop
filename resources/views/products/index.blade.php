@extends('products.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Simple Products Management CRUD Application</h2>
        </div>
        <div class="col-lg-12 text-center" style="margin-top:10px;margin-bottom: 10px;">
            <a class="btn btn-success " href="{{ route('products.create') }}"> Add Product</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif
    @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    @if(sizeof($products) > 0)
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Price</th>
                <th width="280px">More</th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td><img src="{{ url('/') }}/images/{{ $product->photo }}" style="max-width: 200px;"></td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <form action="{{ route('products.destroy',$product->id) }}" method="POST">

                            <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <div class="alert alert-alert">Start Adding to the Database.</div>
    @endif

    {!! $products->links() !!}

@endsection