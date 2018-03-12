@extends('layouts.app')

@section('content')
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h2 class="logo-name">NH</h2>
            </div>
            <h3>Welcome to Bantam</h3>
            {{--<p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.--}}
            {{--<!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->--}}
            {{--</p>--}}
            <p>Login in. To see it in action.</p>
            <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <input id="login" class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}" name="login" value="{{ old('login') }}" placeholder="Enter your Email or Employee Number" required autofocus>

                    @if ($errors->has('login'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                <a  href="{{ route('password.request') }}"><small>Forgot password?</small></a>
                {{--<p class="text-muted text-center"><small>Do not have an account?</small></p>--}}
                {{--<a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>--}}
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>
@endsection
