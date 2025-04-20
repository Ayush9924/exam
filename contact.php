<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - SecureExamWatch</title>
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
                    <a href="contact.php" class="text-gray-700 hover:text-exam-primary px-3 py-2 rounded-md text-sm font-medium bg-exam-light">
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
                <a href="contact.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-exam-primary hover:bg-gray-50 bg-exam-light">
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
    
    <!-- Contact Hero Section -->
    <section class="bg-gradient-to-r from-exam-primary to-exam-primary/80 text-white py-16 md:py-20">
        <div class="container px-4 md:px-6 mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Contact SecureExamWatch</h1>
            <p class="text-lg md:text-xl max-w-3xl mx-auto">Have questions or need support? Our team is here to help you with any inquiries.</p>
        </div>
    </section>
    
    <!-- Contact Content Section -->
    <section class="py-16 bg-white">
        <div class="container px-4 md:px-6 mx-auto">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Contact Form -->
                    <div>
                        <h2 class="text-2xl font-bold mb-6 text-exam-dark">Send Us a Message</h2>
                        <form class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-exam-primary focus:border-exam-primary" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-exam-primary focus:border-exam-primary" required>
                            </div>
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                <select id="subject" name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-exam-primary focus:border-exam-primary">
                                    <option value="general">General Inquiry</option>
                                    <option value="technical">Technical Support</option>
                                    <option value="verification">Verification Issue</option>
                                    <option value="feedback">Feedback/Suggestions</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea id="message" name="message" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-exam-primary focus:border-exam-primary" required></textarea>
                            </div>
                            <div>
                                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-exam-primary hover:bg-exam-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary">
                                    Send Message
                                    <i class="fas fa-paper-plane ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-2xl font-bold mb-6 text-exam-dark">Contact Information</h2>
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-exam-primary/10 p-3 rounded-full">
                                    <i class="fas fa-map-marker-alt text-exam-primary"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold">Headquarters</h3>
                                    <p class="text-gray-700 mt-1">Lovely Professional University<br>Phagwara, Punjab 144411<br>India</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-exam-primary/10 p-3 rounded-full">
                                    <i class="fas fa-phone-alt text-exam-primary"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold">Phone</h3>
                                    <p class="text-gray-700 mt-1">
                                        <span class="block">+91 11 2345 6789 (Administration)</span>
                                        <span class="block">+91 98 7654 3210 (Support)</span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-exam-primary/10 p-3 rounded-full">
                                    <i class="fas fa-envelope text-exam-primary"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold">Email</h3>
                                    <p class="text-gray-700 mt-1">
                                        <span class="block">support@secureexamwatch.edu</span>
                                        <span class="block">info@secureexamwatch.edu</span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-exam-primary/10 p-3 rounded-full">
                                    <i class="fas fa-clock text-exam-primary"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold">Support Hours</h3>
                                    <p class="text-gray-700 mt-1">
                                        <span class="block">Monday-Friday: 9:00 AM - 6:00 PM IST</span>
                                        <span class="block">Saturday: 10:00 AM - 4:00 PM IST</span>
                                        <span class="block">Sunday: Closed</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="bg-exam-primary/10 p-3 rounded-full text-exam-primary hover:bg-exam-primary/20">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="bg-exam-primary/10 p-3 rounded-full text-exam-primary hover:bg-exam-primary/20">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="bg-exam-primary/10 p-3 rounded-full text-exam-primary hover:bg-exam-primary/20">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="#" class="bg-exam-primary/10 p-3 rounded-full text-exam-primary hover:bg-exam-primary/20">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Map Section -->
                <div class="mt-16">
                    <h2 class="text-2xl font-bold mb-6 text-exam-dark">Our Location</h2>
                    <div class="bg-gray-100 rounded-lg overflow-hidden">
                        <!-- Embedded Google Map -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3410.755685422843!2d75.70326831513206!3d31.25589898145838!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a5a594d22b88d%3A0x4cc934c58d0992ec!2sLovely%20Professional%20University!5e0!3m2!1sen!2sin!4v1620000000000!5m2!1sen!2sin" 
                                width="100%" 
                                height="450" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy"
                                class="rounded-lg">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="py-16 bg-exam-light">
        <div class="container px-4 md:px-6 mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-12">Frequently Asked Questions</h2>
            
            <div class="max-w-3xl mx-auto">
                <div class="space-y-4">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <button class="faq-question flex justify-between items-center w-full text-left font-semibold text-exam-dark">
                            <span>How do I register for exam verification?</span>
                            <i class="fas fa-chevron-down text-exam-primary"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-700 hidden">
                            You can register by clicking on the "Register as Candidate" button on our homepage. You'll need to provide personal details, exam information, and upload required identification documents.
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <button class="faq-question flex justify-between items-center w-full text-left font-semibold text-exam-dark">
                            <span>What documents are required for verification?</span>
                            <i class="fas fa-chevron-down text-exam-primary"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-700 hidden">
                            Typically, you'll need a government-issued photo ID (Aadhaar, Passport, etc.), your exam registration confirmation, and a recent passport-sized photograph. Specific requirements may vary by exam.
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <button class="faq-question flex justify-between items-center w-full text-left font-semibold text-exam-dark">
                            <span>How long does verification take?</span>
                            <i class="fas fa-chevron-down text-exam-primary"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-700 hidden">
                            Most verifications are completed within 3-5 business days. During peak exam periods, it may take up to 7 business days. You'll receive email notifications at each stage.
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <button class="faq-question flex justify-between items-center w-full text-left font-semibold text-exam-dark">
                            <span>What if my verification is rejected?</span>
                            <i class="fas fa-chevron-down text-exam-primary"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-700 hidden">
                            If your verification is rejected, you'll receive an email explaining the reason. You can correct the issue and resubmit your documents. For complex issues, our support team can assist you.
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-8">
                    <a href="faq.php" class="inline-flex items-center text-exam-primary font-semibold hover:text-exam-primary-dark">
                        View all FAQs
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
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
            
            // FAQ toggle functionality
            const faqQuestions = document.querySelectorAll('.faq-question');
            faqQuestions.forEach(question => {
                question.addEventListener('click', () => {
                    const answer = question.nextElementSibling;
                    const icon = question.querySelector('i');
                    
                    answer.classList.toggle('hidden');
                    icon.classList.toggle('fa-chevron-down');
                    icon.classList.toggle('fa-chevron-up');
                });
            });
        });
    </script>
</body>
</html>