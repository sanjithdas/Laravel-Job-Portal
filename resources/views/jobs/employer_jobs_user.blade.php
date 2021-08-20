@extends('layouts.main')
@section('content')
@auth
    <div class="container mb-5">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Applicant</th>
                                <th scope="col">Title</th>
                                {{-- <th scope="col">Experience</th>
{{--                                <th scope="col">Cover Letter</th>
{{--                                <th scope="col">Resume</th>--}}
                                <th scope="col">Contact</th>
                                <th scope="col">Date Applied</th>
                                <th scope="col">Profile</th>
                            </tr>
                            </thead>
                        <tbody>
            @foreach($jobs as $job)
                @foreach(App\Job::find($job->id)->users as $j)
                <tr>
                        <td>{{$j->name}}</td>
                        <td>{{$j->pivot->pivotParent->title}}</td>
                        {{-- <td>{{$j->profile->experience}}</td> --}}
{{--                        <td><a href="{{Storage::url($j->profile->cover_letter)}}">Cover Letter</a></td>--}}
{{--                        <td><a href="{{Storage::url($j->profile->resume)}}">Resume</a></td>--}}

                    <td><a href="tel:{{$j->profile->phone_number}}">{{$j->profile->phone_number}}</a></td>
                        {{-- <td>{{str_limit($j->pivot->pivotParent->description,50)}}</td> --}}
                        <td>{{$j->pivot->created_at->diffForHumans()}}</td>
                        <td><a href="{{ route('myjobs.user_profile',[$j,$job]) }}">View</a></td>

                </tr>
                @endforeach

            @endforeach
        </tbody>
        </table>

            </div>
          </div>
        </div>
        </div>
        </div>
@endauth
@endsection
