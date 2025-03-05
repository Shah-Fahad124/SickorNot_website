<?php
require_once '../libraray/vendor/autoload.php';

//Include Configuration File
include('../Auth/google_login.php');

use Google\Service\Oauth2;

$login_button = '';

if (isset($_GET["code"])) {

    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    if (!isset($token['error'])) {
        $google_client->setAccessToken($token['access_token']);

        $_SESSION['access_token'] = $token['access_token'];
        $google_service = new Oauth2($google_client);
        $data = $google_service->userinfo->get();
        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }
        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }
        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }
        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }
        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}

if (!isset($_SESSION['access_token'])) {
    $login_button = '<a href="' . $google_client->createAuthUrl() . '"><button class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Continue with Google
                    </button></a>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php
    require "../db/config.php";
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
                // echo '<div class="flex items-center justify-center bg-green-400 text-white h-12 mb-4 mx-auto">
                // <h1 class="text-2xl font-bold">Login successful</h1>
                // </div>';
                header("Location: ../index.php");
            } else {
                echo '<div class="flex items-center justify-center bg-red-400 text-white h-12 mb-4 mx-auto">
            <h1 class="text-2xl font-bold">Invalid password</h1>
            </div>';
            }
        } else {
            echo '<div class="flex items-center justify-center bg-red-400 text-white h-12 mb-4 mx-auto">
    <h1 class="text-2xl font-bold">User not found</h1>
    </div>';
        };
    };
    ?>;
    <div class="flex h-[90vh] w-[60vw] overflow-hidden rounded-lg shadow-xl mx-auto">
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

                <div class="mt- space-y-2">
                    <!-- Google Sign-in Button -->

                    <?php
                    if ($login_button == '') {
                        echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
                        echo '<img src="' . $_SESSION["user_image"] . '" class="img-responsive img-circle img-thumbnail" />';
                        echo '<h3><b>Name :</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
                        echo '<h3><b>Email :</b> ' . $_SESSION['user_email_address'] . '</h3>';
                        echo '<h3><a href="logout.php">Logout</h3></div>';
                    } else {
                        echo '<div align="center">' . $login_button . '</div>';
                    }
                    ?>                   

                    <div class="flex items-center justify-center">
                        <span class="text-gray-500">Or</span>
                    </div>

                    <!-- Login Form -->
                    <form class="space-y-4" action="login.php" method="POST"> 
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition-colors font-semibold">
                        Login with email
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
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="signup.php" class="text-blue-600 hover:underline ml-1">Sign up</a>
                </p>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("authentication-modal");
            const openModalBtn = document.querySelector("[data-modal-toggle='authentication-modal']");
            const closeModalBtn = modal.querySelector("[data-modal-hide='authentication-modal']");

            // Open modal
            openModalBtn.addEventListener("click", function() {
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            });

            // Close modal
            closeModalBtn.addEventListener("click", function() {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            });

            // Close modal when clicking outside the modal content
            modal.addEventListener("click", function(event) {
                if (event.target === modal) {
                    modal.classList.add("hidden");
                    modal.classList.remove("flex");
                }
            });
        });
    </script>
</body>

</html>