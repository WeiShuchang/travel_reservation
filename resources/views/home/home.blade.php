@extends('home.base')

@section('page_title', 'homepage')

@section('content')

<main class="flex-shrink-0 bg-success">
    <!-- Navigation-->
@if (session('messages'))
    <div class="alert alert-success" role="alert" id="alert-message">
        @foreach (session('messages') as $message)
            <li @if ($message->tags) class="{{ $message->tags }}" @endif>{{ $message }}</li>
        @endforeach
    </div>
@endif

    <!-- Header-->
    <header class="bg-success py-5">
        <div class="container px-5">
            <div class="row gx-5 align-items-center justify-content-center">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="my-5 text-center text-xl-start">
                        <h1 class="display-1 fw-bolder text-yellow mb-2">E-LUGAN: </h1>
                        <p class="lead fw-normal text-white-50 mb-4">Web-Based Travel Reservation and Vehicle Management System</p>
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                            <a class="btn btn-success btn-lg px-4 me-sm-3" href="#features">Explore</a>
                            <a class="btn btn-outline-light btn-lg px-4" href="/login">Log-in</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="{{asset('home/images/eluganbg.png')}}" alt="..." /></div>
            </div>
        </div>
    </header>
    <!-- Features section-->
    <section class="py-5 bg-success" id="features">
        <div class="container px-5 my-5 ">
            <div class="row gx-5">
                <div class="col-lg-4 mb-5 mb-lg-0"><h2 class="fw-bolder mb-0  text-yellow">E-Lugan Features:</h2></div>
                <div class="col-lg-8">
                    <div class="row gx-5 row-cols-1 row-cols-md-2">

                        <div class="col mb-5 h-100">
                            <div class="feature bg-success bg-gradient text-white rounded-3 mb-3"><i class="bi bi-calendar-check"></i></div>
                            <h2 class="h2 text-yellow">Travel Reservation</h2>
                            <p class="h5 mb-0 text-white" >BSU Employees can reserve a vehicle online</p>
                        </div>

                        <div class="col mb-5 h-100">
                            <div class="feature bg-success bg-gradient text-white rounded-3 mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bus-front-fill" viewBox="0 0 16 16">
                                <path d="M16 7a1 1 0 0 1-1 1v3.5c0 .818-.393 1.544-1 2v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5V14H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2a2.5 2.5 0 0 1-1-2V8a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1V2.64C1 1.452 1.845.408 3.064.268A44 44 0 0 1 8 0c2.1 0 3.792.136 4.936.268C14.155.408 15 1.452 15 2.64V4a1 1 0 0 1 1 1zM3.552 3.22A43 43 0 0 1 8 3c1.837 0 3.353.107 4.448.22a.5.5 0 0 0 .104-.994A44 44 0 0 0 8 2c-1.876 0-3.426.109-4.552.226a.5.5 0 1 0 .104.994M8 4c-1.876 0-3.426.109-4.552.226A.5.5 0 0 0 3 4.723v3.554a.5.5 0 0 0 .448.497C4.574 8.891 6.124 9 8 9s3.426-.109 4.552-.226A.5.5 0 0 0 13 8.277V4.723a.5.5 0 0 0-.448-.497A44 44 0 0 0 8 4m-3 7a1 1 0 1 0-2 0 1 1 0 0 0 2 0m8 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m-7 0a1 1 0 0 0 1 1h2a1 1 0 1 0 0-2H7a1 1 0 0 0-1 1"/>
                              </svg></div>
                            <h2 class="h2  text-yellow">Car Management</h2>
                            <p class="h5 mb-0  text-white">Exclusive for BSU Motorpool Staff</p>
                        </div>

                        <div class="col mb-5 mb-md-0 h-100">
                            <div class="feature bg-success bg-gradient text-white rounded-3 mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-car-front" viewBox="0 0 16 16">
                                <path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.731c.91-.073 2.35-.17 3.597-.17s2.688.097 3.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 10.691 4H5.309a.5.5 0 0 0-.447.276"/>
                                <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM4.82 3a1.5 1.5 0 0 0-1.379.91l-.792 1.847a1.8 1.8 0 0 1-.853.904.8.8 0 0 0-.43.564L1.03 8.904a1.5 1.5 0 0 0-.03.294v.413c0 .796.62 1.448 1.408 1.484 1.555.07 3.786.155 5.592.155s4.037-.084 5.592-.155A1.48 1.48 0 0 0 15 9.611v-.413q0-.148-.03-.294l-.335-1.68a.8.8 0 0 0-.43-.563 1.8 1.8 0 0 1-.853-.904l-.792-1.848A1.5 1.5 0 0 0 11.18 3z"/>
                              </svg></div>
                            <h2 class="h2 text-yellow">Car Inventory</h2>
                            <p class="h5 mb-0  text-white">View List of Vehicles Available</p>
                        </div>

       

                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="centering-div">
        <div class="logo">
            <img src="{{ asset( 'home/images/elugan.png') }}" width="150px" height="150px" alt="elugan-logo">
        </div>
    </div>


    <!-- Blog preview section-->
    <section class="py-5 bg-success">
        <div class="container px-5 ">

            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="text-center">
                        <h2 class="fw-bolder text-yellow">About The System</h2>
                        <p class="lead fw-normal text-white mb-5 ">The ELugan Travel Reservation and Vehicle Management System is a project designed for BSU Motorpool Automotive Services </p>
                    </div>
                </div>
            </div>

            <div class="row gx-5">

                <div class="col-lg-4 mb-5">
                    <div class=" card h-100 shadow border-0">
                        <img class="card-img-top" src="https://dummyimage.com/600x350/ced4da/6c757d" alt="..." />
                        <div class="card-body p-4">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2">News</div>
                            <a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3">Blog post title</h5></a>
                            <p class="card-text mb-0">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                        <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                            <div class="d-flex align-items-end justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                                    <div class="small">
                                        <div class="fw-bold">Kelly Rowan</div>
                                        <div class="text-muted">March 12, 2023 &middot; 6 min read</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-5 ">
                    <div class="card h-100 shadow border-0">
                        <img class="card-img-top" src="https://dummyimage.com/600x350/adb5bd/495057" alt="..." />
                        <div class="card-body p-4">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2">Media</div>
                            <a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3">Another blog post title</h5></a>
                            <p class="card-text mb-0">This text is a bit longer to illustrate the adaptive height of each card. Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                        <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                            <div class="d-flex align-items-end justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                                    <div class="small">
                                        <div class="fw-bold">Josiah Barclay</div>
                                        <div class="text-muted">March 23, 2023 &middot; 4 min read</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-5 ">
                    <div class="card h-100 shadow border-0">
                        <img class="card-img-top" src="https://dummyimage.com/600x350/6c757d/343a40" alt="..." />
                        <div class="card-body p-4">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2">News</div>
                            <a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3">The last blog post title is a little bit longer than the others</h5></a>
                            <p class="card-text mb-0">Some more quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                        <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                            <div class="d-flex align-items-end justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                                    <div class="small">
                                        <div class="fw-bold">Evelyn Martinez</div>
                                        <div class="text-muted">April 2, 2023 &middot; 10 min read</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
</main>
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