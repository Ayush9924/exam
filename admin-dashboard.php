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

// Function to get candidates
function getCandidates() {
    $candidates_file = 'data/candidates.json';
    if (file_exists($candidates_file)) {
        return json_decode(file_get_contents($candidates_file), true);
    }
    return [];
}

// Function to get exams
function getExams() {
    $exams_file = 'data/exams.json';
    if (file_exists($exams_file)) {
        return json_decode(file_get_contents($exams_file), true);
    }
    return [];
}

// Handle candidate verification
if (isset($_POST['verify_candidate'])) {
    $candidate_id = $_POST['candidate_id'];
    $status = $_POST['status']; // 'approve' or 'reject'
    
    $candidates = getCandidates();
    if (isset($candidates[$candidate_id])) {
        $candidates[$candidate_id]['isVerified'] = ($status === 'approve');
        file_put_contents('data/candidates.json', json_encode($candidates, JSON_PRETTY_PRINT));
        
        $success_message = ($status === 'approve') 
            ? "Candidate $candidate_id has been verified successfully."
            : "Candidate $candidate_id has been rejected.";
    }
}

// Handle exam scheduling messages
if (isset($_SESSION['success'])) {
    $success_message = $_SESSION['success'];
    unset($_SESSION['success']);
} elseif (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
}

// Load all data
$candidates = getCandidates();
$exams = getExams();

// Count statistics
$total_candidates = count($candidates);
$verified_candidates = 0;
$pending_candidates = 0;
$active_exams = 0;

foreach ($candidates as $candidate) {
    if ($candidate['isVerified']) {
        $verified_candidates++;
    } else {
        $pending_candidates++;
    }
}

foreach ($exams as $exam) {
    if ($exam['isPublished']) {
        $active_exams++;
    }
}

