@extends('admin.template.template')
@section('content')
    @parent
@section('page_name', $page_name)
    <div class="box">
        <form action="" method="POST">
            @csrf
            @method($method)
            {{-- username last email --}}
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Username</label>
                        <div class="control has-icons-left">
                            <input type="text" name="username" class="input" placeholder="username">
                            <span class="icon is-left has-text-primary">
                                <i class="fa fa-user"></i>
                            </span>
                            @error('username')
                                <span class="help is-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left">
                            <input type="email" name="email" class="input" placeholder="email">
                            <span class="icon is-left has-text-primary">
                                <i class="fa fa-envelope"></i>
                            </span>
                            @error('email')
                                <span class="help is-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            {{-- password password confirmation --}}
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Passsword</label>
                        <div class="control has-icons-left">
                            <input type="password" name="password" class="input" placeholder="password">
                            <span class="icon is-left has-text-primary">
                                <i class="fa fa-key"></i>
                            </span>
                            @error('password')
                                <span class="help is-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Password Confirmation</label>
                        <div class="control has-icons-left">
                            <input type="password" name="password_confirmation" class="input"
                                placeholder="password confirmation">
                            <span class="icon is-left has-text-primary">
                                <i class="fa fa-key"></i>
                            </span>
                            @error('password_confirmation')
                                <span class="help is-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            {{-- firstname last name --}}
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">First Name</label>
                        <div class="control has-icons-left">
                            <input type="text" name="employee_first_name" class="input" placeholder="first name">
                            <span class="icon is-left has-text-primary">
                                <i class="fa fa-user"></i>
                            </span>
                            @error('employee_first_name')
                                <span class="help is-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Last Name</label>
                        <div class="control has-icons-left">
                            <input type="text" name="employee_last_name" class="input" placeholder="last name">
                            <span class="icon is-left has-text-primary">
                                <i class="fa fa-user"></i>
                            </span>
                            @error('employee_last_name')
                                <span class="help is-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            {{-- gender dob --}}
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">First Name</label>
                        <div class="control">
                            <input type="radio" name="employee_gender" class="is-checkradio" placeholder="first name"
                                value="M" id="gender_male">
                            <label for="gender_male">Male</label>
                            <input type="radio" name="employee_gender" class="is-checkradio" placeholder="first name"
                                value="F" id="gender_female">
                            <label for="gender_female">Female</label>

                            @error('employee_gender')
                                <span class="help is-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Date Of Birth</label>
                        <div class="control">
                            <input type="date" name="employee_dob">
                            @error('employee_dob')
                                <span class="help is-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            {{-- hire date --}}
            <div class="field">
                <label class="label">Hire Date</label>
                <div class="control">
                    <input type="date" name="employee_hire_date">
                    @error('employee_hire_date')
                        <span class="help is-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button class="button is-primary is-fullwidth has-text-weight-bold">Create</button>
        </form>
    </div>
@endsection

@section('script')
    @parent
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Initialize all input of type date
            let calendars = bulmaCalendar.attach('[type="date"]');
        });

    </script>
@endsection
