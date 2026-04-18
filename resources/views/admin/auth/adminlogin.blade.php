<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/BPTTG_DIY-removebg-preview.png') }}">
</head>
<body class="bg-gray-200">

<main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-100 bg-gradient-dark">
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-4 col-md-8 col-12 mx-auto">
                    <div class="card z-index-0 fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">
                                    Login
                                </h4>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.login.post') }}">
                                @csrf
                                <div class="d-flex justify-content-center mb-2">
                                    <img src="/assets/img/BPTTG_DIY-removebg-preview.png" alt="Logo" class="w-15 h-14">
                                </div> 
                                <div class="d-flex justify-content-center mb-1">
                                    <img src="/assets/img/BPTTG DIY word.png" alt="Logo" class="w-15 h-7">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>

                                @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                                @error('password') <p class="text-danger">{{ $message }}</p> @enderror

                                <button type="submit" class="btn bg-gradient-dark w-100 my-4">
                                    Sign in
                                </button>

                                <!-- FORGOT PASSWORD (BENAR) -->
                                <p class="text-sm text-center mb-0">
                                  Lupa password?
                                  <a href="{{ route('password.request') }}"
                                    class="text-primary font-weight-bold">
                                    Reset password
                                  </a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>
