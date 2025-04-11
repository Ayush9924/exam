
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureExamWatch - Secure Exam Authentication System</title>
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
                    <a href="login.php" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-exam-primary bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary">
                        Login
                    </a>
                    <a href="register.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-exam-primary hover:bg-exam-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary">
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
                <a href="login.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-exam-primary hover:bg-gray-50">
                    Login
                </a>
                <a href="register.php" class="block px-3 py-2 rounded-md text-base font-medium bg-exam-primary text-white hover:bg-exam-primary-dark rounded-md">
                    Register
                </a>
            </div>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-exam-primary to-exam-primary/80 text-white py-16 md:py-24">
        <div class="container px-4 md:px-6 mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div>
                    <h1 class="text-3xl md:text-5xl font-bold mb-4">
                        Secure Exam Authentication System
                    </h1>
                    <p class="text-xl md:text-2xl mb-6 text-white/90">
                        Ensuring integrity in DBT, JRF, JNU-CET, and BITP examinations
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="register.php" class="inline-flex justify-center items-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-exam-primary bg-white hover:bg-white/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                            Register as Candidate
                        </a>
                        <a href="login.php" class="inline-flex justify-center items-center px-5 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                            Admin Login
                        </a>
                    </div>
                </div>
                <div class="hidden md:flex justify-center">
                    <div class="bg-white/10 p-6 rounded-lg backdrop-blur-sm">
                        <i class="fas fa-shield-check text-white text-9xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Alert Banner -->
    <section class="bg-amber-50 border-y border-amber-200">
        <div class="container py-3 px-4 mx-auto">
            <div class="flex border-l-4 border-amber-500 p-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-amber-600"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-amber-800">Important Notice</h3>
                    <div class="text-sm text-amber-700">
                        Impersonation in exams leads to immediate disqualification and can result in legal actions. Ensure your identity is verified before the exam.
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container px-4 md:px-6 mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-12">How It Works</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex flex-col items-center text-center p-6 bg-exam-light rounded-lg shadow-sm">
                    <div class="bg-exam-primary/10 p-3 rounded-full mb-4">
                        <i class="fas fa-user-plus text-exam-primary text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">1. Register</h3>
                    <p class="text-gray-600">Complete the registration process with your details and upload your identification documents.</p>
                </div>
                
                <div class="flex flex-col items-center text-center p-6 bg-exam-light rounded-lg shadow-sm">
                    <div class="bg-exam-primary/10 p-3 rounded-full mb-4">
                        <i class="fas fa-check-circle text-exam-primary text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">2. Verify</h3>
                    <p class="text-gray-600">Our system verifies your identity through both automated checks and manual verification by administrators.</p>
                </div>
                
                <div class="flex flex-col items-center text-center p-6 bg-exam-light rounded-lg shadow-sm">
                    <div class="bg-exam-primary/10 p-3 rounded-full mb-4">
                        <i class="fas fa-file-alt text-exam-primary text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">3. Access Exam</h3>
                    <p class="text-gray-600">Once verified, access your secure exam dashboard with links to your scheduled exams.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Exam Logos Section -->
    <section class="py-12 bg-gray-50">
        <div class="container px-4 md:px-6 mx-auto">
            <h2 class="text-xl font-semibold text-center text-gray-700 mb-8">Supported Examinations</h2>
            
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16">
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-white rounded-full shadow-sm flex items-center justify-center mb-2">
                        <span class="text-2xl font-bold text-exam-primary">DBT</span>
                    </div>
                    <span class="text-sm text-gray-600">Department of Biotechnology</span>
                </div>
                
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-white rounded-full shadow-sm flex items-center justify-center mb-2">
                        <span class="text-2xl font-bold text-exam-primary">JRF</span>
                    </div>
                    <span class="text-sm text-gray-600">Junior Research Fellowship</span>
                </div>
                
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-white rounded-full shadow-sm flex items-center justify-center mb-2">
                        <span class="text-2xl font-bold text-exam-primary">JNU</span>
                    </div>
                    <span class="text-sm text-gray-600">Jawaharlal Nehru University</span>
                </div>
                
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-white rounded-full shadow-sm flex items-center justify-center mb-2">
                        <span class="text-2xl font-bold text-exam-primary">BITP</span>
                    </div>
                    <span class="text-sm text-gray-600">Biotechnology Test Portal</span>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonial Section -->
    <section class="py-16 bg-white">
        <div class="container px-4 md:px-6 mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-12">Trusted By Institutions</h2>
            
            <div class="max-w-3xl mx-auto bg-exam-light p-8 rounded-lg shadow-sm">
                <div class="flex flex-col md:flex-row gap-6 items-center">
                    <div class="shrink-0">
                        <div class="w-20 h-20 bg-exam-primary rounded-full flex items-center justify-center text-white text-xl font-bold">
                            JNU
                        </div>
                    </div>
                    <div>
                        <blockquote class="text-gray-700 italic mb-4">
                            "The SecureExamWatch system has significantly reduced impersonation cases in our entrance examinations. The face verification technology is reliable and has streamlined our verification process."
                        </blockquote>
                        <div class="font-semibold">Dr. Rajesh Kumar</div>
                        <div class="text-sm text-gray-600">Examination Controller, JNU</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-exam-dark text-white py-12 mt-auto">
        <div class="container px-4 md:px-6 mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-shield-alt text-exam-secondary"></i>
                        <span class="ml-2 text-lg font-bold">SecureExamWatch</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Ensuring exam integrity through advanced identity verification technology.
                    </p>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="index.php" class="hover:text-white">Home</a></li>
                        <li><a href="about.php" class="hover:text-white">About Us</a></li>
                        <li><a href="contact.php" class="hover:text-white">Contact</a></li>
                        <li><a href="faq.php" class="hover:text-white">FAQs</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-4">Exams</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">DBT-JRF</a></li>
                        <li><a href="#" class="hover:text-white">JNU-CET</a></li>
                        <li><a href="#" class="hover:text-white">BITP</a></li>
                        <li><a href="#" class="hover:text-white">Other Exams</a></li>
                    </ul>
                </div>
                
                <div>
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
    </script>
</body>
</html>