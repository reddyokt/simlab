@extends('dashboard.layouts.main')
@section('container')
<div>
            @if($errors->any())
            {!! implode('', $errors->all('<div style="color:red">:message</div>')) !!}
            @endif
            @if(Session::get('error') && Session::get('error') != null)
            <div style="color:red">{{ Session::get('error') }}</div>
            @php
            Session::put('error', null)
            @endphp
            @endif
            @if(Session::get('success') && Session::get('success') != null)
            <div style="color:green">{{ Session::get('success') }}</div>
            @php
            Session::put('success', null)
            @endphp
            @endif
</div>
<div class="container overflow-hidden">
    <div class="row gx-3">
        <div class="col-5 card w-50 mt-5 p-3">
            <div class="card-body">
                <h4>Data Akun</h4>
                @foreach ($data as $dt )
                <form class="form-inline" action="/profile" method="post">
                    @csrf
                    <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" value="{{ $dt->username }}" disabled>
                    </div>
                    <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" value="{{ $dt->nama_lengkap }}" name="nama_lengkap">
                    </div>
                    @endforeach
                    <button class="btn btn-md btn-primary mt-3" role="button">Ubah</button>
                </form>
            </div>
        </div>

        <div class="col-5 card w-50 mt-5 p-3">
            <div class="card-body">
                <h4>Ubah Password</h4>
                @foreach ($data as $dt )
                <form class="form-inline" action="/profile/password" method="post">
                    @csrf
                    <div class="form-group">
                    <label for="old_password">Password Lama</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" >
                    </div>
                    <div class="form-group">
                    <label for="new_password">Password baru </label>
                    <input type="password" class="form-control" id="new_password" name="new_password">
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">masukkan kembali Password baru </label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                    </div>
                    @endforeach
                    <button class="btn btn-md btn-primary mt-3" role="button">Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#example').DataTable();
});</script>
