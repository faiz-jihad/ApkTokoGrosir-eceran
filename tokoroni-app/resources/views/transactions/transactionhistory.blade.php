@extends('layouts.app')
@section('content')

<h1>Riwayat Transaksi</h1>

<table>
<tr>
    <th>Tanggal</th><th>Kasir</th><th>Total</th>
</tr>
@foreach($transactions as $t)
<tr>
    <td>{{ $t->created_at }}</td>
    <td>{{ $t->user->name ?? '-' }}</td>
    <td>{{ number_format($t->total) }}</td>
</tr>
@endforeach
</table>

@endsection
