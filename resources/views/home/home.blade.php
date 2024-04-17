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
                            <button type="button" class="btn btn-success px-4" data-toggle="modal" data-target="#exampleModal">
                                Explore
                            </button>
                            <a class="btn btn-outline-light btn px-4" href="/login">Log-in</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="{{asset('home/images/eluganbg.png')}}" alt="..." /></div>
            </div>
        </div>
    </header>

    <!-- Button to trigger the modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content  bg-success2">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">ELugan: Travel Reservation System</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-success">

        <div class="col mb-5 h-100">
            <div class="feature bg-success bg-gradient text-white rounded-3 mb-3"><i class="bi bi-calendar-check"></i>
            </div>
            <h2 class="h2 text-yellow">Travel Reservation</h2>
            <p class="h5 mb-0 text-yellow" >BSU Employees can reserve a vehicle online</p>
        </div>

        <div class="col mb-5">
            <div class="feature bg-success bg-gradient text-white rounded-3 mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bus-front-fill" viewBox="0 0 16 16">
                <path d="M16 7a1 1 0 0 1-1 1v3.5c0 .818-.393 1.544-1 2v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5V14H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2a2.5 2.5 0 0 1-1-2V8a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1V2.64C1 1.452 1.845.408 3.064.268A44 44 0 0 1 8 0c2.1 0 3.792.136 4.936.268C14.155.408 15 1.452 15 2.64V4a1 1 0 0 1 1 1zM3.552 3.22A43 43 0 0 1 8 3c1.837 0 3.353.107 4.448.22a.5.5 0 0 0 .104-.994A44 44 0 0 0 8 2c-1.876 0-3.426.109-4.552.226a.5.5 0 1 0 .104.994M8 4c-1.876 0-3.426.109-4.552.226A.5.5 0 0 0 3 4.723v3.554a.5.5 0 0 0 .448.497C4.574 8.891 6.124 9 8 9s3.426-.109 4.552-.226A.5.5 0 0 0 13 8.277V4.723a.5.5 0 0 0-.448-.497A44 44 0 0 0 8 4m-3 7a1 1 0 1 0-2 0 1 1 0 0 0 2 0m8 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m-7 0a1 1 0 0 0 1 1h2a1 1 0 1 0 0-2H7a1 1 0 0 0-1 1"/>
                </svg></div>
            <h2 class="h2  text-yellow">Car Management</h2>
            <p class="h5 mb-0  text-yellow">Exclusive for BSU Motorpool Staff</p>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
        <!-- You can add additional buttons here -->
      </div>
    </div>
  </div>
</div>



    <div class="centering-div mt-5">
        <div class="logo">
            <img src="{{ asset( 'home/images/elugan.png') }}" width="150px" height="150px" alt="elugan-logo">
        </div>
    </div>


    <!-- Blog preview section-->
    <section class="py-5  bg-success">
        <div class="container px-5 ">

            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="text-center">
                        <h2 class="fw-bolder text-yellow">About The System</h2>
                        <p class="lead fw-normal text-white mb-5 ">The ELugan Travel Reservation and Vehicle Management System is a project designed for BSU Motorpool Automotive Services </p>
                    </div>
                </div>
            </div>

            <div class="row gx-5 ">

                <div class="col-lg-4 mb-5 ">
                    <div class=" card h-100 shadow border-0  text-white">
                        <img class="card-img-top" src="{{asset('home/images/about_system.png')}}" alt="..." />
                        <div class="card-body p-4 bg-success2 text-white">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2">User Feature</div>
                            <a class="text-decoration-none text-yellow" href="#!"><h5 class="card-title mb-3">Travel Reservation</h5></a>
                            <p class="card-text mb-0">BSU Employees can apply for a travel reservation by filling out a form.</p>
                        </div>
                        <div class="bg-success2">
                            <div class="card-footer p-4 pt-0 bg-transparent border-top-0 ">
                                <div class="d-flex align-items-end justify-content-between ">
                                    <div class="d-flex align-items-center ">
                                        <img class="rounded-circle me-3" src="{{ asset( 'home/images/elugan.png' )}}" alt="..." height="40px" width="40px"/>
                                        <div class="small">
                                            <div class="fw-bold">E-Lugan</div>
                                            <div class="text-muted">Last Updated &middot; April 11, 2024</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-5 ">
                    <div class="card h-100 shadow border-0  text-white">
                        <img class="card-img-top" src="{{asset('home/images/about_system_2.png')}}" alt="..." />
                        <div class="card-body p-4 bg-success2 text-white">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2">Admin Feature</div>
                            <a class="text-decoration-none text-yellow" href="#!"><h5 class="card-title mb-3">Car Management System</h5></a>
                            <p class="card-text mb-0">Staff of BSU Motorpool can manage the vehicles inside the station.</p>
                        </div>
                        <div class="bg-success2">
                            <div class="card-footer p-4 pt-0 bg-transparent border-top-0 ">
                                <div class="d-flex align-items-end justify-content-between ">
                                    <div class="d-flex align-items-center ">
                                        <img class="rounded-circle me-3" src="{{ asset( 'home/images/elugan.png' )}}" alt="..." height="40px" width="40px"/>
                                        <div class="small">
                                            <div class="fw-bold">E-Lugan</div>
                                            <div class="text-muted">Last Updated &middot; April 11, 2024</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-5 ">
                    <div class="card h-100 shadow border-0  text-white">
                        <img class="card-img-top" src="{{asset('home/images/about_system_3.png')}}" alt="..." />
                        <div class="card-body p-4 bg-success2 text-white">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2">Admin Feature</div>
                            <a class="text-decoration-none text-yellow" href="#!"><h5 class="card-title mb-3">Car and Driver Inventory System</h5></a>
                            <p class="card-text mb-0">Staff of BSU Motorpool can make use of the systems inventory to put information about the drivers and cars in the station</p>
                        </div>
                        <div class="bg-success2">
                            <div class="card-footer p-4 pt-0 bg-transparent border-top-0 ">
                                <div class="d-flex align-items-end justify-content-between ">
                                    <div class="d-flex align-items-center ">
                                        <img class="rounded-circle me-3" src="{{ asset( 'home/images/elugan.png' )}}" alt="..." height="40px" width="40px"/>
                                        <div class="small">
                                            <div class="fw-bold">E-Lugan</div>
                                            <div class="text-muted">Last Updated &middot; April 11, 2024</div>
                                        </div>
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