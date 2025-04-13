<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['type'] !== 'candidate') {
    header('Location: login.php');
    exit;
}

// Get candidate data
$candidates_file = 'data/candidates.json';
$exams_file = 'data/exams.json';
$userData = null;
$upcomingExams = [];

if (file_exists($candidates_file)) {
    $candidates = json_decode(file_get_contents($candidates_file), true);
    $rollNo = $_SESSION['user']['rollNo'];
    
    if (isset($candidates[$rollNo])) {
        $candidateData = $candidates[$rollNo];
        
        $userData = [
            'fullName' => $candidateData['fullName'],
            'examRollNo' => $rollNo,
            'examType' => $candidateData['examType'],
            'registrationDate' => $candidateData['registrationDate'],
            'isVerified' => $candidateData['isVerified'],
            'email' => $candidateData['email']
        ];
    }
}

// Get upcoming exams if verified
if ($userData && $userData['isVerified'] && file_exists($exams_file)) {
    $allExams = json_decode(file_get_contents($exams_file), true);
    $today = date('Y-m-d');
    
    foreach ($allExams as $exam) {
        if ($exam['isPublished'] && $exam['examDate'] >= $today) {
            $upcomingExams[] = $exam;
        }
    }
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Dashboard - SecureExamWatch</title>
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
<body class="min-h-screen flex flex-col bg-gray-50">
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
                
                <div class="hidden md:flex items-center">
                    <form method="POST" class="ml-4">
                        <button 
                            type="submit" 
                            name="logout" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary"
                        >
                            Logout
                        </button>
                    </form>
                </div>
                
                <div class="flex md:hidden items-center">
                    <button type="button" class="mobile-menu-button text-gray-700 hover:text-exam-primary">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="mobile-menu hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <form method="POST" class="block">
                    <button 
                        type="submit" 
                        name="logout" 
                        class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-exam-primary hover:bg-gray-50"
                    >
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Candidate Dashboard</h1>
                <p class="text-gray-600">Welcome, <?= htmlspecialchars($userData['fullName']) ?></p>
            </div>
            <form method="POST" class="mt-4 md:mt-0 md:hidden">
                <button 
                    type="submit" 
                    name="logout" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary"
                >
                    Logout
                </button>
            </form>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden md:col-span-1">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>
                    <p class="mt-1 text-sm text-gray-600">Your personal and exam details</p>
                </div>
                <div class="px-4 py-5 sm:p-6 border-t border-gray-200">
                    <div class="flex justify-center mb-4">
                        <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-user text-gray-500 text-3xl"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Full Name</p>
                            <p class="font-medium"><?= htmlspecialchars($userData['fullName']) ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Exam Roll Number</p>
                            <p class="font-medium"><?= htmlspecialchars($userData['examRollNo']) ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Exam Type</p>
                            <p class="font-medium"><?= htmlspecialchars($userData['examType']) ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium"><?= htmlspecialchars($userData['email']) ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Registered On</p>
                            <p class="font-medium">
                                <?= $userData['registrationDate'] ? date('d M Y', strtotime($userData['registrationDate'])) : "N/A" ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="bg-white shadow rounded-lg overflow-hidden md:col-span-2">
                <!-- Verification Status Section -->
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-medium text-gray-900">Verification Status</h2>
                    <p class="mt-1 text-sm text-gray-600">Your identity verification status</p>
                </div>
                <div class="px-4 py-5 sm:p-6 border-t border-gray-200 space-y-6">
                    <div class="bg-gray-100 p-4 rounded-md">
                        <div class="flex items-center">
                            <?php if ($userData['isVerified']): ?>
                            <i class="fas fa-check-circle text-green-500 text-2xl mr-3"></i>
                            <?php else: ?>
                            <i class="fas fa-clock text-amber-500 text-2xl mr-3"></i>
                            <?php endif; ?>
                            <div>
                                <h3 class="font-medium text-lg">
                                    <?= $userData['isVerified'] ? "Verified" : "Pending Verification" ?>
                                </h3>
                                <p class="text-gray-600">
                                    <?= $userData['isVerified'] 
                                        ? "Your identity has been verified. You can now access your exam portal." 
                                        : "Your identity verification is pending admin approval." ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (!$userData['isVerified']): ?>
                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-amber-500"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-amber-800">Verification Required</h3>
                                <div class="mt-2 text-sm text-amber-700">
                                    <p>
                                        Your identity verification is pending. Once verified, you will be able to access your exam portal.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($userData['isVerified']): ?>
                    <div class="bg-green-50 border-l-4 border-green-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800">Verification Completed</h3>
                                <div class="mt-2 text-sm text-green-700">
                                    <p>
                                        Your identity has been verified successfully. You can now access your exam portal.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <hr class="border-gray-200">
                    
                    <!-- Exam Portal Section -->
                    <div class="space-y-4">
                        <h3 class="font-medium">Exam Portal</h3>
                        
                        <?php if ($userData['isVerified']): ?>
                            <?php if (!empty($upcomingExams)): ?>
                                <div class="space-y-4">
                                    <h4 class="font-medium text-gray-900">Upcoming Exams</h4>
                                    
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Exam</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Time</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                                <?php foreach ($upcomingExams as $exam): ?>
                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                        <?= htmlspecialchars($exam['examTitle']) ?>
                                                        <div class="text-xs text-gray-500"><?= htmlspecialchars($exam['examCode']) ?></div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                        <?= date('d M Y', strtotime($exam['examDate'])) ?>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                        <?= htmlspecialchars($exam['examTime']) ?>
                                                        <?php if (!empty($exam['examDuration'])): ?>
                                                            <div class="text-xs">(<?= htmlspecialchars($exam['examDuration']) ?> mins)</div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                        <a 
                                                            href="exam-portal.php?exam_id=<?= urlencode($exam['id']) ?>" 
                                                            class="text-exam-primary hover:text-exam-primary-dark"
                                                        >
                                                            Enter Exam
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-info-circle text-blue-500"></i>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-blue-800">Exam Instructions</h3>
                                                <div class="mt-2 text-sm text-blue-700">
                                                    <ul class="list-disc pl-5 space-y-1">
                                                        <li>Ensure you have a stable internet connection</li>
                                                        <li>Close all other applications before starting</li>
                                                        <li>You will need a webcam for proctoring</li>
                                                        <li>Exam will be automatically submitted when time expires</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-times text-gray-500 text-2xl mr-3"></i>
                                        <div>
                                            <h3 class="font-medium text-lg">No Upcoming Exams</h3>
                                            <p class="text-gray-600">
                                                There are currently no scheduled exams for you. Please check back later.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="space-y-2">
                                <div class="flex items-start gap-3">
                                    <div class="bg-amber-100 text-amber-700 rounded-full h-6 w-6 flex items-center justify-center flex-shrink-0 mt-0.5">1</div>
                                    <p>Wait for admin verification of your identity documents.</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="bg-amber-100 text-amber-700 rounded-full h-6 w-6 flex items-center justify-center flex-shrink-0 mt-0.5">2</div>
                                    <p>You will receive an email notification once verified.</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="bg-amber-100 text-amber-700 rounded-full h-6 w-6 flex items-center justify-center flex-shrink-0 mt-0.5">3</div>
                                    <p>After verification, you can access your exam portal.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
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
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-sm mb-4 md:mb-0">
                    &copy; 2025 SecureExamWatch. All rights reserved.
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