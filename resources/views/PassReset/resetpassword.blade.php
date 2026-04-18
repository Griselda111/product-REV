<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Password</title>
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
                                <h4 class="text-white text-center mt-2 mb-0">
                                    Create New Password
                                </h4>
                            </div>
                        </div>

                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger text-sm">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <!-- FORM RESET PASSWORD -->
                            <form method="POST" action="{{ route('password.reset.submit') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="input-group input-group-outline my-3">
                                    <input type="password"
                                           name="password"
                                           class="form-control"
                                           placeholder="New Password"
                                           required>
                                </div>

                                <div class="input-group input-group-outline my-3">
                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control"
                                           placeholder="Confirm New Password"
                                           required>
                                </div>

                                <button type="submit" class="btn bg-gradient-dark w-100">
                                    Reset Password
                                </button>
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
