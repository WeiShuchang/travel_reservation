@extends('auth.base')

@section('page_title', 'Log-in')

@section('content')

<section class="vh-80 bg-success">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 text-white">

            @if(session('success'))
                <div class="alert alert-success" role="alert" id="alert-message">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('success_logout'))
                <div class="alert alert-success" role="alert" id="alert-message">
                    {{ session('success_logout') }}
                </div>
            @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                    <form style="width: 23rem;" method="POST" action="{{ route('login') }}">
                        @csrf
                        <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>

                        <div class="form-outline mb-4">
                            <input type="text" name="email" id="email" class="form-control form-control-lg" required/>
                            <label class="form-label" for="email">Email</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="password" name="password" id="password" class="form-control form-control-lg" required/>
                            <label class="form-label" for="password">Password</label>
                        </div>

                        <div class="pt-1 mb-4 bg-success">
                            <button class="btn btn-success btn-lg px-5 me-sm-3" type="submit">Login</button>
                        </div>

                        <p>Don't have an account? <a href="{{ route('register') }}" class="link-info">Register here</a></p>

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

<script>
    // Ensure the DOM is loaded before accessing elements
    document.addEventListener("DOMContentLoaded", function() {
        // Get the alert message element
        let alertMessage = document.getElementById("alert-message");
        
        // Set timeout to hide the alert after 5000 milliseconds (5 seconds)
        setTimeout(function() {
            // Hide the alert by changing its display style to "none"
            alertMessage.style.display = "none";
        }, 4000); 
    });
</script>

@endsection
