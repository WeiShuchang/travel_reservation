<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset( 'home/css/styles.css' )}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset( 'home/css/homestyles.css' )}}">
    <link rel="icon" type="image/png" href="{{ asset( 'home/images/elugan.png' )}}">
</head>
<body>
    <!--NavBar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-success">
        <a class="navbar-brand" href="#"><img src="{{asset ('home/images/elugan.png') }}" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link text-white mx-3" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white mx-3" href="/login">Log-in</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white mx-3" href="/register">Sign-up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white mx-3" href="#">About System</a>
            </li>

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
</body>
</html>