<?php
session_start();

// Initialize variables
$candidateRollNo = '';
$candidateAadhaar = '';
$adminEmail = '';
$adminPassword = '';
$loginError = '';
$activeTab = 'candidate';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['login_type']) && $_POST['login_type'] === 'candidate') {
        // Handle candidate login
        $candidateRollNo = $_POST['rollNo'] ?? '';
        $candidateAadhaar = $_POST['aadhaar'] ?? '';
        
        // Validate inputs
        if (empty($candidateRollNo) || empty($candidateAadhaar)) {
            $loginError = 'Please enter both roll number and Aadhaar';
        } else {
            // Check credentials against stored candidates
            $candidates_file = 'data/candidates.json';
            if (file_exists($candidates_file)) {
                $candidates = json_decode(file_get_contents($candidates_file), true);
                
                if (isset($candidates[$candidateRollNo])) {
                    $candidate = $candidates[$candidateRollNo];
                    // Check if the last 4 digits of Aadhaar match
                    if (substr($candidate['aadhaarNumber'], -4) === $candidateAadhaar) {
                        // Login successful
                        $_SESSION['user'] = [
                            'type' => 'candidate',
                            'rollNo' => $candidateRollNo,
                            'name' => $candidate['fullName']
                        ];
                        
                        // Redirect to candidate dashboard
                        header('Location: candidate-dashboard.php');
                        exit;
                    } else {
                        $loginError = 'Invalid roll number or Aadhaar';
                    }
                } else {
                    $loginError = 'Invalid roll number or Aadhaar';
                }
            } else {
                $loginError = 'No registered candidates found';
            }
        }
        $activeTab = 'candidate';
    } elseif (isset($_POST['login_type']) && $_POST['login_type'] === 'admin') {
        // Handle admin login
        $adminEmail = $_POST['email'] ?? '';
        $adminPassword = $_POST['password'] ?? '';
        
        // Validate inputs
        if (empty($adminEmail) || empty($adminPassword)) {
            $loginError = 'Please enter both email and password';
        } else {
            // For demo purposes, use hardcoded admin credentials
            // In a real application, this would check against a database
            if ($adminEmail === 'karanjio2001@gmail.com' && $adminPassword === 'Mylife.9924') {
                // Login successful
                $_SESSION['user'] = [
                    'type' => 'admin',
                    'email' => $adminEmail,
                    'name' => 'Admin User'
                ];
                
                // Redirect to admin dashboard
                header('Location: admin-dashboard.php');
                exit;
            } else {
                $loginError = 'Invalid email or password';
            }
        }
        $activeTab = 'admin';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SecureExamWatch</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'exam-primary': '#3B82F6',
                        'exam-primary-dark': '#2563EB',
                        'exam-light': '#F0F9FF',
                        'exam-dark': '#1E3A8A',
                        'exam-secondary': '#60A5FA'
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php" class="flex items-center">
                        <i class="fas fa-shield-alt text-exam-primary text-2xl"></i>
                        <span class="ml-2 text-xl font-bold text-exam-primary">SecureExamWatch</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-4">
                    <a href="index.php" class="text-gray-700 hover:text-exam-primary px-3 py-2 rounded-md text-sm font-medium">
                        Home
                    </a>
                    <a href="about.php" class="text-gray-700 hover:text-exam-primary px-3 py-2 rounded-md text-sm font-medium">
                        About
                    </a>
                    <a href="contact.php" class="text-gray-700 hover:text-exam-primary px-3 py-2 rounded-md text-sm font-medium">
                        Contact
                    </a>
                    <a href="login.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-exam-primary hover:bg-exam-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary">
                        Login
                    </a>
                    <a href="register.php" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-exam-primary bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary">
                        Register
                    </a>
                </div>
                
                <div class="flex md:hidden items-center">
                    <button type="button" class="mobile-menu-button text-gray-700 hover:text-exam-primary">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu, toggle classes based on menu state. -->
        <div class="mobile-menu hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="index.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-exam-primary hover:bg-gray-50">
                    Home
                </a>
                <a href="about.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-exam-primary hover:bg-gray-50">
                    About
                </a>
                <a href="contact.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-exam-primary hover:bg-gray-50">
                    Contact
                </a>
                <a href="login.php" class="block px-3 py-2 rounded-md text-base font-medium bg-exam-primary text-white hover:bg-exam-primary-dark">
                    Login
                </a>
                <a href="register.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-exam-primary hover:bg-gray-50">
                    Register
                </a>
            </div>
        </div>
    </header>
    
    <div class="flex-1 flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="mx-auto h-12 w-12 rounded-full bg-exam-primary/10 flex items-center justify-center">
                    <i class="fas fa-shield-check text-exam-primary text-2xl"></i>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Log in to your account
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Access your secure portal for exams and verification
                </p>
            </div>
            
            <?php if (!empty($loginError)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <?= htmlspecialchars($loginError) ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <div class="flex border-b border-gray-200">
                    <button 
                        type="button" 
                        class="candidate-tab flex-1 py-4 px-4 text-center text-sm font-medium <?= $activeTab === 'candidate' ? 'text-exam-primary border-b-2 border-exam-primary' : 'text-gray-500 hover:text-gray-700' ?>"
                        onclick="switchTab('candidate')"
                    >
                        Candidate
                    </button>
                    <button 
                        type="button" 
                        class="admin-tab flex-1 py-4 px-4 text-center text-sm font-medium <?= $activeTab === 'admin' ? 'text-exam-primary border-b-2 border-exam-primary' : 'text-gray-500 hover:text-gray-700' ?>"
                        onclick="switchTab('admin')"
                    >
                        Administrator
                    </button>
                </div>
                
                <!-- Candidate Login Form -->
                <div id="candidate-form" class="<?= $activeTab === 'candidate' ? 'block' : 'hidden' ?> p-6 space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Candidate Login</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Enter your exam roll number and Aadhaar details to access your exam portal
                        </p>
                    </div>
                    
                    <form method="POST" class="space-y-4">
                        <input type="hidden" name="login_type" value="candidate">
                        
                        <div class="space-y-2">
                            <label for="rollNo" class="block text-sm font-medium text-gray-700">Exam Roll Number</label>
                            <input
                                id="rollNo"
                                name="rollNo"
                                type="text"
                                placeholder="e.g. DBT2025001"
                                value="<?= htmlspecialchars($candidateRollNo) ?>"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-exam-primary focus:border-exam-primary"
                                required
                            >
                        </div>
                        <div class="space-y-2">
                            <label for="aadhaar" class="block text-sm font-medium text-gray-700">Aadhaar Number (Last 4 digits)</label>
                            <input
                                id="aadhaar"
                                name="aadhaar"
                                type="password"
                                placeholder="Enter last 4 digits"
                                maxlength="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-exam-primary focus:border-exam-primary"
                                required
                            >
                            <p class="text-sm text-gray-500">
                                For security, only enter the last 4 digits of your Aadhaar
                            </p>
                        </div>
                        
                        <div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-exam-primary hover:bg-exam-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary">
                                Log in
                            </button>
                        </div>
                        
                        <div class="text-sm text-center">
                            <p class="text-gray-600">
                                Don't have an account? 
                                <a href="register.php" class="text-exam-primary font-medium hover:underline">
                                    Register here
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
                
                <!-- Admin Login Form -->
                <div id="admin-form" class="<?= $activeTab === 'admin' ? 'block' : 'hidden' ?> p-6 space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Administrator Login</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Secure access for authorized exam administrators
                        </p>
                    </div>
                    
                    <form method="POST" class="space-y-4">
                        <input type="hidden" name="login_type" value="admin">
                        
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                placeholder="admin@example.com"
                                value="<?= htmlspecialchars($adminEmail) ?>"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-exam-primary focus:border-exam-primary"
                                required
                            >
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <a
                                    href="#"
                                    class="text-sm text-exam-primary hover:underline"
                                >
                                    Forgot password?
                                </a>
                            </div>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="Enter your password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-exam-primary focus:border-exam-primary"
                                required
                            >
                        </div>
                        
                        <div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-exam-primary hover:bg-exam-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary">
                                Log in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-gray-50 text-gray-500">
                            Need help?
                        </span>
                    </div>
                </div>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="contact.php" class="text-sm text-exam-primary hover:underline">
                        Contact Support
                    </a>
                    <span class="text-gray-300">|</span>
                    <a href="faq.php" class="text-sm text-exam-primary hover:underline">
                        FAQs
                    </a>
                </div>
            </div>
            
            <div class="mt-8 border border-gray-200 rounded-md p-4 bg-white">
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p>
                        All data is encrypted and securely stored in compliance with government regulations.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="bg-exam-dark text-white py-8 mt-auto">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-between">
                <div class="w-full md:w-1/4 mb-6 md:mb-0">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-shield-alt text-exam-secondary"></i>
                        <span class="ml-2 text-lg font-bold">SecureExamWatch</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Ensuring exam integrity through advanced identity verification technology.
                    </p>
                </div>
                
                <div class="w-full md:w-1/4 mb-6 md:mb-0">
                    <h3 class="font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="index.php" class="hover:text-white">Home</a></li>
                        <li><a href="about.php" class="hover:text-white">About Us</a></li>
                        <li><a href="contact.php" class="hover:text-white">Contact</a></li>
                        <li><a href="faq.php" class="hover:text-white">FAQs</a></li>
                    </ul>
                </div>
                
                <div class="w-full md:w-1/4 mb-6 md:mb-0">
                    <h3 class="font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            +91 11 2345 6789
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            support@secureexamwatch.edu
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            New Delhi, India
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-sm mb-4 md:mb-0">
                    &copy; 2025 SecureExamWatch. All rights reserved.
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        // Toggle mobile menu
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('.mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
        
        // Switch tabs function
        function switchTab(tab) {
            // Update tab buttons
            document.querySelector('.candidate-tab').classList.toggle('text-exam-primary', tab === 'candidate');
            document.querySelector('.candidate-tab').classList.toggle('border-b-2', tab === 'candidate');
            document.querySelector('.candidate-tab').classList.toggle('border-exam-primary', tab === 'candidate');
            document.querySelector('.candidate-tab').classList.toggle('text-gray-500', tab !== 'candidate');
            
            document.querySelector('.admin-tab').classList.toggle('text-exam-primary', tab === 'admin');
            document.querySelector('.admin-tab').classList.toggle('border-b-2', tab === 'admin');
            document.querySelector('.admin-tab').classList.toggle('border-exam-primary', tab === 'admin');
            document.querySelector('.admin-tab').classList.toggle('text-gray-500', tab !== 'admin');
            
            // Show/hide forms
            document.getElementById('candidate-form').classList.toggle('hidden', tab !== 'candidate');
            document.getElementById('admin-form').classList.toggle('hidden', tab !== 'admin');
        }
    </script>
</body>
</html>