@extends('user.base')

@section('content')

<style>
    .card {
      margin-bottom: 20px;
      border: 2px solid #dee2e6;
      border-radius: 10px;
      transition: transform 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .bg-light-green {
      background-color: #d4edda !important;
    }
    .bg-light-yellow {
      background-color: #fff3cd !important;
    }
    .bg-green {
      background-color: #28a745 !important;
    }
    .unavailable {
      color: red;
    }
    .navbar-brand {
      font-size: 1.5rem;
      font-weight: bold;
    }
    .nav-link {
      font-size: 1.2rem;
    }
  </style>
</head>
<body class="bg-green">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">BSU Motorpool</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <div class="row" id="carList">
    <div class="col-md-3">
      <div class="card bg-light-yellow">
        <img src="car_picture.jpg" class="card-img-top" alt="Car Picture">
        <div class="card-body">
          <h5 class="card-title">Toyota Camry</h5>
          <p class="card-text">Number of Seats: 5</p>
          <p class="card-text availability">Availability: Unavailable</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-light-yellow">
        <img src="car_picture.jpg" class="card-img-top" alt="Car Picture">
        <div class="card-body">
          <h5 class="card-title">Honda Accord</h5>
          <p class="card-text">Number of Seats: 4</p>
          <p class="card-text availability">Availability: Available</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-light-yellow">
        <img src="car_picture.jpg" class="card-img-top" alt="Car Picture">
        <div class="card-body">
          <h5 class="card-title">Ford Fusion</h5>
          <p class="card-text">Number of Seats: 5</p>
          <p class="card-text availability">Availability: Available</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-light-yellow">
        <img src="car_picture.jpg" class="card-img-top" alt="Car Picture">
        <div class="card-body">
          <h5 class="card-title">Chevrolet Malibu</h5>
          <p class="card-text">Number of Seats: 4</p>
          <p class="card-text availability">Availability: Unavailable</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const availabilityElements = document.querySelectorAll('.availability');
  availabilityElements.forEach(element => {
    if (element.textContent.trim() === 'Availability: Unavailable') {
      element.style.color = 'red';
    } else if (element.textContent.trim() === 'Availability: Available') {
      element.style.color = 'green';
    }
  });
</script>






@endsection
