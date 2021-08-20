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
                                <th scope="col">Seeker Name</th>
                                <th scope="col">Cover Letter</th>
                                <th scope="col">Resume</th>
                            </tr>
                            </thead>
                        <tbody>

                <tr>
                    <td>{{$user->name}}</td>
                    <td><a href="/jobs/uploads/avatar/{{ $user->profile->cover_letter}}">Cover Letter</a></td>
                    <td><a href="/jobs/uploads/avatar/{{$user->profile->resume}}">Resume</a></td>
                </tr>

        </tbody>
        </table>

            </div>
          </div>
        </div>
        </div>
        </div>
@endauth
@endsection
