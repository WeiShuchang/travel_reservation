<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELugan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Favicon-->

    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('home/css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('home/css/homestyles.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('home/images/elugan.png') }}">
</head>
<body>

    <!--NavBar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-success">
        <a class="navbar-brand" href="#"><img src="{{ asset('home/images/elugan.png') }}" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
          <ul class="navbar-nav ">

            <li class="nav-item" id="home">
              <a class="nav-link text-white mx-3  {{ Request::is('administrator') ? 'active' : '' }}" id="home-link" href="{{ route('administrator') }}">Home</a>
            </li>

            <li class="nav-item" id="travel_request">
              <a class="nav-link text mx-3 position-relative " id="travel-request-link" href="">
                  Travel Request
                 {{--@if($num_reservations > 0)
                      <span class="badge badge-danger badge-pill">{{ $num_reservations }}</span>
                  @endif--}} 
              </a>
            </li>

            <li class="nav-item" id="approved_travel">
              <a class="nav-link text mx-3 " id="approved-travel-link" href="">Approved Travel
                {{--@if($num_approved_reservations > 0)
                      <span class="badge badge-primary badge-pill">{{ $num_approved_reservations }}</span>
                  @endif--}}
              </a>
            </li>

            

            <li class="nav-item dropdown mx-3">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown car-inventory-link driver-inventory-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Inventories
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item nav-link text" id="car-inventory-link" href="">Car Inventory</a>
                <a class="dropdown-item nav-link text" id="driver-inventory-link" href="/drivers_inventory">Driver Inventory</a>

              </div>
            </li>

          </ul>
          <ul class="navbar-nav">
            <li class="nav-item" id="about_system">
              <a class="nav-link text mx-3 " id="about-system-link" href="">About System</a>
            </li>
            @if (Auth::check())
              <li class="nav-item">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="mx-3 nav-link left">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </li>
            @else
              <li class="nav-item">
                <a class="nav-link mx-3" href="{{ route('login') }}">Login</a>
              </li>
            @endif
          </ul>
        </div>
      </nav>
    <!--End NavBar-->
    @yield('content')

    <!-- Footer-->
<footer class="bg-success py-4 mt-auto ">
  <div class="container px-5">
      <div class="row align-items-center justify-content-between flex-column flex-sm-row">
          <div class="col-auto"><div class="small m-0 text-white">Copyright &copy; Elugan 2024</div></div>
          <div class="col-auto">
              <a class="link-light small" href="#!">Privacy</a>
              <span class="text-white mx-1">&middot;</span>
              <a class="link-light small" href="#!">Terms</a>
              <span class="text-white mx-1">&middot;</span>
              <a class="link-light small" href="#!">Contact</a>
          </div>
      </div>
  </div>
</footer>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
      $(document).ready(function() {
        // Function to handle click event on navigation links
        $(".navbar-nav .nav-link").on("click", function() {
          // Remove 'is_active' class from all links
          $(".navbar-nav .nav-link").removeClass("is_active");
          // Add 'is_active' class to the clicked link
          $(this).addClass("is_active");

    
          // Get the ID of the clicked link
          var linkId = $(this).parent().attr("id");
          // Store the ID in local storage
          localStorage.setItem("activeLinkId", linkId);
        });
    
        // Check if there's a stored active link ID
        var activeLinkId = localStorage.getItem("activeLinkId");
        if (activeLinkId) {
          // Add 'is_active' class to the corresponding link
          $("#" + activeLinkId + " .nav-link").addClass("is_active");
        }
      });
    </script>
    

</body>


</html>