// Default tab
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'pending';
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
                        Welcome, <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Admin') ?>
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
        
        <?php if (isset($error_message)): ?>
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        <?= $error_message ?>
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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
                    <div class="p-3 rounded-full bg-amber-100 text-amber-500">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Pending Verification</p>
                        <p class="text-2xl font-semibold text-gray-900"><?= $pending_candidates ?></p>
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
                    <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                        <i class="fas fa-file-alt text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Active Exams</p>
                        <p class="text-2xl font-semibold text-gray-900"><?= $active_exams ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabs -->
        <div class="flex border-b mb-6">
            <a href="?tab=pending" class="px-4 py-2 font-medium <?= $active_tab === 'pending' ? 'text-exam-primary border-b-2 border-exam-primary' : 'text-gray-600 hover:text-exam-primary' ?>">
                Pending Verification
            </a>
            <a href="?tab=verified" class="px-4 py-2 font-medium <?= $active_tab === 'verified' ? 'text-exam-primary border-b-2 border-exam-primary' : 'text-gray-600 hover:text-exam-primary' ?>">
                Verified Candidates
            </a>
            <a href="?tab=exams" class="px-4 py-2 font-medium <?= $active_tab === 'exams' ? 'text-exam-primary border-b-2 border-exam-primary' : 'text-gray-600 hover:text-exam-primary' ?>">
                Scheduled Exams
            </a>
        </div>
        
        <?php if ($active_tab === 'pending'): ?>
            <!-- Pending Verification Tab -->
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Pending Candidate Verification</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Review and verify candidate identity documents
                        </p>
                    </div>
                </div>
                
                <div class="border-t border-gray-200">
                    <?php 
                    $pending_candidates = array_filter($candidates, function($candidate) {
                        return !$candidate['isVerified'];
                    });
                    
                    if (empty($pending_candidates)): ?>
                    <div class="px-4 py-12 text-center">
                        <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">No pending verifications</p>
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
                                        Exam Info
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Registration Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($pending_candidates as $id => $candidate): ?>
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
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <button 
                                            type="button" 
                                            class="text-exam-primary hover:text-exam-primary-dark" 
                                            onclick="viewCandidate('<?= $id ?>')"
                                        >
                                            View
                                        </button>
                                        
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="candidate_id" value="<?= $id ?>">
                                            <input type="hidden" name="status" value="approve">
                                            <button 
                                                type="submit" 
                                                name="verify_candidate" 
                                                class="text-green-600 hover:text-green-900"
                                            >
                                                Approve
                                            </button>
                                        </form>
                                        
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="candidate_id" value="<?= $id ?>">
                                            <input type="hidden" name="status" value="reject">
                                            <button 
                                                type="submit" 
                                                name="verify_candidate" 
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                Reject
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
        <?php elseif ($active_tab === 'verified'): ?>
            <!-- Verified Candidates Tab -->
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Verified Candidates</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            List of all verified candidates
                        </p>
                    </div>
                </div>
                
                <div class="border-t border-gray-200">
                    <?php 
                    $verified_candidates_list = array_filter($candidates, function($candidate) {
                        return $candidate['isVerified'];
                    });
                    
                    if (empty($verified_candidates_list)): ?>
                    <div class="px-4 py-12 text-center">
                        <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">No verified candidates</p>
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
                                        Exam Info
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
                                <?php foreach ($verified_candidates_list as $id => $candidate): ?>
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
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Verified
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button 
                                            type="button" 
                                            class="text-exam-primary hover:text-exam-primary-dark mr-3" 
                                            onclick="viewCandidate('<?= $id ?>')"
                                        >
                                            View
                                        </button>
                                        
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="candidate_id" value="<?= $id ?>">
                                            <input type="hidden" name="status" value="reject">
                                            <button 
                                                type="submit" 
                                                name="verify_candidate" 
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                Revoke
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
        <?php elseif ($active_tab === 'exams'): ?>
            <!-- Exams Tab -->
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Scheduled Exams</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Manage upcoming examinations
                        </p>
                    </div>
                    <button 
                        id="scheduleExamBtn"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-exam-primary hover:bg-exam-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary"
                    >
                        <i class="fas fa-plus mr-2"></i>
                        Schedule Exam
                    </button>
                </div>
                
                <div class="border-t border-gray-200">
                    <?php if (empty($exams)): ?>
                    <div class="px-4 py-12 text-center">
                        <i class="fas fa-calendar-alt text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">No exams scheduled yet</p>
                    </div>
                    <?php else: ?>
                    <div class="divide-y divide-gray-200">
                        <?php foreach ($exams as $exam): ?>
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="mb-4 md:mb-0">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        <?= htmlspecialchars($exam['examTitle']) ?>
                                        <span class="ml-2 px-2 py-1 text-xs rounded-full <?= $exam['isPublished'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                            <?= $exam['isPublished'] ? 'Published' : 'Draft' ?>
                                        </span>
                                    </h3>
                                    <p class="text-sm text-gray-500"><?= htmlspecialchars($exam['examCode']) ?></p>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <form method="POST" action="publish-exam.php" class="inline">
                                        <input type="hidden" name="exam_id" value="<?= $exam['id'] ?>">
                                        <input type="hidden" name="action" value="<?= $exam['isPublished'] ? 'unpublish' : 'publish' ?>">
                                        <button 
                                            type="submit" 
                                            class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                        >
                                            <?= $exam['isPublished'] ? 'Unpublish' : 'Publish' ?>
                                        </button>
                                    </form>
                                    
                                    <button 
                                        type="button" 
                                        class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                        onclick="editExam('<?= $exam['id'] ?>')"
                                    >
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </button>
                                    
                                    <form method="POST" action="delete-exam.php" class="inline" onsubmit="return confirm('Are you sure you want to delete this exam?');">
                                        <input type="hidden" name="exam_id" value="<?= $exam['id'] ?>">
                                        <button 
                                            type="submit" 
                                            class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md text-red-600 bg-white hover:bg-red-50"
                                        >
                                            <i class="fas fa-trash-alt mr-1"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-day text-gray-500 mr-2"></i>
                                    <span class="text-sm"><?= date('d M Y', strtotime($exam['examDate'])) ?></span>
                                </div>
                                
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-gray-500 mr-2"></i>
                                    <span class="text-sm">
                                        <?= htmlspecialchars($exam['examTime']) ?>
                                        <?php if (!empty($exam['examDuration'])): ?>
                                            (<?= htmlspecialchars($exam['examDuration']) ?> minutes)
                                        <?php endif; ?>
                                    </span>
                                </div>
                                
                                <?php if (!empty($exam['examVenue'])): ?>
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-gray-500 mr-2"></i>
                                    <span class="text-sm"><?= htmlspecialchars($exam['examVenue']) ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if (!empty($exam['examDescription'])): ?>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600"><?= htmlspecialchars($exam['examDescription']) ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Schedule Exam Modal -->
    <div id="scheduleExamModal" class="hidden fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Schedule New Exam
                            </h3>
                            <div class="mt-4">
                                <form id="scheduleExamForm" action="schedule-exam.php" method="POST">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="examTitle" class="block text-sm font-medium text-gray-700">Exam Title*</label>
                                            <input type="text" name="examTitle" id="examTitle" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-exam-primary focus:border-exam-primary">
                                        </div>
                                        
                                        <div>
                                            <label for="examCode" class="block text-sm font-medium text-gray-700">Exam Code*</label>
                                            <input type="text" name="examCode" id="examCode" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-exam-primary focus:border-exam-primary">
                                        </div>
                                        
                                        <div>
                                            <label for="examDate" class="block text-sm font-medium text-gray-700">Exam Date*</label>
                                            <input type="date" name="examDate" id="examDate" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-exam-primary focus:border-exam-primary">
                                        </div>
                                        
                                        <div>
                                            <label for="examTime" class="block text-sm font-medium text-gray-700">Start Time*</label>
                                            <input type="time" name="examTime" id="examTime" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-exam-primary focus:border-exam-primary">
                                        </div>
                                        
                                        <div>
                                            <label for="examDuration" class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                                            <input type="number" name="examDuration" id="examDuration" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-exam-primary focus:border-exam-primary">
                                        </div>
                                        
                                        <div>
                                            <label for="examVenue" class="block text-sm font-medium text-gray-700">Venue</label>
                                            <input type="text" name="examVenue" id="examVenue" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-exam-primary focus:border-exam-primary">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="examDescription" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="examDescription" id="examDescription" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-exam-primary focus:border-exam-primary"></textarea>
                                    </div>
                                    
                                    <div class="flex items-center mb-4">
                                        <input type="checkbox" name="isPublished" id="isPublished" class="h-4 w-4 text-exam-primary focus:ring-exam-primary border-gray-300 rounded">
                                        <label for="isPublished" class="ml-2 block text-sm text-gray-900">Publish immediately</label>
                                    </div>
                                    
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-exam-primary text-base font-medium text-white hover:bg-exam-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary sm:ml-3 sm:w-auto sm:text-sm">
                                            Schedule Exam
                                        </button>
                                        <button type="button" id="closeExamModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="bg-exam-dark text-white py-8 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 SecureExamWatch. All rights reserved.</p>
        </div>
    </footer>
    
    <script>
        // Toggle mobile menu
        document.addEventListener('DOMContentLoaded', function() {
            // Exam modal functionality
            const scheduleExamBtn = document.getElementById('scheduleExamBtn');
            const scheduleExamModal = document.getElementById('scheduleExamModal');
            const closeExamModal = document.getElementById('closeExamModal');
            
            if (scheduleExamBtn) {
                scheduleExamBtn.addEventListener('click', function() {
                    scheduleExamModal.classList.remove('hidden');
                });
            }
            
            if (closeExamModal) {
                closeExamModal.addEventListener('click', function() {
                    scheduleExamModal.classList.add('hidden');
                });
            }
            
            // Set minimum date for exam date input
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            const formattedDate = `${yyyy}-${mm}-${dd}`;
            
            const examDateInput = document.getElementById('examDate');
            if (examDateInput) {
                examDateInput.min = formattedDate;
            }

            // Handle form submission
            const scheduleExamForm = document.getElementById('scheduleExamForm');
            if (scheduleExamForm) {
                scheduleExamForm.addEventListener('submit', function(e) {
                    // Client-side validation
                    const examTitle = document.getElementById('examTitle').value.trim();
                    const examCode = document.getElementById('examCode').value.trim();
                    const examDate = document.getElementById('examDate').value;
                    const examTime = document.getElementById('examTime').value;
                    
                    if (!examTitle || !examCode || !examDate || !examTime) {
                        e.preventDefault();
                        alert('Please fill in all required fields');
                        return false;
                    }
                    
                    // Additional validation can be added here
                    return true;
                });
            }
        });
        
        // Function to view candidate details
        function viewCandidate(candidateId) {
            alert('Viewing candidate with ID: ' + candidateId);
            // In a real application, this would open a modal with detailed candidate info
        }
        
        // Function to edit exam
        function editExam(examId) {
            alert('Edit exam with ID: ' + examId);
            // In a real application, this would fetch exam data and populate a form
        }
    </script>
</body>
</html>