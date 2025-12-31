@extends('layouts.app')
@section('content')

<h1>Edit Barang</h1>

<form method="POST" action="{{ route('products.update',$product) }}">
@csrf
@method('PUT')
<input name="name" value="{{ $product->name }}">
<input name="code" value="{{ $product->code }}">
<input name="stock" value="{{ $product->stock }}">
<input name="price" value="{{ $product->price }}">
<button>Update</button>
</form>

@endsection
