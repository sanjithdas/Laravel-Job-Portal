@extends('layouts.main')
@section('content')

<div class="container">
	<h2>Companies</h2>
	<div class="row">
		@foreach($companies as $company)
		<div class="col-md-3 col-sm-12">

			<div class="card">
				@if(empty($company->logo))

				<img width="100" src="{{asset('avatar/man.jpg')}}"class="card-img-top">

				@else
				<img width="100" src="{{asset('uploads/logo')}}/{{$company->logo}}"class="card-img-top">


				@endif
				<div class="card-body">
					<h5 class="card-title text-center">{{$company->cname}}</h5>
					
					<center><a href="{{route('company.index',[$company->id,$company->slug])}}" class="btn btn-primary">View Company</a></center>
  				</div>
			</div>

		</div>
		@endforeach

	</div>
	<br><br><br>
			{{$companies->links()}}

</div>
@endsection
@section('css')
<style>
	@media only screen and (max-width: 480px){
	.col-sm-x{
		border:2px solid green !important;
		-webkit-box-flex: 0 !important;
		-ms-flex: 0 0 100% !important;
		flex: 0 0 100% !important;
		max-width: 100% !important;
	}
	@media screen and (max-width: 700px) and (min-width: 400px) { 
    .colsm-x { border:2px solid red !important; }
}
}
</style>

@endsection
