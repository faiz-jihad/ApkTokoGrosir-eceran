@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah User</h3>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="mb-2">
            <label>Nama</label>
            <input name="name" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Email</label>
            <input name="email" type="email" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Password</label>
            <input name="password" type="password" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Konfirmasi Password</label>
            <input name="password_confirmation" type="password" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="kasir">Kasir</option>
                <option value="owner">Owner</option>
            </select>
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
