@extends('layouts.master')
@section('content')
	<div class="panel">
		<div class="panel-heading">
			<h3>Edit Data Pengguna</h3>
		</div>
		<div class="panel-body">
			@if(session('sukses'))
			<div class="alert alert-success">{{session('sukses')}}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@endif
			<div class="row">
				<form action="/user/{{$user->id}}/update" method="POST">
				{{csrf_field()}}
					<div class="form-group">
						<label for="exampleInputEmail1">Nama</label>
						<input name="name" type="text" name="" class="form-control" id="exampleInputEmail1" placeholder="Nama Pengguna" value="{{$user->name}}">
					</div>
					<div class="form-group">
						<label for="exampleFormControllSelect">Posisi</label>
						<select name="occupation" class="form-control">
							<option value="Admin" @if($user->occupation=='Admin') selected @endif>Admin</option>
							<option value="Kepala Puskesmas" @if($user->occupation=='Kepala Puskesmas') selected @endif>Kepala Puskesmas</option>
							<option value="Penanggungjawab Indikator" @if($user->occupation=='Penanggungjawab Indikator') selected @endif>Penganggungjawab Indikator</option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Email address</label>
						<input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="{{$user->email}}">
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Password</label>
						<input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="{{$user->password}}">
					</div>
					<button type="submit" class="btn btn-warning">Simpan</button>
				</form>				    
			</div>
		</div>
	</div>
		
@endsection