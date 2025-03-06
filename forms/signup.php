<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- jQuery (Required for Toastr) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Toastr.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <!-- Toastr.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body class="bg-gray-100">

<!-- PHP Code to handle form submission -->
<?php
 session_start();
    require "../db/config.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password=$_POST["confirm_password"];

        $alreadyExists = "select * from user_register where user_email='$email'";
        $execute = mysqli_query($conn, $alreadyExists);
        $count = mysqli_num_rows($execute);
        if ($count > 0) {
            echo '<script>
                Command: toastr["warning"]("Invalid email", "Email already exist")             
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
        else{
        if($password!==$confirm_password){
            echo '<script>
                Command: toastr["warning"]("Confirm password", "Password doesn\'t match")             
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
        else {
        $hash_password = password_hash( $password, PASSWORD_BCRYPT);      
            $query = "INSERT INTO user_register (user_firstname, user_lastname, user_email, user_password) VALUES ('$first_name', '$last_name','$email', 'hash_password')";
            $execute = mysqli_query($conn, $query);
            $_SESSION['success'] = "registration successful";
            if ($execute) {
                header("Location: login.php");
                exit();
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        }
    }
    }
    ?>
    
    <div class="flex items-center justify-center p-2">
        <div class="flex h-[95vh] w-[70vw] md:w-[60vw] overflow-hidden rounded-lg shadow-xl mx-auto">
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
            <div class="flex flex-col w-1/2 bg-white py-4 px-8">
                <div class="w-full max-w-md mx-auto">
                    <div class="text-center pt-2">
                        <h2 class="text-3xl font-bold text-gray-800">Create account</h2>
                        <p class="mt-2 text-gray-600">Create an account for SickorNot.io</p>
                    </div>

                    <div class="mt-6 space-y-4">


                        <!-- Registration Form -->
                        <form class="space-y-4" method="POST">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" id="first_name" name="first_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                </div>
                            </div>


                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            </div>


                            <!-- <div class="grid grid-cols-2 gap-4"> -->
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                    <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                </div>
                                <div>
                                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                </div>
                            <!-- </div> -->

                            <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Register
                            </button>
                        </form>

                        <!-- Terms Text -->
                        <div class="text-center text-sm text-gray-500">
                            By continuing, you agree to our
                            <a href="#" class="text-gray-700 hover:underline">Terms of Use</a> and
                            <a href="#" class="text-gray-700 hover:underline">Privacy Policy</a>.
                        </div>
                    </div>
                </div>

                <!-- Already have an account -->
                <div class=" text-center">
                    <p class="text-gray-600 ">
                        Already have an account?
                        <a href="login.php" class="text-blue-600 hover:underline ml-1">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>