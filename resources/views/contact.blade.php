<!DOCTYPE html>
<html lang="zxx">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Title -->
  <title>voters</title>
  <!-- Favicon Icon -->
  <link rel="shortcut icon" href="assets/images/voter/logo/logo.png" type="image/x-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Flaticon -->
  <link rel="stylesheet" href="assets/css/flaticon.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/css/fontawesome-5.14.0.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <!-- Magnific Popup -->
  <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
  <!-- Nice Select -->
  <link rel="stylesheet" href="assets/css/nice-select.min.css">
  <!-- Animate -->
  <link rel="stylesheet" href="assets/css/aos.css">
  <!-- Slick -->
  <link rel="stylesheet" href="assets/css/slick.min.css">
  <!-- Main Style -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Add SweetAlert2 CDN in your Blade file -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .border-bottom-quick-link {
      display: inline-block;
      border-bottom: 1px solid white;
      width: 115px;
      margin-bottom: 10px;
    }

    .footer-subscribe {
      height: 100px;
      background-color: #ccc;
      border-radius: 10px;
      bottom: 150px;
      left: 700px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .footer-subscribe input {
      width: 250px;
      background-color: #fff;

    }

    .footer-subscribe button {
      cursor: pointer;
    }

    .footer-subscribe p {
      font-size: 12px;
    }
  </style>

</head>

<body class="home-three">
  <div class="page-wrapper">
    <section>
      <!-- Preloader -->
      <!-- <div class="preloader"><div class="custom-loader"></div></div> -->

      <!-- main header -->
      <header class="main-header menu-absolute">

        <!--Header-Upper-->
        <div class="header-upper">
          <div class="container container-1520 clearfix">

            <div class="header-inner py-20 rpy-10 rel d-flex align-items-center">
              <div class="logo-outer">
                <div class="logo"><a href="index.html"><img src="assets/images/voter/logo/logo.png" alt="Logo" title="Logo"></a></div>
              </div>

              <div class="nav-outer ms-lg-auto clearfix">
                <!-- Main Menu -->
                <nav class="main-menu navbar-expand-lg">
                  <div class="navbar-header py-10">
                    <div class="mobile-logo">
                      <a href="index.html">
                        <img src="assets/images/logos/logo3.png" alt="Logo" title="Logo">
                      </a>
                    </div>

                    <!-- Toggle Button -->
                    <button type="button" class="navbar-toggle" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                  </div>

                  <div class="navbar-collapse collapse clearfix">
                    <ul class="navigation clearfix">
                      <li class=""><a href="/">Home</a></li>
                      <li class=""><a href="contact">Contact Us</a>
                    </ul>
                  </div>

                </nav>
                <!-- Main Menu End-->
              </div>


              <!-- Menu Button -->
              <div class="menu-btns ms-lg-auto">

                <a href="auth" class="theme-btn style-two">Sign In <i class="far fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <!--End Header Upper-->
      </header>
    </section>

<section class="card shadow">
    <div class="card-body">
        <h2 class="mb-3">Help & Contact</h2>
        <p>If you have any questions or face issues during voter registration, please contact us:</p>

        <ul class="list-group">
            <li class="list-group-item"><strong>Helpline Number:</strong> +91 98765 43210</li>
            <li class="list-group-item"><strong>Email:</strong> help@voterportal.in</li>
            <li class="list-group-item"><strong>Office Address:</strong> Election Office, Main Street, Your City</li>
        </ul>
        <hr>
        <h5>Submit a Query</h5>
        
        <!-- Contact Form -->
        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="message">Message</label>
                <textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter your message" required></textarea>
                @error('message')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</section>
<!-- SweetAlert Popup for Success -->
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif


    <footer class="bg-primary text-white pt-5 pb-3 ">
      <div class="container ">
        <div class="row">
          <!-- Column 1: Info -->
          <div class="col-md-3 mb-4">
            <h5 class="border-bottom pb-2">Get Registered, Log In & Update And Check</h5>
            <p>
              Register as a voter and participate in shaping the future of your nation.
              Our online voter registration system makes it easy to create your profile,
              log in securely, and track the status of your voter card application.
              Ensure your details are up to date and be ready to cast your vote with confidence.
            </p>

            <p><i class="bi bi-person-badge"></i> Sarpanch - Voter Registration Administrator</p>
            <div>
              <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
              <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
              <a href="#" class="text-white me-3"><i class="bi bi-twitter-x"></i></a>
              <a href="#" class="text-white me-3"><i class="bi bi-youtube"></i></a>
              <a href="#" class="text-white me-3"><i class="bi bi-telegram"></i></a>
            </div>
          </div>

          <!-- Column 2: Election Image -->
          <div class="col-md-3 mb-4 text-center">

          </div>

          <!-- Column 3: Quick Links -->
          <div class="col-md-3 mb-4">
            <h5 class="border-bottom-quick-link pb-2">Quick Links</h5>
            <ul class="list-unstyled">
              <li><a href="/" class="text-white">home</a></li>
              <li><a href="contact" class="text-white">Contact Us</a></li>
              <li><a href="auth" class="text-white">sing in</a></li>
            </ul>
          </div>

          <div class="footer-subscribe position-absolute" style="width: 350px;">
            <form id="subscribeForm" class="d-flex align-items-center gap-2">
              @csrf
              <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
                class="form-control form-control-sm">
              <button type="submit" class="btn btn-sm btn-outline-primary">Subscribe</button>
            </form>
          </div>

          <!-- Include SweetAlert2 -->
          <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          <!-- Include jQuery (for AJAX) -->
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

          <script>
            $(document).ready(function() {
              $('#subscribeForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                  url: "{{ route('subscribe') }}",
                  type: "POST",
                  data: $(this).serialize(),
                  success: function(response) {
                    Swal.fire({
                      icon: 'success',
                      title: 'Subscribed!',
                      text: response.message,
                      timer: 2000,
                      showConfirmButton: false
                    });
                    $('#subscribeForm')[0].reset(); // Clear the form
                  },
                  error: function(xhr) {
                    let error = xhr.responseJSON.errors.email[0];
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops!',
                      text: error,
                    });
                  }
                });
              });
            });
          </script>


        </div>



        <hr class="border-light">
        <div class="text-center">
          &copy; Copyright voters 2025. All rights reserved.
        </div>
      </div>

    </footer>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


  </div>
  <!--End pagewrapper-->


  <!-- Jquery -->
  <script src="assets/js/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap -->
  <script src="assets/js/bootstrap.min.js"></script>
  <!-- Appear Js -->
  <script src="assets/js/appear.min.js"></script>
  <!-- Slick -->
  <script src="assets/js/slick.min.js"></script>
  <!-- Magnific Popup -->
  <script src="assets/js/jquery.magnific-popup.min.js"></script>
  <!-- Nice Select -->
  <script src="assets/js/jquery.nice-select.min.js"></script>
  <!-- Image Loader -->
  <script src="assets/js/imagesloaded.pkgd.min.js"></script>
  <!-- Circle Progress -->
  <script src="assets/js/circle-progress.min.js"></script>
  <!-- Skillbar -->
  <script src="assets/js/skill.bars.jquery.min.js"></script>
  <!-- Isotope -->
  <script src="assets/js/isotope.pkgd.min.js"></script>
  <!--  WOW Animation -->
  <script src="assets/js/aos.js"></script>
  <!-- Custom script -->
  <script src="assets/js/script.js"></script>

</body>

</html>