
@extends('layouts.main')
@section('content')
<div class="container">
<h1>User Applied for   {{$job->title}}</h1><span style="float:right"><a href="/dashboard/jobs">Back</a></span>
	  @if(Session::has('message'))

          <div class="alert alert-success">{{Session::get('message')}}</div>
          @endif

	<div class="row">
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
                {{$job->title}}
		</div>
		<div class="card-body">

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">User Name</th>
      <th scope="col">Email</th>
      <th>Phone</th>
      <th>Address</th>
      <th scope="col">Dob</th>
      <th scope="col">Experience</th>
      <th scope="col">Bio</th>
      <th scope="col">Cover Letter</th>
      <th scope="col">Resume</th>
    </tr>
  </thead>
  <tbody>
        @if ($job->users->count() > 0)
  	  	@foreach($job->users  as $jobuser )

    <tr>
      <th scope="row">{{ $jobuser->name}}</th>
      <td>{{$jobuser->email}}</td>
      <td>{{$jobuser->profile->phone_number}}</td>
      <td>{{$jobuser->profile->address}}</td>
      <td>{{$jobuser->profile->dob}}</td>
      <td>{{$jobuser->profile->experience}}</td>
      <td>{{$jobuser->profile->bio}}</td>

      <td><a href="{{Storage::url($jobuser->profile->cover_letter)}}" >Cover Letter</a></td>
      <td><a href="{{Storage::url($jobuser->profile->resume)}}" >Resume</a></td>
      
    </tr>
      @endforeach
@endif
  </tbody>
</table>

{{-- {{$jobs->links()}} --}}
		</div>
	</div>
</div>

</div>
</div>

@endsection


