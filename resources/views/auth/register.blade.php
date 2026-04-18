<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sign Up | BPTTG DIY</title>

  <link rel="icon" type="image/png" href="{{ asset('assets/img/BPTTG_DIY-removebg-preview.png') }}">
  <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />
  <link id="pagestyle"
    href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="bg-gray-200">

<main class="main-content mt-0">
  <!-- BACKGROUND SAMA PERSIS DENGAN LOGIN -->
  <div class="page-header align-items-start min-vh-100 bg-gradient-dark">
    <div class="container my-auto">
      <div class="row">
        <div class="col-lg-4 col-md-8 col-12 mx-auto">

          <div class="card z-index-0 fadeIn3 fadeInBottom">

            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">
                  Sign up
                </h4>
              </div>
            </div>

            <div class="card-body">
              <!-- REGISTER FORM -->
              <form method="POST" action="{{ route('register.store') }}" class="text-start">
                @csrf

                <div class="d-flex justify-content-center mb-2">
                  <img src="/assets/img/BPTTG_DIY-removebg-preview.png"
                    alt="Logo" class="w-15 h-14">
                </div>

                <div class="d-flex justify-content-center mb-1">
                  <img src="/assets/img/BPTTG DIY word.png"
                    alt="Logo" class="w-15 h-7">
                </div>

                <div class="input-group input-group-outline my-3">
                  <input type="text" name="name" class="form-control"
                    placeholder="Username" required>
                </div>

                <div class="input-group input-group-outline my-3">
                  <input type="email" name="email" class="form-control"
                    placeholder="Email" required>
                </div>

                <div class="input-group input-group-outline mb-3">
                  <input type="password" name="password" class="form-control"
                    placeholder="Password" required>
                </div>

                @error('name') <p class="text-danger text-sm">{{ $message }}</p> @enderror
                @error('email') <p class="text-danger text-sm">{{ $message }}</p> @enderror
                @error('password') <p class="text-danger text-sm">{{ $message }}</p> @enderror

                <div class="text-center">
                  <button type="submit"
                    class="btn bg-gradient-dark w-100 my-4 mb-2">
                    Create Account
                  </button>
                </div>

                <p class="text-sm text-center mt-3">
                  Sudah punya akun?
                  <a href="{{ route('login') }}"
                    class="text-primary font-weight-bold">
                    Sign in
                  </a>
                </p>

              </form>
              <!-- END FORM -->
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</main>

<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>

</body>
</html>
