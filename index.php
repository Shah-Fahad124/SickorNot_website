<?php
session_start();
require "./db/config.php";
if (isset($_SESSION['user_email'])) {
    $autorizeUser = true;
} else {
    $autorizeUser = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SickorNot.io</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @media (max-width: 768px) {
            .mobile-menu {
                display: none;
            }

            .mobile-menu.active {
                display: flex;
            }
        }

        .camera-container {
            position: relative;
            overflow: hidden;
            border-radius: 0.5rem;
        }

        .capture-btn {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: white;
            border: 4px solid #3b82f6;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .capture-btn:hover {
            transform: scale(1.05);
        }

        .close-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ef4444;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .flash {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: white;
            opacity: 0;
            pointer-events: none;
        }

        .flash-animation {
            animation: flash 0.3s ease-out forwards;
        }

        @keyframes flash {
            0% {
                opacity: 0.8;
            }

            100% {
                opacity: 0;
            }
        }
    </style>
</head>

<body class="bg-[#FAFAFA]">

    <!-- navbar section -->
    <div class="navbar flex justify-center items-start pt-2 translate-y-2">
        <nav class="w-[88vw] px-4 py-1 flex flex-wrap items-center justify-between">
            <!-- Logo Section -->
            <div class="flex items-center">
                <div class=" h-20">
                    <div class="rounded-full h-16 w-16  flex items-center justify-center relative">
                        <div class="bg-blue-500 hover:bg-blue-700 rounded-full overflow-hidden">
                            <img class="object-cover" src="./images/third.jpg" class="" alt="header-logo" />
                        </div>
                        <!-- blue plus icon -->
                        <div
                            class="absolute flex justify-center items-center -bottom-1 -right-1 bg-blue-500 hover:bg-blue-700 rounded-full h-6 w-6 p-0">
                            <h1 class="m-0 text-white text-[1.5rem] leading-none pb-1"><a href="">+</a></h1>
                        </div>
                    </div>
                </div>
                <div class="ml-4 flex flex-col">
                    <span class="font-semibold text-gray-800 text-lg">SickorNot<span
                            class="text-blue-500">.io</span></span>
                    <div class="bg-gray-700 text-white  flex justify-center w-12 rounded-t ">
                        beta
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="#" class="text-gray-700 hover:text-blue-700">Featured</a>
                <a href="#" class="text-gray-700 hover:text-blue-700">Resources</a>
                <?php echo ($autorizeUser) ? '<a href="./dashboard/user_dashboard.php" class="text-gray-700 hover:text-blue-700">Dashboard</a>
                    <a href="./forms/logout.php"
                    class="bg-blue-500 border hover:bg-white hover:text-blue-500 hover:border-blue-500  text-white px-2 py-[2px] rounded-full">Log out
                    </a>' :
                    '<a href="./forms/login.php" class="text-gray-700 hover:text-blue-700">Login</a>
                <a href="./forms/signup.php"
                    class="bg-blue-500 border hover:bg-white hover:text-blue-500 hover:border-blue-500  text-white px-2 py-[2px] rounded-full">Sign
                    Up</a>
                ' ?>
            </div>

            <!-- Mobile Navigation Links (hidden by default) -->
            <div id="mobile-menu" class="mobile-menu mt-2 w-full flex-col items-start  md:hidden">
                <a href="#" class="text-gray-700 hover:text-blue-700 w-full py-1">Featured</a>
                <a href="#" class="text-gray-700 hover:text-blue-700 w-full py-1">Resources</a>

                <?php echo ($autorizeUser) ? '<a href="./dashboard/user_dashboard" class="text-gray-700 hover:text-blue-700 w-full py-1">Dashboard</a>
                    <a href="./forms/logout.php"
                    class="bg-blue-500 hover:bg-blue-700 mt-2 text-white px-4 py-1 rounded-full w-full text-center">Log out
                    </a>' : '
                <a href="./forms/login.php" class="text-gray-700 hover:text-blue-700 w-full py-1">Login</a>
                <a href="./forms/signup.php"
                    class="bg-blue-500 hover:bg-blue-700 mt-2 text-white px-4 py-1 rounded-full w-full text-center">Sign
                    Up</a>'
                ?>;
            </div>
        </nav>

    </div>


    <!-- hero section  -->
    <section class="hero">
        <div
            class=" w-[85vw] mx-auto flex flex-col items-center justify-end text-center mt-6 ">
            <h1 class="text-4xl md:text-4xl lg:text-6xl font-semibold text-[#453553] mb-4">Upload Image, Get Health
                Result
            </h1>
            <p class="text-lg md:text-2xl text-gray-700 mb-10">Upload your image and get a smart health check.
            </p>

            <!-- whole camera section  -->
            <div class="flex items-end justify-center w-[30vw] mb-4">

                <!-- camera open div  -->
                <div id="start-screen" class=" flex flex-col justify-center items-cent gap-4 w-[35%]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16  text-slate-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                    <button id="open-camera-btn" class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md transition-colors">
                        Open Camera
                    </button>
                </div>

                <div class="flex items-center gap-2">

                    <div id="camera-ui" class="bg-white rounded-lg shadow-xl overflow-hidden">
                        <!-- Camera view -->
                        <div id="camera-screen" class="hidden">
                            <div class="camera-container">
                                <video id="video" class="w-full h-auto" autoplay playsinline></video>

                                <!-- Viewfinder overlay -->
                                <div class="absolute inset-0 border-2 border-dashed border-white/30 m-8 rounded-lg pointer-events-none"></div>

                                <!-- Flash effect -->
                                <div id="flash" class="flash"></div>

                                <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-4">
                                    <button id="capture-btn" class="capture-btn" aria-label="Capture photo"></button>
                                    <button id="close-camera-btn" class="close-btn" aria-label="Close camera">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Preview captured image -->
                        <div id="preview-screen" class="hidden">
                            <div class="relative">
                                <img id="captured-image" src="/placeholder.svg" alt="Captured" class="w-full h-auto" />

                                <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 px-4">
                                    <button id="save-btn" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Save
                                    </button>

                                    <button id="download-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Download
                                    </button>

                                    <button id="retake-btn" class="bg-slate-600 hover:bg-slate-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Retake
                                    </button>
                                </div>
                            </div>
                        </div>


                        <!-- Status message -->
                        <div id="status-message" class="hidden p-4 text-center"></div>
                    </div>
                    <!-- </div> -->

                    <!-- Hidden canvas for capturing -->
                    <canvas id="canvas" class="hidden"></canvas>

                    <!-- end camera  -->

                    <!-- <input type="file" id="cameraInput" accept="image/" capture="user" class="hidden">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-md"
                    onclick="document.getElementById('cameraInput').click();">
                    <a href="">Take a photo</a>
                </button> -->
                    <input type="file" id="fileInput" class="hidden">
                    <button type="button"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-3 px-3 md:px-6 rounded-md"
                        onclick="document.getElementById('fileInput').click();">
                        <a href=""> Upload your photo</a>
                    </button>

                    <!-- <div class=" hidden md:flex items-center gap-2">
                    <span class="text-gray-600">or try this</span>
                    <div class="flex space-x-2">
                        <img src="./images/first.jpg" alt="Sample profile"
                            class="w-10 h-10 rounded-full border-2 border-white object-cover">
                        <img src="./images/second.jpg" alt="Sample profile"
                            class="w-10 h-10 rounded-full border-2 border-white object-cover">
                        <img src="./images/third.jpg" alt="Sample profile"
                            class="w-10 h-10 rounded-full border-2 border-white object-cover">
                    </div>
                  </div> -->
                </div>
            </div>

            <!-- aroow section start here -->

            <div class="w-[100vw] my-3">
                <!-- Arrow pointing to upload button -->
                <div class="hidden w-[35%] mx-auto  md:flex flex-col py-2">
                    <button
                        class="transform w-14 -rotate-[-17deg] bg-gray-800 text-white text-xs px-1 mr-4 py-1 rounded-md font-medium">Click</button>
                    <img class="w-24 ml-4 rotate-[-10deg] mt-3" src="./images/arrow1.svg" alt="">
                </div>


                <div class="w-[80%] mx-auto h-[60vh] flex justify-center items-center bg-gray-100 my-5 ">
                    <div class="content w-[70%] bg-white shadow-lg rounded-lg flex ">
                        <!-- Left Side: Image -->
                        <div class="w-[35%] h-full">
                            <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Random Person" class="w-full h-full object-cover rounded-l-lg">
                        </div>
                        <!-- Right Side: Info -->
                        <div class="w-2/3 p-10 text-start">
                            <h2 class="text-xl font-semibold">John Doe</h2>
                            <p class="text-gray-600"><strong>Email: </strong>johndoe@example.com</p>
                            <p class="text-gray-600"><strong>Address: </strong>123 Main Street, City</p>
                            <p class="text-gray-600"><strong>Condition: </strong>Active</p>
                        </div>
                    </div>
                </div>



                <!-- Arrow pointing to results -->
                <div class="hidden md:flex flex-col items-start w-[30%] transform rotate-[170deg]  mx-auto my-4 mt-8 p-5">
                    <img class="w-28 -rotate-[-15deg]" src="./images/arrow1_down.svg" alt="">
                    <button
                        class=" transform rotate-[200deg]  bg-gray-800 text-white text-xs px-1 py-1 w-14 rounded-md mr-[4rem]  font-medium">and
                        get</button>
                </div>
            </div>
            <!-- arrow section end  -->


            <!-- images  section  -->
            <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 w-[90%] place-items-center">
                <div class="bg-blue-500 rounded-full p-1">
                    <img src="./images/happy.jpeg" alt="Profile with blue background"
                        class="w-full aspect-square rounded-full object-cover">
                </div>
                <div class="bg-cyan-400 rounded-full p-1">
                    <img src="./images/sad.jpg" alt="Profile with cyan background"
                        class="w-full aspect-square rounded-full object-cover">
                </div>
                <div class="bg-pink-500 hidden md:block rounded-full p-1">
                    <img src="./images/angry.jpg" alt="Profile with pink background"
                        class="w-full aspect-square rounded-full object-cover">
                </div>
                <div class="bg-yellow-400 rounded-full p-1">
                    <img src="./images/normal.jpeg" alt="Profile with yellow background"
                        class="w-full aspect-square rounded-full object-cover">
                </div>
                <div class="bg-purple-600 hidden lg:block rounded-full p-1">
                    <img src="./images/fifth.png" alt="Profile with purple background"
                        class="w-full aspect-square rounded-full object-cover">
                </div>
                <div class="bg-black hidden lg:block rounded-full p-1">
                    <img src="./images/sickman.jpg" alt="Profile with purple background"
                        class="w-full aspect-square rounded-full object-cover">
                </div>
                <!-- <div
                    class="border-[6px] hidden lg:block border-gray-700 rounded-full flex items-center justify-center h-full p-3">
                    <span
                        class="text-gray-700 text-md font-bold text-center rounded-full flex items-center justify-center h-full">
                        <a class="inline-block h-full rounded-full flex justify-center items-center" href="">See More
                            Images</a>
                    </span>
                </div> -->

            </div>

            <!-- <p class="text-sm text-gray-600 mt-6">Photo by <b>Martin Péchy</b> from <b>Pexels</b></p> -->
        </div>
        <!-- end of hero section  -->


        <div class="w-[100vw] h-[40vh] md:h-auto md:min-h-[40vh] bg-white shadow-sm overflow-hidden mt-10">
        <div class="max-w-6xl mx-auto p-6 md:p-8 flex flex-col md:flex-row">
            <!-- Left Content -->
            <div class="w-full md:w-3/5 pr-0 md:pr-8 mb-6 md:mb-0">
                <div class="text-gray-700 text-sm font-medium mb-2">Health</div>
                
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-blue-700 mb-4">
                    Are You Sick? Find Out Now!
                </h1>
                
                <p class="text-gray-600 mb-6">
                    Our advanced AI analyzes your photo to determine if you appear sick. Get instant 
                    feedback and guidance on your health.
                </p>
                
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-700 flex items-center justify-center mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="ml-2 text-gray-700">Quick results to help you make informed decisions.</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-700 flex items-center justify-center mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="ml-2 text-gray-700">Receive personalized next steps based on your results.</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-700 flex items-center justify-center mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="ml-2 text-gray-700">Your health matters—let's check it together!</span>
                    </li>
                </ul>
                
                <div class="flex items-center space-x-4">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-md transition duration-200">
                        Submit
                    </button>
                    <a href="#" class="text-blue-500 hover:text-blue-700 font-medium flex items-center transition duration-200">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Right Image -->
            <div class="w-full md:w-2/5 flex items-center justify-center">
                <div class="bg-blue-500 rounded-lg p-4 w-full h-full max-h-[300px] md:max-h-none flex items-center justify-center">
                    <img 
                        src="./images/normal.jpeg" 
                        alt="Person smiling" 
                        class="h-auto max-h-full object-contain"
                    >
                </div>
            </div>
        </div>
    </div>





        <div class="w-[60vw] mx-auto py-10 md:h-[50vh]  flex items-center justify-center text-center">
            <h1 class="text-[18px] md:text-[22px] text-[#453553 ]"><b>SickorNot.io</b> helps you check your health
                status in just a few clicks. Using AI-powered image analysis, our system detects signs of sickness and
                provides instant health insights to keep you informed</h1>
        </div>

    </section>

    <!-- input output section  -->
    <section class="w-full py-2 md:py-[4rem] bg-blue-500 flex flex-col items-center">
        <div class="first w-[50%] h-[50vh] flex items-center justify-end gap-5">
            <div class="h-[50vh] w-[50%] flex items-end justify-end">
                <img class="transform w-[50%] rotate-[150deg] pr-2" src="./images/arrow1_white.svg" alt="">
            </div>
            <div class="h-full w-[25vw]  relative flex justify-end">
                <button
                    class="px-1 md:px-3 absolute  text-[#453553] bg-white rounded-sm md:text-[1.4rem] bottom-[6%] -left-4 ">input</button>
                <img class="rounded-md w-full" src="./images/input_man.jpg" alt="">
            </div>
        </div>
        <div class="second w-[90%] lg:w-[45vw] h-[30vh] flex items-center ">
            <h1 class="text-[50px] text-white py-5">SickorNot.io</h1>
        </div>
        <div class="third w-[90vw] flex flex-col gap-1">
            <div class="h-[30vh] flex justify-end items-center w-[45%]">
                <img class="transform w-[30%] scale-x-[-1] rotate-[300deg]" src="./images/arrow1_white.svg" alt="">
            </div>
            <div class="h-[50vh] w-[30%] bg-yellow-500 relative flex items-start w-[50]">
                <button
                    class="px-1 md:px-4 absolute  text-[#453553] bg-white rounded-sm md:text-[1.4rem] -top-3 right-2">output</button>
                <img class="rounded-md h-full w-full" src="./images/output_man.jpg" alt="">
            </div>
        </div>
    </section>

    <!-- how it works -->
    <!-- <section class="w-100vw space-y-[4rem]">
        <div class="title flex flex-col justify-center items-center h-[50vh] pt-[5rem]">
            <h1 class="text-[#453553] text-[38px] font-semibold">How <b>SickorNot.io</b> works</h1>
            <p class="text-[1.2rem] text-gray-500 font-semibold">Four steps only</p>
        </div>
        <div class="step_1 w-[70%] mx-auto flex items-end">
            <div class="relative inline-block">
                <img class="h-[47vh]" src="./images/step1_2x_gxiq0l.avif" alt="">
                <button class="absolute -top-7 -right-[4rem] text-[22px] text-white font-semibold bg-[#453553] px-2 py-1 rounded">1.Upload your photo</button>
                <p class="absolute top-5 -right-[4rem] w-[32%] text-[12px] bg-[#ffffff] leading-[16px] p-2 rounded font-medium">All user photos are automatically deleted after being processed</p>
            </div>
            <div class="m-10">
                <img class="w-32 -rotate-[-25deg] mt-1" src="./images/arrow1_down.svg" alt="">
            </div>
        </div>

        <div class="step_2 w-[70%] mx-auto flex items-end justify-end">
            <div class="m-10">
                <img class="w-32 rotate-[160deg] mt-1" src="./images/arrow1.svg" alt="">
            </div>
            <div class="relative inline-block">
                <img class="h-[47vh]" src="./images/step2_2x_ba6cg8.avif" alt="">
                <button class="absolute -top-7 -left-[4rem] text-[22px] text-white font-semibold bg-[#453553] px-3 py-1 rounded">2. Remove background</button>
                <button class="absolute top-2 left-[5.9rem] text-[22px] text-white font-semibold bg-[#453553] px-3 py-1 rounded">with AI</button>
            </div>
        </div>

        <div class="step_3 w-[70%] mx-auto flex items-end">
            <div class="relative inline-block">
                <img class="h-[47vh]" src="./images/step3_2x_zydqfi.avif" alt="">
                <button class="absolute -top-7 -right-[4rem] text-[22px] text-white font-semibold bg-[#453553] px-3 py-1 rounded">3. Select pictures and</button>
                <button class="absolute top-2 right-[6.5rem] text-[22px] text-white font-semibold bg-[#453553] px-3 py-1 rounded">save</button>
            </div>
            <div class="m-10">
                <img class="w-32 -rotate-[-25deg] mt-1" src="./images/arrow1_down.svg" alt="">
            </div>
        </div>

        <div class="step_4 w-[70%] mx-auto flex justify-end">
            <div class="relative inline-block">
                <img class="h-[47vh]" src="./images/step4_2x_e5nnpw.avif" alt="">
                <button class="absolute -top-7 -left-[4rem] text-[22px] text-white font-semibold bg-[#453553] px-4 py-1 rounded">Need to edit ?</button>
                <button class="absolute top-2 -left-11 text-[22px] text-white font-semibold bg-[#453553] px-4 py-1 rounded">No problem</button>
            </div>
        </div>

        <div class="w-full bg-[#F4EEFA]">
            <div class="w-[90vw] mx-auto -right-1 h-[50vh]  rounded-3xl flex items-center justify-between px-8 md:px-16">
                <div class="max-w-lg">
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-[#3a3356]">
                        Upload a photo for health analysis
                    </h1>
                </div>

                <div class="flex flex-col items-center">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg mb-2">
                        Upload your photo
                    </button>
                    <p class="text-sm text-gray-600 mb-2">or try this</p>
                    <div class="flex space-x-2">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white">
                            <img src="./images/first.jpg" alt="Sample profile 1" class="w-full h-full object-cover">
                        </div>
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white">
                            <img src="./images/second.jpg" alt="Sample profile 2" class="w-full h-full object-cover">
                        </div>
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white">
                            <img src="./images/third.jpg" alt="Sample profile 3" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- email section  -->
    <section class="w-full h-[50vh] flex justify-center items-center my-5">
        <div class="w-[80%] md:w-[70%] h-[50vh] bg-[#F4EEFA] flex flex-col items-center justify-center  rounded-lg">
            <h1 class="text-[#453553] text-[20px] md:text-[26px] font-medium py-5">Subscribe to us to get news about new
                features.</h1>
            <div class="flex items-center justify-center gap-2 w-[50%]">
                <input class="p-3 w-full rounded outline-none border border-white focus:border-purple-600" type="text"
                    name="" id="" placeholder="Enter your email here">
                <button
                    class="p-3 w-[50%] text-white font-semibold bg-blue-500 hover:bg-blue-700 rounded font-bold">Subscribe</button>

            </div>
            <p class="w-[50%] my-3 text-[12px] text-[#707070 ]">Subscribe to receive regular updates and news. You can
                unsubscribe anytime. For more details, review our <b>Privacy Policy.</b> </p>
        </div>
    </section>

    <!-- footer section  -->
    <!-- bg-[#3b2e58]       -->
    <footer class="w-full bg-blue-500  text-white p-8 flex flex-col">
        <div class="w-[80%] mx-auto flex-grow">
            <div class="flex flex-col md:flex-row md:justify-between">
                <!-- Logo and Brand Section -->
                <div class="mb-8 md:mb-0">
                    <div class="flex items-center mb-2">
                        <div class="relative">
                            <img class="w-16 h-16 rounded-full" src="./images/header-logo.png" class=""
                                alt="header-logo" />

                            <div
                                class="absolute -right-6 bottom-2 rotate-[-10deg] bg-[#2d2241] text-white px-2 py-0.5 text-xs rounded border border-white">
                                beta</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h2 class="text-2xl font-bold text-white">SickorNot<span class="text-gray-300">.io</span></h2>
                        <p class="text-gray-300 text-sm font-medium">AI Health Checker</p>
                    </div>

                    <!-- Social Media Icons -->
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="bg-white bg-opacity-20 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#" class="bg-white bg-opacity-20 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                            </svg>
                        </a>
                        <a href="#" class="bg-white bg-opacity-20 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                    </div>

                    <div class="md:w-[65%] mt-10 py-5 text-[16px] text-gray-300">
                        <p class="py-2">This site is protected by reCAPTCHA and the Google <a href=""
                                class="underline">Privacy Policy</a> and <a href="" class="underline">Terms of
                                Service</a> apply</p>
                        <div class="mt-5 flex gap-4">
                            <span class="text-white">© 2022 - <span id="c_year">2025</span> SickorNot.io</span>
                        </div>

                    </div>

                </div>

                <!-- Links Sections -->
                <div class="grid grid-cols-2 md:grid-cols-2 gap-8">
                    <!-- Resources Column -->
                    <div>
                        <h3 class=" mb-4">Resources</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-white text-[14px] hover:text-blue-800">Use Cases</a></li>
                            <li><a href="#" class="text-white text-[14px] hover:text-blue-800">About Us</a></li>
                            <li><a href="#" class="text-white text-[14px] hover:text-blue-800">Contact Us</a></li>
                            <li><a href="#" class="text-white text-[14px] hover:text-blue-800">Privacy Policy</a></li>
                            <li><a href="#" class="text-white text-[14px] hover:text-blue-800">Terms of Use</a></li>
                        </ul>
                    </div>

                    <!-- Products Column -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Our Services</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-white text-[14px] hover:text-blue-800">AI Health Checker</a>
                            </li>
                            <li><a href="#" class="text-white text-[14px] hover:text-blue-800">Instant Diagnosis</a>
                            </li>
                            <li><a href="#" class="text-white text-[14px] hover:text-blue-800">Health Report
                                    Generator</a></li>
                            <li><a href="#" class="text-white text-[14px] hover:text-blue-800">Symptom Analyzer </a>
                            </li>
                            <li><a href="#" class="text-white text-[14px] hover:text-blue-800">Smart Health Monitor</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


    </footer>

    <script>
        // Toggle mobile menu
        const mobileMenuButton = document.getElementById("mobile-menu-button");
        const mobileMenu = document.getElementById("mobile-menu");

        mobileMenuButton.addEventListener("click", () => {
            mobileMenu.classList.toggle("active");
        });

        let date = new Date();
        let currentyear = date.getFullYear();
        console.log(currentyear);
        document.getElementById("c_year").innerHTML = currentyear;
    </script>

    <script type="module" src="camera.js"></script>
</body>

</html>