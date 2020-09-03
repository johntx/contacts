@extends('layouts.admin')
@section('content')
<div class="card">
	<div class="card-header primary-low">
		<h5 class="card-title">Contact List</h5>
	</div>
	<div class="card-body">
		{{--{!!link_to('admin/contacts/create', $title = 'Register Contact',$attributes = [], $attributes = ['class'=>'btn primary'])!!}--}}
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
					@foreach($contacts as $contact)
					<tr>
						<td>{{$contact->first_name}}</td>
						<td>{{$contact->last_name}}</td>
						<td>{{$contact->email}}</td>
						<td>{{$contact->contact_number}}</td>
						<td>
							<a class="btn primary" href="{{url('/admin/contacts/'.$contact->id.'/edit')}}">Edit</a>
						</td>
						<td>
							<form action="{{url('/admin/contacts/'.$contact->id)}}" method="post">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
								<button type="submit" class="btn-min danger" onclick="return confirm('Delete?');">Delete</button>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
{!!$contacts->render()!!}
@endsection