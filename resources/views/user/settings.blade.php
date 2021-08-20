@extends('layouts.main')
@section('content')
@auth
    <div class="container mt-5">
        <div class="card card-position">
            <div id="app">
                <div class="card-header text-center h4">
                    {{ $user->name }} {{$user->id}}

                    <div class="card-title h6">
                        {{ $user->email }}
                    </div>
                </div>
                <div class="border-bottom">
                    <div class="card-body  text-blue arrow">
                        Change Password
                    </div>

                    <div class="arrow-img mt-3">
                        <img class="main-div" id="changepass" src="{{asset('/uploads/arrows/down.jpg')}}" onclick="@{{showPassEdit()}}" width="20" height="20">
                    </div>
                    <div>
                        <password-reset-component    id="passreset" style="display: none" user="{{$user->name}}" email="{{$user->email}}" :userid="{{ $user->id }}">

                        </password-reset-component>
                    </div>
                </div>
                <div class="border-bottom">
                    <div class="card-body text-blue arrow">
                        Change Email
                    </div>
                    <div class="arrow-img mt-3">
                        <img  src="{{asset('/uploads/arrows/down.jpg')}}" id="changeemail" width="20" height="20" onclick="@{{emailEdit()}}">
                    </div>
                    <div>
                        <email-reset-component    id="emailreset" style="display: none" user="{{$user->name}}" email="{{$user->email}}" :userid="{{ $user->id }}">

                        </email-reset-component>
                    </div>
                </div>
                <div class="card-body border-bottom text-blue">
                    Delete my account
                </div>
            </div>
        </div>
        <br><br>
    </div>

<script  src="{{ asset('js/app.js') }}"  ></script>
    <script type="text/javascript">
        var showPassEdit =  function show(){
            var tagStyle = document.getElementById('passreset');
            if(tagStyle.style.display === "none") {
                tagStyle.style.display = "block";
                document.getElementById('changepass').src="{{asset('/uploads/arrows/down.jpg')}}"
            }
            else{
                tagStyle.style.display="none";
                document.getElementById('changepass').src="{{asset('/uploads/arrows/up.jpg')}}"
            }
        }
        var emailEdit =  function show(){
            var tagStyle = document.getElementById('emailreset');
            if(tagStyle.style.display === "none") {
                tagStyle.style.display = "block";
                document.getElementById('changeemail').src="{{asset('/uploads/arrows/down.jpg')}}"
            }
            else{
                tagStyle.style.display="none";
                document.getElementById('changeemail').src="{{asset('/uploads/arrows/up.jpg')}}"
            }
        }
    </script>
@elseauth
        @alert
            @slot('class')
                alert-warning
            @endslot
                Please login to update your profile settings
        @endalert
@endauth

@endsection
@section('css')
    <style>
        .card-position{
            margin: 0 auto;
            width: 400px;
        }
        .text-blue{
            color: #1d68a7;
            font-weight: bold;
        }
        .main-div{
            /*border: 2px solid crimson;*/
        }
        .arrow{
            display: inline-block;
       }
        .arrow-img{
            width:30%;
            float: right;
        }
    </style>
@endsection

