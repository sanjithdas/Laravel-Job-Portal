<?php
// use Symfony\Component\Routing\Route;
//$currentRoute = {{Route::currentRouteName()}};
//echo 'sdfsdfd'. $currentRoute;

?>

<div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->

    <div class="site-navbar-wrap js-site-navbar bg-white">

      <div class="container">
        <div class="site-navbar bg-light">
          <div class="py-1">
            <div class="row align-items-center">
              <div class="col-2">
                <h2 class="mb-0 site-logo"><a  href="/jobs">Jobs<strong class="font-weight-bold">4U</strong> </a></h2>
              </div>
              <div class="col-10">
                  <nav class="site-navigation text-right" role="navigation">
                      <div class="container">
                        <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

                        <ul class="site-menu js-clone-nav d-none d-lg-block">
                           @if(!Auth::check())
                          <li><a type="button" style="color:green;" class="btn btn-light  p-2" href="/jobs/register"><b>For Job seeker</b></a></li>
                          <li>
                            <a type="button" style="color:green;" class="btn btn-light p-2" href="{{route('employer.register')}}"><b>For Employer</b></a>

                          </li>
                          @else
                          <li><a type="button" style="color:green;" class="btn btn-light   p-2" href="{{route('home')}}"><b>Dashboard</b></a></li>
                          @endif
                            <li><a type="button"  style="color:green;" class="btn btn-light   p-2" href="{{route('company')}}"><b>Company</b></a></li>
                            <li>
                                @if(!Auth::check())
                                      <a  type="button" style="color:green;" class="btn btn-light  p-2" href="{{route('login')}}" >
                                       <!--   <a  type="button" style="color:green;" class="btn btn-light  p-2" href="{{route('login')}}" data-toggle="modal" data-target="#exampleModal"> -->
                                    <b>Login</b>
                                      </a>
                                    <li><a type="button" style="color:green;" class="btn btn-light p-2" href="{{ route('social.auth', ['provider' => 'github'])}}" style="color:#fff"><b>Login using GitHub</b> </a></li>
                                @else
                                <li class="nav-item dropdown">
                                    <div id="navbarDropdown" class="nav-link dropdown-toggle"  role="button" data-toggle="dropdown"  v-pre>

                                        @if (Auth::user()->user_type=='employer')
                                        <a type="button" style="color:green;" class="btn btn-light p-2"><b>{{ Auth::user()->company->cname }}</b></a><span class="caret"></span>
                                        @else
                                        <a type="button" style="color:green;" class="btn btn-light p-2"><b>{{ Auth::user()->name }}</b></a><span class="caret"></span>
                                        @endif

                                      </div>
                                    <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdown">
                                        @if (Auth::user()->user_type=='employer')
                                          <a class="dropdown-item" href="{{ route('company.view') }}">
                                              {{ __('Company Profile') }}
                                          </a>
                                          <a class="dropdown-item" href="{{ route('job.create') }}">
                                              {{ __('Post a Job') }}
                                          </a>
                                          <a class="dropdown-item" href="{{ route('job.my') }}">
                                              {{ __('Current Jobs') }}
                                          </a>
                                          <a class="dropdown-item" href="{{ route('myjobs.applied') }}">
                                              {{ __('Users Applied ') }}
                                          </a>
                                          <a class="dropdown-item" href="{{ route('my.settings', Auth()->user()) }}">
                                            {{ __('Settings') }}
                                          </a>
                                        @elseif (Auth::user()->user_type=='seeker')
                                          <a class="dropdown-item" href="{{ route('user.profile') }}">
                                              {{ __('My Profile') }}
                                          </a>
                                          {{-- <a class="dropdown-item" href="{{ route('jobs.list') }}">
                                              {{ __('Current Jobs') }}
                                          </a>   --}}
                                          <a class="dropdown-item" href="{{ route('home') }}">
                                              {{ __('Saved Jobs') }}
                                          </a>
                                          <a class="dropdown-item" href="{{ route('jobs.applied', Auth()->user()) }}">
                                                {{ __('Jobs Applied') }}
                                          </a>
                                          <a class="dropdown-item" href="{{ route('my.job.recommended', Auth()->user()) }}">
                                            {{ __('Recommended Jobs') }}
                                          </a>
                                          <a class="dropdown-item" href="{{ route('my.settings', Auth()->user()) }}">
                                            {{ __('Settings') }}
                                          </a>

                                        @endif

                                      <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">
                                         {{ __('Logout') }}
                                     </a>

                                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                         @csrf
                                     </form>

                                    </div>
                                </li>
                                @endif

                            </li>

                        </ul>
                      </div>
                    </div>
                  </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

  <!--modal-->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">



    <form method="POST" action="{{ route('login') }}" >
    @csrf

    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

        <div class="col-md-12">
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

        <div class="col-md-12">
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">


                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>





  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
    </button>
  </div>
  </form>

      </div>
    </div>
  </div>
</div>
<script>
  function test(){
    alert('dfgfd');
   alert(document.getElementById('dropdownMenu'));
   var x = document.getElementById("dropdownMenu").getAttribute("aria-expanded");
   alert(x)
   x=true;
   alert(x)
  document.getElementById("dropdownMenu").setAttribute("aria-expanded", x);
  //document.getElementById("p2").innerHTML = "aria-expanded =" + x;

  }
</script>
@if (empty(Route::currentRouteName()))

    <script type="text/javascript">
        @if (count($errors) > 0)
            $(document).ready(function(){
                $('#exampleModal').modal('show');
            })
        @endif
    </script>

@endif
