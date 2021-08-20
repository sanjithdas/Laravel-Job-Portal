
@extends('layouts.main')
@section('content')
<div class="container mb-5">
    <h1>Jobs Applied by {{ Auth()->user()->name}}</h1>
    @foreach ($jobs as $job)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header  d-flex justify-content-between">
                        <div>
                                <a href="{{route('jobs.show',[$job->id,$job->slug])}}">{{ $job->title}}</a>
                        </div>
                        <div class="text-right" style="width:20%;">
                            
                         {{ date('F d, Y', strtotime($job->pivot->created_at))}} 
                        </div>
                    </div>
                    
                    <div class="card-body">
                        {{ $job->description}}
                    </div>
                </div>
            </div>
        </div>
    @endforeach    
</div>

@endsection


