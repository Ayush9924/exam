<?php
session_start();

// Initialize variables for form data
$fullName = '';
$aadhaarNumber = '';
$examRollNo = '';
$examType = 'DBT-JRF';
$email = '';
$phone = '';
$formErrors = [];
$step = 1;
$registration_success = false;

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the form was submitted to change steps
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'next' && $_POST['current_step'] === '1') {
            // Validate first step fields
            $fullName = $_POST['fullName'] ?? '';
            $aadhaarNumber = $_POST['aadhaarNumber'] ?? '';
            
            // Validate full name
            if (empty($fullName)) {
                $formErrors['fullName'] = 'Please enter your full name';
            }
            
            // Validate Aadhaar number
            if (empty($aadhaarNumber) || strlen($aadhaarNumber) !== 12 || !ctype_digit($aadhaarNumber)) {
                $formErrors['aadhaarNumber'] = 'Please enter a valid 12-digit Aadhaar number';
            }
            
            // Validate Aadhaar file upload
            if (!isset($_FILES['aadhaarFile']) || $_FILES['aadhaarFile']['error'] !== UPLOAD_ERR_OK) {
                $formErrors['aadhaarFile'] = 'Please upload a scanned copy of your Aadhaar card';
            } else {
                // Check file type and size
                $allowed_types = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                $file_type = $_FILES['aadhaarFile']['type'];
                $file_size = $_FILES['aadhaarFile']['size'];
                
                if (!in_array($file_type, $allowed_types)) {
                    $formErrors['aadhaarFile'] = 'Only PDF, JPG, or PNG files are allowed';
                } elseif ($file_size > 2000000) { // 2MB
                    $formErrors['aadhaarFile'] = 'File size should not exceed 2MB';
                }
            }
            
            // If there are no errors, move to step 2
            if (empty($formErrors)) {
                $step = 2;
                // Store step 1 data in session
                $_SESSION['registration'] = [
                    'fullName' => $fullName,
                    'aadhaarNumber' => $aadhaarNumber,
                    'aadhaarFile' => $_FILES['aadhaarFile']['name']
                ];
                
                // Move uploaded file to a temp directory
                $upload_dir = 'uploads/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_name = time() . '_' . $_FILES['aadhaarFile']['name'];
                move_uploaded_file($_FILES['aadhaarFile']['tmp_name'], $upload_dir . $file_name);
                $_SESSION['registration']['aadhaarFilePath'] = $upload_dir . $file_name;
            }
        } elseif ($_POST['action'] === 'prev' && $_POST['current_step'] === '2') {
            // Go back to step 1
            $step = 1;
            // Restore session data if available
            if (isset($_SESSION['registration'])) {
                $fullName = $_SESSION['registration']['fullName'];
                $aadhaarNumber = $_SESSION['registration']['aadhaarNumber'];
            }
        } elseif ($_POST['action'] === 'submit' && $_POST['current_step'] === '2') {
            // Process final submission
            $examType = $_POST['examType'] ?? 'DBT-JRF';
            $examRollNo = $_POST['examRollNo'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            
            // Validate exam roll number
            if (empty($examRollNo)) {
                $formErrors['examRollNo'] = 'Please enter your exam roll number';
            }
            
            // Validate email
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $formErrors['email'] = 'Please enter a valid email address';
            }
            
            // Validate phone
            if (empty($phone) || strlen($phone) < 10 || !ctype_digit($phone)) {
                $formErrors['phone'] = 'Please enter a valid phone number';
            }
            
            // Validate photo upload
            if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
                $formErrors['photo'] = 'Please upload your passport size photograph';
            } else {
                // Check file type and size
                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
                $file_type = $_FILES['photo']['type'];
                $file_size = $_FILES['photo']['size'];
                
                if (!in_array($file_type, $allowed_types)) {
                    $formErrors['photo'] = 'Only JPG or PNG files are allowed';
                } elseif ($file_size > 1000000) { // 1MB
                    $formErrors['photo'] = 'File size should not exceed 1MB';
                }
            }
            
            // If there are no errors, complete registration
            if (empty($formErrors)) {
                // Update session with step 2 data
                $_SESSION['registration']['examType'] = $examType;
                $_SESSION['registration']['examRollNo'] = $examRollNo;
                $_SESSION['registration']['email'] = $email;
                $_SESSION['registration']['phone'] = $phone;
                
                // Move uploaded photo to a directory
                $upload_dir = 'uploads/photos/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_name = time() . '_' . $_FILES['photo']['name'];
                move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $file_name);
                $_SESSION['registration']['photoPath'] = $upload_dir . $file_name;
                
                // Save candidate data to JSON file (in a real application, this would be a database)
                $candidates_file = 'data/candidates.json';
                
                // Create directory if it doesn't exist
                if (!file_exists('data/')) {
                    mkdir('data/', 0777, true);
                }
                
                // Load existing candidates or create empty array
                $candidates = [];
                if (file_exists($candidates_file)) {
                    $candidates = json_decode(file_get_contents($candidates_file), true) ?: [];
                }
                
                // Add new candidate
                $candidates[$examRollNo] = [
                    'fullName' => $_SESSION['registration']['fullName'],
                    'aadhaarNumber' => $_SESSION['registration']['aadhaarNumber'],
                    'aadhaarFilePath' => $_SESSION['registration']['aadhaarFilePath'],
                    'examType' => $examType,
                    'examRollNo' => $examRollNo,
                    'email' => $email,
                    'phone' => $phone,
                    'photoPath' => $_SESSION['registration']['photoPath'],
                    'registrationDate' => date('Y-m-d H:i:s'),
                    'isVerified' => false
                ];
                
                // Save to file
                file_put_contents($candidates_file, json_encode($candidates, JSON_PRETTY_PRINT));
                
                // Set success flag and move to step 3
                $registration_success = true;
                $step = 3;
            } else {
                // Keep in step 2 but retain entered values
                $step = 2;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Registration - SecureExamWatch</title>
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
                    <a href="login.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-exam-primary bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary">
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
    
    <div class="flex-1 bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900">
                    Candidate Registration
                </h1>
                <p class="mt-2 text-gray-600">
                    Register to access your secure exam portal
                </p>
            </div>
            
            <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
                <div class="px-4 py-5 sm:p-6">
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div 
                                    class="bg-exam-primary h-2.5 rounded-full transition-all duration-500" 
                                    style="width: <?= ($step / 3) * 100 ?>%"
                                ></div>
                            </div>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <div class="<?= $step >= 1 ? 'text-exam-primary font-medium' : '' ?>">Personal Details</div>
                            <div class="<?= $step >= 2 ? 'text-exam-primary font-medium' : '' ?>">Exam Information</div>
                            <div class="<?= $step >= 3 ? 'text-exam-primary font-medium' : '' ?>">Confirmation</div>
                        </div>
                    </div>
                    
                    <?php if ($step === 1): ?>
                    <form method="POST" enctype="multipart/form-data" class="space-y-6">
                        <input type="hidden" name="current_step" value="1">
                        
                        <div class="space-y-2">
                            <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name (as per Aadhaar)</label>
                            <input
                                id="fullName"
                                name="fullName"
                                type="text"
                                placeholder="Enter your full name"
                                value="<?= htmlspecialchars($fullName) ?>"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-exam-primary focus:border-exam-primary"
                                required
                            >
                            <?php if (isset($formErrors['fullName'])): ?>
                                <p class="mt-1 text-sm text-red-600"><?= $formErrors['fullName'] ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="aadhaarNumber" class="block text-sm font-medium text-gray-700">Aadhaar Number</label>
                            <input
                                id="aadhaarNumber"
                                name="aadhaarNumber"
                                type="text"
                                placeholder="12-digit Aadhaar number"
                                value="<?= htmlspecialchars($aadhaarNumber) ?>"
                                maxlength="12"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-exam-primary focus:border-exam-primary"
                                required
                            >
                            <p class="text-xs text-gray-500">Enter your 12-digit Aadhaar number without spaces</p>
                            <?php if (isset($formErrors['aadhaarNumber'])): ?>
                                <p class="mt-1 text-sm text-red-600"><?= $formErrors['aadhaarNumber'] ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="aadhaarFile" class="block text-sm font-medium text-gray-700">Upload Aadhaar Card</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-md p-6 flex flex-col items-center justify-center">
                                <i class="fas fa-file-alt text-gray-400 text-3xl mb-2"></i>
                                <p class="text-sm text-gray-600 mb-2" id="file-name-display">
                                    Upload a scanned copy of your Aadhaar card
                                </p>
                                <div class="mt-2">
                                    <label for="aadhaarFile" class="cursor-pointer bg-gray-50 hover:bg-gray-100 text-exam-primary font-medium py-2 px-4 border border-gray-300 rounded-md shadow-sm transition-colors">
                                        <span>Select file</span>
                                        <input
                                            id="aadhaarFile"
                                            name="aadhaarFile"
                                            type="file"
                                            class="sr-only"
                                            accept=".pdf,.jpg,.jpeg,.png"
                                            required
                                        >
                                    </label>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">PDF, JPG or PNG (max. 2MB)</p>
                                <?php if (isset($formErrors['aadhaarFile'])): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $formErrors['aadhaarFile'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-amber-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-amber-800">Important</h3>
                                    <div class="text-sm text-amber-700">
                                        Please ensure all personal details match exactly with your Aadhaar card. Any discrepancy may lead to verification failure.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button 
                                type="submit" 
                                name="action" 
                                value="next" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-exam-primary hover:bg-exam-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary"
                            >
                                Next
                            </button>
                        </div>
                    </form>
                    <?php elseif ($step === 2): ?>
                    <form method="POST" enctype="multipart/form-data" class="space-y-6">
                        <input type="hidden" name="current_step" value="2">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="examType" class="block text-sm font-medium text-gray-700">Exam Type</label>
                                <select
                                    id="examType"
                                    name="examType"
                                    class="w-full h-10 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-exam-primary focus:border-exam-primary"
                                    required
                                >
                                    <option value="DBT-JRF" <?= $examType === 'DBT-JRF' ? 'selected' : '' ?>>DBT-JRF</option>
                                    <option value="JNU-CET" <?= $examType === 'JNU-CET' ? 'selected' : '' ?>>JNU-CET</option>
                                    <option value="BITP" <?= $examType === 'BITP' ? 'selected' : '' ?>>BITP</option>
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <label for="examRollNo" class="block text-sm font-medium text-gray-700">Exam Roll Number</label>
                                <input
                                    id="examRollNo"
                                    name="examRollNo"
                                    type="text"
                                    placeholder="e.g. DBT2025001"
                                    value="<?= htmlspecialchars($examRollNo) ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-exam-primary focus:border-exam-primary"
                                    required
                                >
                                <?php if (isset($formErrors['examRollNo'])): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $formErrors['examRollNo'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <hr class="border-gray-200">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    placeholder="Your email address"
                                    value="<?= htmlspecialchars($email) ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-exam-primary focus:border-exam-primary"
                                    required
                                >
                                <?php if (isset($formErrors['email'])): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $formErrors['email'] ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="space-y-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input
                                    id="phone"
                                    name="phone"
                                    type="text"
                                    placeholder="Your mobile number"
                                    value="<?= htmlspecialchars($phone) ?>"
                                    maxlength="10"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-exam-primary focus:border-exam-primary"
                                    required
                                >
                                <?php if (isset($formErrors['phone'])): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $formErrors['phone'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="photo" class="block text-sm font-medium text-gray-700">Upload Passport Photo</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="border-2 border-dashed border-gray-300 rounded-md p-6 flex flex-col items-center justify-center">
                                    <i class="fas fa-user text-gray-400 text-3xl mb-2"></i>
                                    <p class="text-sm text-gray-600 mb-2" id="photo-name-display">
                                        Upload a passport size photograph
                                    </p>
                                    <div class="mt-2">
                                        <label for="photo" class="cursor-pointer bg-gray-50 hover:bg-gray-100 text-exam-primary font-medium py-2 px-4 border border-gray-300 rounded-md shadow-sm transition-colors">
                                            <span>Select photo</span>
                                            <input
                                                id="photo"
                                                name="photo"
                                                type="file"
                                                class="sr-only"
                                                accept=".jpg,.jpeg,.png"
                                                required
                                            >
                                        </label>
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">JPG or PNG (max. 1MB)</p>
                                    <?php if (isset($formErrors['photo'])): ?>
                                        <p class="mt-1 text-sm text-red-600"><?= $formErrors['photo'] ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex items-center justify-center">
                                    <div id="photo-preview" class="h-48 w-40 bg-gray-100 border border-gray-300 rounded-md flex items-center justify-center">
                                        <p class="text-sm text-gray-500">Photo preview</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        This photo will be used for identity verification during the exam. Ensure it is a recent, clear, front-facing photo with a plain background.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between">
                            <button 
                                type="submit" 
                                name="action" 
                                value="prev" 
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary"
                            >
                                Back
                            </button>
                            <button 
                                type="submit" 
                                name="action" 
                                value="submit" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-exam-primary hover:bg-exam-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary"
                            >
                                Submit Registration
                            </button>
                        </div>
                    </form>
                    <?php elseif ($step === 3): ?>
                    <div class="space-y-6 text-center">
                        <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Registration Successful</h3>
                            <p class="mt-2 text-gray-600">
                                Your registration has been submitted for verification. You will receive a confirmation email at <?= htmlspecialchars($_SESSION['registration']['email']) ?>.
                            </p>
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-md">
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-900">Registration Details</h4>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="flex flex-col space-y-1">
                                    <span class="text-gray-500">Name</span>
                                    <span class="font-medium"><?= htmlspecialchars($_SESSION['registration']['fullName']) ?></span>
                                </div>
                                
                                <div class="flex flex-col space-y-1">
                                    <span class="text-gray-500">Exam Type</span>
                                    <span class="font-medium"><?= htmlspecialchars($_SESSION['registration']['examType']) ?></span>
                                </div>
                                
                                <div class="flex flex-col space-y-1">
                                    <span class="text-gray-500">Roll Number</span>
                                    <span class="font-medium"><?= htmlspecialchars($_SESSION['registration']['examRollNo']) ?></span>
                                </div>
                                
                                <div class="flex flex-col space-y-1">
                                    <span class="text-gray-500">Aadhaar</span>
                                    <span class="font-medium">XXXX XXXX <?= substr($_SESSION['registration']['aadhaarNumber'], -4) ?></span>
                                </div>
                                
                                <div class="flex flex-col space-y-1">
                                    <span class="text-gray-500">Email</span>
                                    <span class="font-medium"><?= htmlspecialchars($_SESSION['registration']['email']) ?></span>
                                </div>
                                
                                <div class="flex flex-col space-y-1">
                                    <span class="text-gray-500">Phone</span>
                                    <span class="font-medium"><?= htmlspecialchars($_SESSION['registration']['phone']) ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-amber-50 border border-amber-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-amber-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-amber-800">Important</h3>
                                    <p class="text-sm text-amber-700">
                                        Your identity verification is pending. Once verified, you will be able to access your exam portal.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <a 
                                href="login.php" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-exam-primary hover:bg-exam-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary"
                            >
                                Go to Login
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($step < 3): ?>
                <div class="px-4 py-4 sm:px-6 bg-gray-50 flex justify-between">
                    <?php if ($step === 2): ?>
                    <button 
                        type="button" 
                        onclick="history.back()" 
                        class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-exam-primary"
                    >
                        Cancel
                    </button>
                    <?php else: ?>
                    <div></div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="text-center text-sm text-gray-600">
                <p>
                    By registering, you agree to our 
                    <a href="#" class="text-exam-primary hover:underline">
                        Terms of Service
                    </a> 
                    and 
                    <a href="#" class="text-exam-primary hover:underline">
                        Privacy Policy
                    </a>.
                </p>
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
                    <ul class="space-y-2 text-gray