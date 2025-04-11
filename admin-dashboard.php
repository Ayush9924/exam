<?php
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['user']['type'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Handle candidate verification
if (isset($_POST['verify_candidate']) && isset($_POST['candidate_id'])) {
    $candidate_id = $_POST['candidate_id'];
    $candidates_file = 'data/candidates.json';
    
    if (file_exists($candidates_file)) {
        $candidates = json_decode(file_get_contents($candidates_file), true);
        
        if (isset($candidates[$candidate_id])) {
            // Update verification status
            $candidates[$candidate_id]['isVerified'] = true;
            
            // Save changes
            file_put_contents($candidates_file, json_encode($candidates, JSON_PRETTY_PRINT));
            
            // Set success message
            $success_message = "Candidate {$candidate_id} has been verified successfully.";
        }
    }
}

// Load all candidates
$candidates = [];
$candidates_file = 'data/candidates.json';

if (file_exists($candidates_file)) {
    $candidates = json_decode(file_get_contents($candidates_file), true);
}

// Count statistics
$total_candidates = count($candidates);
$verified_candidates = 0;
$pending_candidates = 0;

foreach ($candidates as $candidate) {
    if ($candidate['isVerified']) {
        $verified_candidates++;
    } else {
        $pending_candidates++;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SecureExamWatch</title>
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
<body class="min-h-screen flex flex-col bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="admin-dashboard.php" class="flex items-center">
                        <i class="fas fa-shield-alt text-exam-primary text-2xl"></i>
                        <span class="ml-2 text-xl font-bold text-exam-primary">SecureExamWatch</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center">
                    <span class="mr-4 text-gray-700">
                        Welcome, Admin
                    </span>
                    <form method="POST">
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
        
        <!-- Mobile menu, toggle classes based on menu state. -->
        <div class="mobile-menu hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <div class="block px-3 py-2 rounded-md text-base font-medium text-gray-700">
                    Welcome, Admin
                </div>
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
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Administrator Dashboard</h1>
            <p class="text-gray-600">Manage candidate verifications and exam administration</p>
        </div>
        
        <?php if (isset($success_message)): ?>
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">
                        <?= $success_message ?>
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Candidates</p>
                        <p class="text-2xl font-semibold text-gray-900"><?= $total_candidates ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Verified Candidates</p>
                        <p class="text-2xl font-semibold text-gray-900"><?= $verified_candidates ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-amber-100 text-amber-500">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Pending Verification</p>
                        <p class="text-2xl font-semibold text-gray-900"><?= $pending_candidates ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Candidate Verification</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Review and verify candidate identity documents
                    </p>
                </div>
                <div class="flex gap-2">
                    <button type="button" class="px-3 py-1 border border-gray-300 rounded-md bg-white text-sm text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <button type="button" class="px-3 py-1 border border-gray-300 rounded-md bg-white text-sm text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-download mr-1"></i> Export
                    </button>
                </div>
            </div>
            
            <div class="border-t border-gray-200">
                <?php if (empty($candidates)): ?>
                <div class="px-4 py-12 text-center">
                    <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-3"></i>
                    <p class="text-gray-500">No candidates registered yet</p>
                </div>
                <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Candidate
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Exam Type
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Registration Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($candidates as $id => $candidate): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-500"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($candidate['fullName']) ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?= htmlspecialchars($id) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= htmlspecialchars($candidate['examType']) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?= date('d M Y', strtotime($candidate['registrationDate'])) ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= date('h:i A', strtotime($candidate['registrationDate'])) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($candidate['isVerified']): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Verified
                                    </span>
                                    <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                        Pending
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button type="button" class="text-exam-primary hover:text-exam-primary-dark mr-3" onclick="viewCandidate('<?= $id ?>')">
                                        View
                                    </button>
                                    
                                    <?php if (!$candidate['isVerified']): ?>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="candidate_id" value="<?= $id ?>">
                                        <button type="submit" name="verify_candidate" class="text-green-600 hover:text-green-900">
                                            Verify
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-lg font-medium text-gray-900">Upcoming Exams</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Schedule and manage upcoming examinations
                </p>
            </div>
            <div class="px-4 py-12 text-center border-t border-gray-200">
                <i class="fas fa-calendar-alt text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-500">No upcoming exams scheduled</p>
                <button type="button" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-exam-primary hover:bg-exam-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary">
                    Schedule New Exam
                </button>
            </div>
        </div>
    </div>
    
    <!-- Candidate View Modal (hidden by default) -->
    <div id="candidateModal" class="hidden fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Candidate Details
                            </h3>
                            <div class="mt-4">
                                <div id="candidateDetails" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Candidate details will be populated by JavaScript -->
                                </div>
                                
                                <div class="mt-6">
                                    <h4 class="font-medium text-gray-900 mb-2">Identity Documents</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500 mb-1">Aadhaar Card</p>
                                            <div class="border border-gray-300 rounded-md p-4 bg-gray-100 flex items-center justify-center">
                                                <i class="fas fa-file-alt text-gray-400 text-3xl"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 mb-1">Passport Photo</p>
                                            <div class="border border-gray-300 rounded-md p-4 bg-gray-100 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-400 text-3xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form method="POST" id="verify-form" class="sm:ml-3">
                        <input type="hidden" name="candidate_id" id="modal-candidate-id">
                        <button 
                            type="submit" 
                            name="verify_candidate" 
                            id="verify-button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm"
                        >
                            Verify Candidate
                        </button>
                    </form>
                    <button 
                        type="button" 
                        id="close-modal"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary sm:mt-0 sm:text-sm"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="bg-exam-dark text-white py-8 mt-auto">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-shield-alt text-exam-secondary"></i>
                        <span class="ml-2 text-lg font-bold">SecureExamWatch</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Admin Portal - Restricted Access
                    </p>
                </div>
                
                <div>
                    <p class="text-gray-400 text-sm">
                        &copy; 2025 SecureExamWatch. All rights reserved.
                    </p>
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
            
            // Modal functionality
            const candidateModal = document.getElementById('candidateModal');
            const closeModalButton = document.getElementById('close-modal');
            
            if (closeModalButton) {
                closeModalButton.addEventListener('click', function() {
                    candidateModal.classList.add('hidden');
                });
            }
        });
        
        // Function to view candidate details
        function viewCandidate(candidateId) {
            // In a real application, this would fetch candidate data from the server
            // For this demo, we'll use the same JSON data structure
            fetch('data/candidates.json')
                .then(response => response.json())
                .then(candidates => {
                    const candidate = candidates[candidateId];
                    if (candidate) {
                        displayCandidateDetails(candidateId, candidate);
                    }
                })
                .catch(error => console.error('Error fetching candidate data:', error));
        }
        
        // Function to display candidate details in the modal
        function displayCandidateDetails(candidateId, candidate) {
            const candidateDetails = document.getElementById('candidateDetails');
            const modalTitle = document.getElementById('modal-title');
            const modalCandidateId = document.getElementById('modal-candidate-id');
            const verifyButton = document.getElementById('verify-button');
            const verifyForm = document.getElementById('verify-form');
            
            // Set modal title and candidate ID for verification
            modalTitle.textContent = `Candidate: ${candidate.fullName}`;
            modalCandidateId.value = candidateId;
            
            // Generate candidate details HTML
            let detailsHTML = `
                <div>
                    <p class="text-sm text-gray-500">Full Name</p>
                    <p class="font-medium">${candidate.fullName}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Exam Roll Number</p>
                    <p class="font-medium">${candidateId}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Exam Type</p>
                    <p class="font-medium">${candidate.examType}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Registration Date</p>
                    <p class="font-medium">${new Date(candidate.registrationDate).toLocaleString()}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">${candidate.email}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="font-medium">${candidate.phone}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Aadhaar Number</p>
                    <p class="font-medium">XXXX XXXX ${candidate.aadhaarNumber.slice(-4)}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Verification Status</p>
                    <p class="font-medium">
                        ${candidate.isVerified 
                            ? '<span class="text-green-600"><i class="fas fa-check-circle mr-1"></i> Verified</span>' 
                            : '<span class="text-amber-600"><i class="fas fa-clock mr-1"></i> Pending</span>'}
                    </p>
                </div>
            `;
            
            candidateDetails.innerHTML = detailsHTML;
            
            // Show/hide verify button based on verification status
            if (candidate.isVerified) {
                verifyButton.style.display = 'none';
            } else {
                verifyButton.style.display = 'block';
            }
            
            // Show the modal
            document.getElementById('candidateModal').classList.remove('hidden');
        }
    </script>
</body>
</html>
