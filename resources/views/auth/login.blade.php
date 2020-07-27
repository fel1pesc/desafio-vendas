@extends('layouts.app')

@section('scripts-header')
    <style>
        body{
            background-color: yellow;
        }
    </style>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 offset-3 offset-4" style="margin-top: 10%;">
                <div class="login-box" style="border-radius: 20px;">
                    <div class="thumbnail" style="background-color: #eeeef4; border-radius: 13px; margin-bottom: 0; padding: 15px">
                        <div class="row">
                            <div class="col-md-10 offset-1" style="margin-top: 10px;">
                                <div class="login-form">
                                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                                        {{ csrf_field() }}

                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input placeholder="Email" id="email" type="email"  class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input placeholder="Senha" id="password" type="password" class="form-control" name="password" required>

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-8 col-xs-offset-2 offset-0 col-md-12">
                                                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                                                        Login
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop