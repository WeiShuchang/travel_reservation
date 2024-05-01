<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>ELugan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript (Bundle including Popper.js) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
          <ul class="navbar-nav">

            <li class="nav-item"  id="home">
              <a class="nav-link text-white mx-3" href="/user">Home</a>
            </li>

            
            <li class="nav-item active" id="available_cars">
              <a class="nav-link text-white mx-3" href="{{ route('reservation.show_available') }}">Available Cars and Drivers</a>
            </li>

            <li class="nav-item" id="pending_request">
              <a class="nav-link text-white mx-3" href="{{ route('reservation.my_reservations') }}">Pending Requests
              @if($user_pending_reservations > 0)
                  <span class="badge badge-danger badge-pill">{{ $user_pending_reservations }}</span>
              @endif
              </a>
            </li>

            <li class="nav-item" id="approved_request">
              <a class="nav-link text-white mx-3" href="{{ route('reservation.user_approved') }}">Approved Requests
                @if($user_approved_reservations > 0)
                  <span class="badge badge-primary badge-pill">{{ $user_approved_reservations }}</span>
                @endif
              </a>
              
            </li>

            <li class="nav-item active" id="travel_history">
              <a class="nav-link text-white mx-3" href="{{ route('reservation.show_history') }}">Travel History</a>
            </li>

           
          </ul>
          <ul class="navbar-nav">
        
            @if (Auth::check())
              <li class="nav-item">
                <a href="#" onclick="$('#signOutBtn').click()" class="mx-3 nav-link text-white left">Logout</a>
                <form style='display: none;' method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button id="signOutBtn" type="submit">Logout</button>
                </form>
              </li>
            @else
              <li class="nav-item">
                <a class="nav-link text-white mx-3" href="{{ route('login') }}">Login</a>
              </li>
            @endif
          </ul>
        </div>
      </nav>
    <!--End NavBar-->
    @yield('content')

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
