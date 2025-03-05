<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- PHP Code to handle form submission -->
<?php
    require "../db/config.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        // $password = $_POST["password"];
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $alreadyExists="select * from user_register where user_email='$email'";
        $result=mysqli_query($conn,$alreadyExists);
        $count=mysqli_num_rows($result);
        if($count>0){
            echo '<div class="flex justify-center">
            <h1 class="text-2xl pt-3 font-medium text-red-500">Email already exists</h1>
            </div>';
        }else{
            // $hashpassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user_register (user_firstname, user_lastname, user_email, user_password) VALUES ('$first_name', '$last_name','$email', '$password')";
        $execute = mysqli_query($conn, $query);
        if ($execute) {
        header("Location: login.php");
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
        }        
    }
    ?>
<div class="flex items-center justify-center h-screen ">
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
        <div class="flex flex-col w-1/2 bg-white p-8 overflow-y-auto">
            <div class="w-full max-w-md mx-auto">
                <div class="text-center sticky -top-10 bg-white border-b border-gray-200 py-4">
                    <h2 class="text-3xl font-bold text-gray-800">Create account</h2>
                    <p class="mt-2 text-gray-600 pb-2">Create an account for SickorNot.io</p>
                </div>

                <div class="mt-6 space-y-4">
                    <!-- Google Sign-in Button -->
                    <button class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                        </svg>
                        Continue with Google
                    </button>

                    <div class="flex items-center justify-center">
                        <div class="flex-grow h-px bg-gray-200"></div>
                        <span class="px-3 text-gray-500 text-sm">Or</span>
                        <div class="flex-grow h-px bg-gray-200"></div>
                    </div>

                    <!-- Registration Form -->
                    <form class="space-y-4" method="POST">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                            </div>
                        </div>
        

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                        </div>

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
            <div class="mt-4 text-center">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="login.php" class="text-blue-600 hover:underline ml-1">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>
    
</body>

</html>