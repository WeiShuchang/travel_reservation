@extends('auth.base')

@section('page_title', 'Sign Up')

@section('content')


<section class="vh-80 bg-success">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 text-white">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="d-flex align-items-center h-custom-2  px-5 ms-xl-4 mt-1 pt-5 pt-xl-0 mt-xl-n5">

                    <form style="width: 23rem;" method="POST" action="{{ route('register') }}">
                        @csrf
                        <h3 class="fw-normal mb-1 pb-3" style="letter-spacing: 1px;">Sign Up</h3>

                        <div class="form-outline mb-2">
                            <input type="text" name="name" id="name" class="form-control form-control-lg" required />
                            <label class="form-label" for="email">Name</label>
                        </div>


                        <div class="form-outline mb-2">
                            <input type="email" name="email" id="email" class="form-control form-control-lg" required />
                            <label class="form-label" for="email">Email</label>
                        </div>

                        <div class="form-outline mb-2">
                            <input type="password" name="password" id="password" class="form-control form-control-lg" required />
                            <label class="form-label" for="password">Password</label>
                        </div>

                        <div class="form-outline mb-2">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" required />
                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                        </div>

                        <div class="pt-1 mb-4 bg-success">
                            <button class="btn btn-warning btn-lg px-5 me-sm-3" type="submit">Sign Up</button>
                        </div>

                        <p>Already have an account? <a href="{{ route('login') }}" class="link-info">Login here</a></p>

                    </form>

                </div>

            </div>
            <div class="col-sm-6 px-0 d-none d-sm-block">
                <img src="{{ asset('home/images/eluganbg.png') }}" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-success" id="features">
    <!-- Features section content -->
</section>

@endsection
