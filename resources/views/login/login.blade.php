@extends('template.template')
@section('content')
    <div class="hero has-background-primary is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="columns">
                    <div class="column is-offset-one-quarter is-half">
                        <div class="box">
                            <div class="block has-text-centered">
                                <span class="is-size-2 has-text-weight-bold">Task Divider</span>
                            </div>
                            <form action="" method="post">
                                @csrf
                                <div class="field">
                                    <label class="label">E-mail</label>
                                    <div class="control has-icons-left">
                                        <input type="email" name="email" class="input" value="{{ old('email') }}">
                                        <span class="icon is-small is-left has-text-primary">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        @error('email')
                                            <span class="help is-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Password</label>
                                    <div class="control has-icons-left ">
                                        <input type="password" name="password" class="input">
                                        <span class="icon is-small is-left has-text-primary">
                                            <i class="fas fa-key"></i>
                                        </span>
                                        @error('password')
                                            <span class="help is-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="block">
                                    <button class="button is-fullwidth is-primary has-text-weight-bold">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
