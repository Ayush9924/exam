<?php
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['user']['type'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Function to get exams
function getExams() {
    $exams_file = 'data/exams.json';
    if (file_exists($exams_file)) {
        return json_decode(file_get_contents($exams_file), true);
    }
    return [];
}

// Handle exam scheduling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $required_fields = ['examTitle', 'examCode', 'examDate', 'examTime'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $_SESSION['error'] = "Please fill in all required fields.";
            header('Location: admin-dashboard.php?tab=exams');
            exit;
        }
    }

    // Get existing exams
    $exams = getExams();

    // Create new exam
    $new_exam = [
        'id' => uniqid(),
        'examTitle' => $_POST['examTitle'],
        'examCode' => $_POST['examCode'],
        'examDate' => $_POST['examDate'],
        'examTime' => $_POST['examTime'],
        'examDuration' => $_POST['examDuration'] ?? null,
        'examVenue' => $_POST['examVenue'] ?? null,
        'examDescription' => $_POST['examDescription'] ?? null,
        'isPublished' => isset($_POST['isPublished']) && $_POST['isPublished'] === 'on',
        'createdAt' => date('Y-m-d H:i:s')
    ];

    // Add new exam to array
    $exams[] = $new_exam;

    // Save to file
    file_put_contents('data/exams.json', json_encode($exams, JSON_PRETTY_PRINT));

    $_SESSION['success'] = "Exam scheduled successfully!";
    header('Location: admin-dashboard.php?tab=exams');
    exit;
}

header('Location: admin-dashboard.php?tab=exams');
exit;
?>