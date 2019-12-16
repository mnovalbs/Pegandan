@extends('layouts.master')
@section('content')
	<div class="panel">
		<div class="panel-heading">
			<h3 class="panel-title">Data Pengguna</h3>
		</div>
		<div class="panel-body">
			<button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal">
				Tambah Pengguna
			</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="/user/create" method="POST">
								{{csrf_field()}}
								<div class="form-group">
									<label for="exampleInputEmail1">Nama</label>
									<input name="name" type="text" name="" class="form-control" id="exampleInputEmail1" placeholder="Nama Pengguna">
								</div>
								<div class="form-group">
									<label for="exampleFormControllSelect">Posisi</label>
									<select name="occupation" class="form-control" placeholder="Posisi">
										<option value="">Pilih Posisi</option>
										<option value="Admin">Admin</option>
										<option value="Kepala Puskesmas">Kepala Puskesmas</option>
										<option value="Penanggungjawab Indikator">Penganggungjawab Indikator</option>
									</select>
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1">Email address</label>
									<input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
									<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Password</label>
									<input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
								</div>
								<button type="submit" class="btn btn-primary">Submit</button>
							</form>
						</div>				      
					</div>
				</div>
			</div>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama</th>
						<th>Posisi</th>
						<th>Email</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($data_user as $user)
					<tr>
						<td>{{$user->id}}</td>
						<td>{{$user->name}}</td>
						<td>{{$user->occupation}}</td>
						<td>{{$user->email}}</td>
						<td>
							<a href="/user/{{$user->id}}/edit" class="btn btn-warning btn-sm"><i class="lnr lnr-pencil"></i></a>
						</td>
						<td>
							<a href="/user/{{$user->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><i class="lnr lnr-trash"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table></div>
		</div>
	</div>
	@stop
	@section('content1')
	@if(session('sukses'))
	<div class="alert alert-success">{{session('sukses')}}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif
	<div class="row">
		<div class="col-6">
			<h2>Data Pengguna</h2>
		</div>
		<div class="col-6">
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal">
				Tambah Pengguna
			</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="/user/create" method="POST">
								{{csrf_field()}}
								<div class="form-group">
									<label for="exampleInputEmail1">Nama</label>
									<input name="name" type="text" name="" class="form-control" id="exampleInputEmail1" placeholder="Nama Pengguna">
								</div>
								<div class="form-group">
									<label for="exampleFormControllSelect">Posisi</label>
									<select name="occupation" class="form-control" placeholder="Posisi">
										<option value="">Pilih Posisi</option>
										<option value="Admin">Admin</option>
										<option value="Kepala Puskesmas">Kepala Puskesmas</option>
										<option value="Penanggungjawab Indikator">Penganggungjawab Indikator</option>
									</select>
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1">Email address</label>
									<input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
									<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Password</label>
									<input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
								</div>
								<button type="submit" class="btn btn-primary">Submit</button>
							</form>
						</div>				      
					</div>
				</div>
			</div>
		</div>
		<table class="table table-hover">
			<tr>
				<th>No.</th>
				<th>Nama</th>
				<th>Posisi</th>
				<th>Email</th>
				<th></th>
			</tr>
			@foreach ($data_user as $user)
			<tr>
				<td>{{$user->id}}</td>
				<td>{{$user->name}}</td>
				<td>{{$user->occupation}}</td>
				<td>{{$user->email}}</td>
				<td>
					<a href="/user/{{$user->id}}/edit" class="btn btn-warning btn-sm">edit</a>
				</td>
				<td>
					<a href="/user/{{$user->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">delete</a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	@endsection



