@extends('layouts.app')
@section('content')
    <h1>Dashboard Gudang</h1>

    <h3>Stok Menipis</h3>
    <ul>
        @foreach ($lowStock as $p)
            <li>{{ $p->name }} ({{ $p->stock }})</li>
        @endforeach
    </ul>
@endsection
