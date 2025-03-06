<?php 
session_start();
require "../db/config.php";
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery (Required for Toastr) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Toastr.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <!-- Toastr.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body class="bg-gray-100">
    <?php  
if (isset($_SESSION['success'])) {
    echo "<script>
            $(document).ready(function() {
                toastr.options.positionClass = 'toast-top-right';
                toastr.success('" . $_SESSION['success'] . "');
            });
          </script>";
    unset($_SESSION['success']);  
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $userExists = "select * from user_register where user_email='$email'";
    $result = mysqli_query($conn, $userExists);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['user_password'];
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: ../index.php");
            exit();
        } else {
            echo '<script>
            Command: toastr["warning"]("Invalid password", "password_mismatch")             
            toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
            }
            </script>';
        }
    } else {
       echo '<script>
        Command: toastr["warning"]("Invalid email", "User not found!")
     
        toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        }
        </script>';
    };
};
?>
   
    <div class="flex h-[90vh] w-[60vw] overflow-hidden rounded-lg shadow-xl mx-auto m-6">
        <!-- Left Section with Yellow Background and Image -->
        <div class="relative flex items-center justify-center w-1/2 bg-yellow-400">
            <div class="relative text-center">
                <img src="../images/auth_logo_2x_ecgesw.avif" alt="Welcome" class="w-48 h-52 mx-auto">
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-black text-yellow-400 px-4 py-1 font-bold text-xl">
                    WELCOME
                </div>
            </div>
        </div>

        <!-- Right Section with Form -->
        <div class="flex flex-col items-center justify-cent w-1/2 bg-white p-8">
            <div class="w-full max-w-md space-y-5">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-800">Login account</h2>
                    <p class="mt-2 text-gray-600">Sign in with your Email or Google.</p>
                </div>

                <div class="space-y-2">
                    <!-- Login Form -->
                    <form class="space-y-4" action="login.php" method="POST">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition-colors font-semibold">
                            Login
                        </button>
                    </form>

                    <!-- Terms Text -->
                    <div class="text-center text-sm text-gray-500 pt-4">
                        By continuing, you agree to our
                        <a href="#" class="text-gray-700 hover:underline">Terms of Use</a> and
                        <a href="#" class="text-gray-700 hover:underline">Privacy Policy</a>.
                    </div>
                </div>
            </div>

            <!-- Already have an account -->
            <div class="mt-4 text-center">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="signup.php" class="text-blue-600 hover:underline ml-1">Sign up</a>
                </p>
            </div>
        </div>
    </div>

</body>

</html>