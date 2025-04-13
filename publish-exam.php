<?php
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['user']['type'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

// Function to get exams with error handling
function getExams() {
    $exams_file = 'data/exams.json';
    if (!file_exists($exams_file)) {
        file_put_contents($exams_file, json_encode([]));
        return [];
    }
    
    $data = file_get_contents($exams_file);
    if ($data === false) {
        return [];
    }
    
    $exams = json_decode($data, true);
    return is_array($exams) ? $exams : [];
}

// Validate request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

// Check required parameters
if (!isset($_POST['exam_id']) || !isset($_POST['action'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}

// Validate action
$valid_actions = ['publish', 'unpublish'];
if (!in_array($_POST['action'], $valid_actions)) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Invalid action']);
    exit;
}

// Process the request
try {
    $exams = getExams();
    $exam_found = false;
    
    foreach ($exams as &$exam) {
        if ($exam['id'] === $_POST['exam_id']) {
            $exam['isPublished'] = ($_POST['action'] === 'publish');
            $exam['modifiedAt'] = date('Y-m-d H:i:s');
            $exam_found = true;
            break;
        }
    }
    
    if (!$exam_found) {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Exam not found']);
        exit;
    }
    
    // Save the updated exams
    $result = file_put_contents('data/exams.json', json_encode($exams, JSON_PRETTY_PRINT));
    
    if ($result === false) {
        throw new Exception('Failed to save exam data');
    }
    
    // Return success response
    $_SESSION['success'] = "Exam status updated successfully!";
    header('Location: admin-dashboard.php?tab=exams');
    exit;
    
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    $_SESSION['error'] = "An error occurred while updating the exam status: " . $e->getMessage();
    header('Location: admin-dashboard.php?tab=exams');
    exit;
}
?>