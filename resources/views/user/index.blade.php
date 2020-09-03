@extends('layouts.admin')
@section('content')
<div class="card">
	<div class="card-header primary-low">
		<h5 class="card-title">Contact List</h5>
	</div>
	<div class="card-body">
		{{--{!!link_to('user/create', $title = 'Register Contact',$attributes = [], $attributes = ['class'=>'btn primary'])!!}--}}
		<div class="table-responsive">
			<table class="table tablaNoOrder compact">
				<thead>
					<th>Fisrt Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Contact Number</th>
					<th>Edit</th>
					<th>Delete</th>
				</thead>
				<tbody>
					<tr>
						<td>{{$user->first_name}}</td>
						<td>{{$user->last_name}}</td>
						<td>{{$user->email}}</td>
						<td>{{$user->contact_number}}</td>
						<td>
							<a href="{{url('/user/'.$user->id.'/edit')}}">Edit</a>
						</td>
						<td>
							<form action="{{url('/user/'.$user->id)}}" method="post">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
								<button type="submit" onclick="return confirm('Delete?');">Delete</button>
							</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection