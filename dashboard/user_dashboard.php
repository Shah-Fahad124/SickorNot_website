<?php
session_start();
require "../db/config.php";
if(isset($_SESSION['user_email'])){
    $autorizeUser=true;
}else{
    $autorizeUser=false;
}
$query = "SELECT * FROM user_register WHERE user_email = '{$_SESSION['user_email']}'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    body {
      font-family: 'Inter', sans-serif;
    }

    @media (max-width: 768px) {
            .mobile-menu {
                display: none;
            }

            .mobile-menu.active {
                display: flex;
            }
        }
  </style>
</head>
<body class="w-screen h-screen flex flex-col bg-gray-50">
<div class="navbar flex justify-center items-start pt-2 border-b-2">
        <nav class="w-[88vw] px-4 py-1 flex flex-wrap items-center justify-between">
            <!-- Logo Section -->
            <div class="flex items-center">
                <div class=" h-20">
                    <div class="rounded-full h-16 w-16  flex items-center justify-center relative">
                        <div class="bg-blue-500 hover:bg-blue-700 rounded-full overflow-hidden">
                            <img class="object-cover" src="../images/logo.png" class="" alt="header-logo" />
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
            <a href="../index.php" class="text-gray-700 hover:text-blue-700">Home</a>
                <a href="#" class="text-gray-700 hover:text-blue-700">Featured</a>
                <a href="#" class="text-gray-700 hover:text-blue-700">Resources</a>

                <?php echo ($autorizeUser) ?'
                    <a href="../forms/logout.php"
                    class="bg-blue-500 border hover:bg-white hover:text-blue-500 hover:border-blue-500  text-white px-2 py-[2px] rounded-full">Log out
                    </a>':                
                '<a href="../forms/login.php" class="text-gray-700 hover:text-blue-700">Login</a>
                <a href="../forms/signup.php"
                    class="bg-blue-500 border hover:bg-white hover:text-blue-500 hover:border-blue-500  text-white px-2 py-[2px] rounded-full">Sign
                    Up</a>
                '?>
            </div>

            <!-- Mobile Navigation Links (hidden by default) -->
            <div id="mobile-menu" class="mobile-menu mt-2 w-full flex-col items-start  md:hidden">
                <a href="#" class="text-gray-700 hover:text-blue-700 w-full py-1">Featured</a>
                <a href="#" class="text-gray-700 hover:text-blue-700 w-full py-1">Resources</a>

                <?php echo ($autorizeUser) ? '<a href="./dashboard/user_dashboard" class="text-gray-700 hover:text-blue-700 w-full py-1">Dashboard</a>
                    <a href="./forms/logout.php"
                    class="bg-blue-500 hover:bg-blue-700 mt-2 text-white px-4 py-1 rounded-full w-full text-center">Log out
                    </a>':'
                <a href="./forms/login.php" class="text-gray-700 hover:text-blue-700 w-full py-1">Login</a>
                <a href="./forms/signup.php"
                    class="bg-blue-500 hover:bg-blue-700 mt-2 text-white px-4 py-1 rounded-full w-full text-center">Sign
                    Up</a>'
                ?>;
            </div>
        </nav>

    </div>

  <!-- Breadcrumb -->
  <!-- <div class="flex items-center px-10 py-3 bg-white border-b border-gray-200 text-4xl text-blue-500 gap-2">
    <span class="hover:underline cursor-pointer">Admin</span>
    <span>Dashboard</span>
  </div> -->

  <div class="flex flex-1 overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 border-r border-gray-200 bg-white hidden md:block">
      <nav class="p-4 space-y-1">
        <a href="#" class="flex items-center px-3 py-2 text-gray-800 rounded-md bg-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          </svg>
          <span class="font-medium">Users</span>
        </a>
        <a href="#" class="flex items-center px-3 py-2 text-gray-600 rounded-md hover:bg-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
          </svg>
          <span>Settings</span>
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-auto p-6">
      <div class="max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-1"><?php echo ($autorizeUser)?"$row[user_firstname] $row[user_lastname]":"User"?></h1>
        <p class="text-gray-600 mb-6">View and manage your account</p>

        <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
          <div class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
            </div>
            <input
              type="text"
              class="w-full pl-10 pr-4 py-2 border border-blue-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Search"
            />
          </div>
          <div class="flex gap-4">
            <div class="relative">
              <button class="flex items-center justify-between w-full px-4 py-2 text-sm bg-white border border-blue-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <span>Sort by: Joined</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </button>
            </div>
            <button class="px-4 py-2 text-sm text-white bg-blue-500 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
              Create user
            </button>
          </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-md overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  User
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Last signed in
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Joined
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center text-white">
                        <img class="rounded-full" src="../images/first.jpg" alt="">
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">mian2k18aizaz@gmail.com</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  1 week ago
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  Today at 5:11 PM
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center text-white">
                      <img class="rounded-full" src="../images/fifth.png" alt="">
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">test@gmail.com</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  Today
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  Today at 3:02 AM
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center text-white">
                      <img class="rounded-full" src="../images/fourth.jpg" alt="">
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">abbasali31@gmail.com</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  2 days ago
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  Today at 3:02 AM
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <script>
    // Simple toggle for mobile sidebar (if needed)
    function toggleSidebar() {
      const sidebar = document.querySelector('aside');
      sidebar.classList.toggle('hidden');
    }
  </script>
</body>
</html>

