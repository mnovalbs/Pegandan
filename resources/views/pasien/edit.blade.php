@extends('layouts.master')
@section('content')
	<div class="main">
		<div class="main-content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="panel">
							<div class="panel-heading">
								<h3>Edit Data Pasien</h3>
							</div>
							<div class="panel-body">
								@if(session('sukses'))
								<div class="alert alert-succes"> {{session('sukses')}}
									<button type="button" class="close" data-dismiss="alert" aria-label="close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								@endif
								<div class="row">
									<form action="/pasien/{{$pasien->id_pasien}}/update" method="POST">
									{{csrf_field()}}
										<div class="form-group">
											<label for="exampleInputEmail">Nama</label>
											<input type="text" name="" class="form-control" id="exampleInputEmail" placeholder="Nama Pasien" value="{{$pasien->nama_pasien}}">
										</div>
										
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection