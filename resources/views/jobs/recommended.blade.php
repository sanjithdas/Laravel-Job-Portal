
@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Your Recommended jobs</div>

                    <div class="card-body">
                        <table class="table">
                            <th>Title</th>
                            <th>Position</th>
                            <th>Company</th>
                            <th>Type</th>
                            <th>Last Date</th>
                            <tbody>
                            @if (count($jobs)>0)
                                @foreach($jobs as $job)
                                    <tr>
                                        <td><a href="{{route('jobs.show',[$job->id,$job->slug])}}">{{ $job->title }}</a></td>
                                         <td><a href="{{route('jobs.show',[$job->id,$job->slug])}}">{{$job->position}}</a></td>
                                        <td>{{$job->company_id}}{{ \App\Company::find($job->company_id)->cname}}</td>
                                        <td><i class="fa fa-clock-o"aria-hidden="true"></i>&nbsp;{{$job->type}}</td>
                                        <td>{{ $job->last_date }}</td>
                                    </tr>
                                @endforeach
                            }
                            @else
                                @alert
                                @slot('class')
                                    alert-info
                                @endslot
                                    No recommended jobs found..
                                @endalert
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
