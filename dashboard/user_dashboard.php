<?php
session_start();
require "../db/config.php";
if (isset($_SESSION['user_email'])) {
  $autorizeUser = true;
} else {
  $autorizeUser = false;
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
 <!-- navbar section -->
 <div class="navbar flex justify-center items-center pt-2 border-b">
        <nav class="w-[88vw] px-4 py-1 flex flex-wrap items-center justify-between">
            <!-- Logo Section -->
            <div class="flex py-4">
                <div class="">
                    <div class="flex items-center justify-center relative">
                        <div class=" overflow-hidden  w-[9rem]">
                            <img class="object-cover" src="../images/logo.png" class="" alt="header-logo" />
                        </div>
                        <!-- blue plus icon -->
                        <div
                            class="absolute flex justify-center items-center -bottom-1 -right-1 bg-blue-500 hover:bg-blue-700 rounded-full h-3 w-3 p-0">
                            <h1 class="m-0 text-white text-[1.5rem] leading-none pb-1"><a href="">+</a></h1>
                        </div>
                    </div>
                </div>
                <div class="ml-4 flex flex-col">
                    <span class="font-semibold text-gray-800 text-md">SickorNot<span
                            class="text-blue-500"> .AI</span></span>
                    <div class="bg-gray-700 text-white text-sm flex justify-center w-10 rounded-t ">
                         
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
                <?php echo ($autorizeUser) ? '<a href="../index.php" class="text-gray-700 hover:text-blue-700">Home</a>
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

                <?php echo ($autorizeUser) ? '<a href="../index.php" class="text-gray-700 hover:text-blue-700 w-full py-1">Home</a>
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
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
          </svg>
          <span id="openModalBtn">Check Health</span>
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-auto p-6">
      <div class="max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-1"><?php echo ($autorizeUser) ? "$row[user_firstname] $row[user_lastname]" : "User" ?></h1>
        <p class="text-gray-600 mb-6">View Images with Results</p>

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
              placeholder="Search" />
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
              Create Link
            </button>
          </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-md overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-md font-medium text-gray-500 uppercase tracking-wider">
                  User
                </th>
                <th scope="col" class="px-6 py-3 text-left text-md font-medium text-gray-500 uppercase tracking-wider">
                  Condition
                </th>
                <th scope="col" class="px-6 py-3 text-left text-md font-medium text-gray-500 uppercase tracking-wider">
                  Date
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr>
                <td class="px-6 py-2 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-20 w-20">
                      <div class="h-20 w-20 rounded-full bg-purple-500 flex items-center justify-center text-white overflow-hidden">
                        <img class="rounded-full" src="../images/first.jpg" alt="">
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-md font-medium text-gray-900">Shah Fahad</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-2 whitespace-nowrap text-md text-gray-500">
                  Good
                </td>
                <td class="px-6 py-2 whitespace-nowrap text-md text-gray-500">
                  Saturday at 5:11 PM
                </td>
              </tr>
              <tr>
                <td class="px-6 py-2 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-20 w-20">
                      <div class="h-20 w-20 rounded-full bg-purple-500 flex items-center justify-center text-white overflow-hidden">
                        <img class="rounded-full" src="../images/normal.jpeg" alt="">
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-md font-medium text-gray-900">Danyal Ahmed</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-md text-gray-500">
                  Normal
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-md text-gray-500">
                  Friday at 5:11 PM
                </td>
              </tr>
              <tr>
                <td class="px-6 py-2 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-20 w-20">
                      <div class="h-20 w-20 rounded-full bg-purple-500 flex items-center justify-center text-white overflow-hidden">
                        <img class="rounded-full" src="../images/sad.jpg" alt="">
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-md font-medium text-gray-900">Zeeshan khan</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-md text-gray-500">
                  Bad
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-md text-gray-500">
                  Thursday at 5:11 PM
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>


  <!-- ***************** Modal **************** -->
  <!-- <body class="bg-gray-100 flex items-center justify-center min-h-screen p-4"> -->
  <!-- Button to open modal -->
  <!-- <button id="openModalBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
    Open Image Analysis
  </button> -->

  <!-- Modal (hidden by default) -->
  <div id="modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="w-[90vw] h-[70vh] bg-white rounded-lg flex overflow-hidden shadow-xl">
      <!-- Left sidebar -->
      <div class="w-64 bg-gray-50 p-6 border-r border-gray-200">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-semibold text-gray-800">Control Panel</h2>
          <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
              <path d="M18 6 6 18" />
              <path d="m6 6 12 12" />
            </svg>
          </button>
        </div>

        <p class="text-sm text-gray-600 mb-4">
          Select how you want to provide the image for analysis:
        </p>

        <div class="space-y-2 mb-6">
          <label class="flex items-center space-x-2">
            <input
              type="radio"
              name="uploadMethod"
              value="upload"
              checked
              class="h-4 w-4 text-blue-600" />
            <span class="text-sm">Upload an image</span>
          </label>

          <label class="flex items-center space-x-2">
            <input
              type="radio"
              name="uploadMethod"
              value="photo"
              class="h-4 w-4 text-blue-600" />
            <span class="text-sm">Take a photo</span>
          </label>
        </div>

        <div id="uploadSection">
          <p class="text-xs text-gray-500 mb-2">
            Upload an image (jpg, jpeg, png, jif)
          </p>

          <div
            id="dropArea"
            class="border-2 border-dashed border-gray-300 rounded-md p-4 text-center cursor-pointer hover:bg-gray-50 transition-colors">
            <p class="text-sm text-gray-500 mb-1">Drag and drop file here</p>
            <p class="text-xs text-gray-400">Limit 200MB per file • JPG, JPEG, PNG, JIF</p>

            <button id="browseBtn" class="mt-4 px-3 py-1.5 text-sm bg-white border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
              Browse files
            </button>

            <input
              type="file"
              id="fileInput"
              accept=".jpg,.jpeg,.png,.jif"
              class="hidden" />
          </div>

          <div id="filePreview" class="mt-4 flex items-center justify-between bg-gray-100 p-2 rounded hidden">
            <div class="flex items-center">
              <div class="text-blue-500 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                </svg>
              </div>
              <div>
                <p id="fileName" class="text-xs font-medium text-gray-700 truncate"></p>
                <p id="fileSize" class="text-xs text-gray-500"></p>
              </div>
            </div>
            <button id="removeFileBtn" class="text-gray-400 hover:text-gray-600">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Main content area -->
      <div class="flex-1 flex flex-col">
        <!-- Image preview area -->
        <div class="flex-1 bg-gray-900 flex items-center justify-center p-4 relative">
          <div id="noImageSelected" class="text-gray-400 text-center">
            <p>No image selected</p>
            <p class="text-sm">Upload an image to see preview</p>
          </div>

          <div id="imagePreviewContainer" class="relative max-h-full max-w-full hidden flex items-center justify-center">
            <img
              id="imagePreview"
              src="/placeholder.svg"
              alt="Preview"
              class="max-w-full max-h-full object-contain" />
          </div>
        </div>

        <!-- Footer -->
        <div class="h-12 bg-gray-800 flex items-center justify-center text-white text-sm">
          <span id="screenName">Image Analysis Preview</span>
        </div>
      </div>


    </div>
  </div>

  <script>
    // DOM Elements
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modal = document.getElementById('modal');
    const fileInput = document.getElementById('fileInput');
    const browseBtn = document.getElementById('browseBtn');
    const dropArea = document.getElementById('dropArea');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFileBtn = document.getElementById('removeFileBtn');
    const noImageSelected = document.getElementById('noImageSelected');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const uploadMethodRadios = document.querySelectorAll('input[name="uploadMethod"]');
    const uploadSection = document.getElementById('uploadSection');
    const deployBtn = document.getElementById('deployBtn');

    // Open modal
    openModalBtn.addEventListener('click', () => {
      modal.classList.remove('hidden');
    });

    // Close modal
    closeModalBtn.addEventListener('click', () => {
      modal.classList.add('hidden');
    });

    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.add('hidden');
      }
    });

    // Trigger file input only when clicking browse button
    browseBtn.addEventListener('click', (e) => {
      e.stopPropagation(); // Prevent event from bubbling up to dropArea
      fileInput.click();
    });

    // Click on drop area to select file (only if not clicking the browse button)
    dropArea.addEventListener('click', (e) => {
      if (e.target !== browseBtn) {
        fileInput.click();
      }
    });


    // Handle file selection
    fileInput.addEventListener('change', handleFileSelect);

    // Handle drag and drop
    dropArea.addEventListener('dragover', (e) => {
      e.preventDefault();
      dropArea.classList.add('border-blue-500');
    });

    dropArea.addEventListener('dragleave', () => {
      dropArea.classList.remove('border-blue-500');
    });

    dropArea.addEventListener('drop', (e) => {
      e.preventDefault();
      dropArea.classList.remove('border-blue-500');

      if (e.dataTransfer.files.length) {
        handleFiles(e.dataTransfer.files[0]);
      }
    });

    // Click on drop area to select file
    dropArea.addEventListener('click', () => {
      fileInput.click();
    });

    // Remove selected file
    removeFileBtn.addEventListener('click', () => {
      resetFileSelection();
    });

    // Toggle upload method
    uploadMethodRadios.forEach(radio => {
      radio.addEventListener('change', (e) => {
        if (e.target.value === 'upload') {
          uploadSection.classList.remove('hidden');
        } else {
          uploadSection.classList.add('hidden');
        }
      });
    });

    // Handle file selection
    function handleFileSelect(e) {
      if (e.target.files.length) {
        handleFiles(e.target.files[0]);
      }
    }

    // Process selected file
    function handleFiles(file) {
      // Check if file is an image
      if (!file.type.match('image.*')) {
        alert('Please select an image file (JPG, JPEG, PNG)');
        return;
      }

      // Display file info
      fileName.textContent = file.name;
      fileSize.textContent = `${(file.size / (1024 * 1024)).toFixed(1)}MB`;
      filePreview.classList.remove('hidden');

      // Show image preview
      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreview.src = e.target.result;
        noImageSelected.classList.add('hidden');
        imagePreviewContainer.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    }

    // Reset file selection
    function resetFileSelection() {
      fileInput.value = '';
      filePreview.classList.add('hidden');
      noImageSelected.classList.remove('hidden');
      imagePreviewContainer.classList.add('hidden');
    }

    // Deploy button functionality (placeholder)
    deployBtn.addEventListener('click', () => {
      alert('Deploying image analysis...');
    });


    // Simple toggle for mobile sidebar (if needed)
    function toggleSidebar() {
      const sidebar = document.querySelector('aside');
      sidebar.classList.toggle('hidden');
    }
  </script>

</body>

</html>