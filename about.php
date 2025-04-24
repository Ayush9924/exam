<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - SecureExamWatch</title>
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
                    <a href="about.php" class="text-gray-700 hover:text-exam-primary px-3 py-2 rounded-md text-sm font-medium bg-exam-light">
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
                <a href="about.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-exam-primary hover:bg-gray-50 bg-exam-light">
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
    
    <!-- About Hero Section -->
    <section class="bg-gradient-to-r from-exam-primary to-exam-primary/80 text-white py-16 md:py-20">
        <div class="container px-4 md:px-6 mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">About SecureExamWatch</h1>
            <p class="text-lg md:text-xl max-w-3xl mx-auto">Our mission is to ensure the integrity of high-stakes examinations through advanced identity verification technology.</p>
        </div>
    </section>
    
    <!-- About Content Section -->
    <section class="py-16 bg-white">
        <div class="container px-4 md:px-6 mx-auto">
            <div class="max-w-4xl mx-auto">
                <div class="mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6 text-exam-dark">Our Story</h2>
                    <p class="text-gray-700 mb-4">
                        SecureExamWatch was founded in 2025 in response to growing concerns about impersonation and cheating in high-stakes examinations. Our team of academic professionals and technology experts recognized the need for a robust solution that could verify candidate identities with high accuracy while maintaining ease of use.
                    </p>
                    <p class="text-gray-700">
                        Today, we partner with leading educational institutions and examination bodies across India to ensure the integrity of their examination processes. Our system has successfully verified over 100,000 candidates with a 99.8% accuracy rate.
                    </p>
                </div>
                
                <div class="mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6 text-exam-dark">Our Technology</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="bg-exam-light p-6 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="bg-exam-primary/10 p-2 rounded-full mr-4">
                                    <i class="fas fa-user-shield text-exam-primary"></i>
                                </div>
                                <h3 class="text-xl font-semibold">Biometric Verification</h3>
                            </div>
                            <p class="text-gray-700">
                                Our advanced facial recognition system compares live candidate images with registered ID documents to prevent impersonation.
                            </p>
                        </div>
                        <div class="bg-exam-light p-6 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="bg-exam-primary/10 p-2 rounded-full mr-4">
                                    <i class="fas fa-lock text-exam-primary"></i>
                                </div>
                                <h3 class="text-xl font-semibold">Secure Platform</h3>
                            </div>
                            <p class="text-gray-700">
                                End-to-end encrypted platform ensures all candidate data remains confidential and protected from unauthorized access.
                            </p>
                        </div>
                        <div class="bg-exam-light p-6 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="bg-exam-primary/10 p-2 rounded-full mr-4">
                                    <i class="fas fa-bolt text-exam-primary"></i>
                                </div>
                                <h3 class="text-xl font-semibold">Real-time Monitoring</h3>
                            </div>
                            <p class="text-gray-700">
                                Live proctoring features flag suspicious behavior during examinations for immediate review by administrators.
                            </p>
                        </div>
                        <div class="bg-exam-light p-6 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="bg-exam-primary/10 p-2 rounded-full mr-4">
                                    <i class="fas fa-chart-line text-exam-primary"></i>
                                </div>
                                <h3 class="text-xl font-semibold">Analytics Dashboard</h3>
                            </div>
                            <p class="text-gray-700">
                                Comprehensive reporting tools help institutions identify patterns and improve examination security measures.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6 text-exam-dark">Our Team</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="w-32 h-32 mx-auto mb-4 bg-exam-primary/10 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-tie text-exam-primary text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-1">Kumar Ayush</h3>
                            <p class="text-gray-600 mb-2">Founder</p>
                            <p class="text-gray-700 text-sm">
                                Former examination controller with 15+ years experience in academic administration.
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-32 h-32 mx-auto mb-4 bg-exam-primary/10 rounded-full flex items-center justify-center">
                                <i class="fas fa-laptop-code text-exam-primary text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-1">krishna Saha</h3>
                            <p class="text-gray-600 mb-2">CTO</p>
                            <p class="text-gray-700 text-sm">
                                AI and computer vision expert specializing in biometric authentication systems.
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-32 h-32 mx-auto mb-4 bg-exam-primary/10 rounded-full flex items-center justify-center">
                                <i class="fas fa-shield-alt text-exam-primary text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-1">Anubhav</h3>
                            <p class="text-gray-600 mb-2">Security Lead</p>
                            <p class="text-gray-700 text-sm">
                                Cybersecurity specialist focused on protecting sensitive examination data.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold mb-6 text-exam-dark">Our Partners</h2>
                    <div class="bg-exam-light p-6 rounded-lg">
                        <div class="flex flex-wrap justify-center items-center gap-8">
                            <div class="w-24 h-24 bg-white rounded-full shadow-sm flex items-center justify-center">
                                <span class="text-xl font-bold text-exam-primary">JNU</span>
                            </div>
                            <div class="w-24 h-24 bg-white rounded-full shadow-sm flex items-center justify-center">
                                <span class="text-xl font-bold text-exam-primary">DBT</span>
                            </div>
                            <div class="w-24 h-24 bg-white rounded-full shadow-sm flex items-center justify-center">
                                <span class="text-xl font-bold text-exam-primary">UGC</span>
                            </div>
                            <div class="w-24 h-24 bg-white rounded-full shadow-sm flex items-center justify-center">
                                <span class="text-xl font-bold text-exam-primary">BITP</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="py-16 bg-exam-dark text-white">
        <div class="container px-4 md:px-6 mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-12">By The Numbers</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold mb-2">100K+</div>
                    <div class="text-gray-400">Candidates Verified</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">99.8%</div>
                    <div class="text-gray-400">Accuracy Rate</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">50+</div>
                    <div class="text-gray-400">Partner Institutions</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <div class="text-gray-400">Support Available</div>
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
                            LPU@secureexamwatch.edu
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Punjab, India
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