<?php
session_start();
require 'uidai-config.php'; // Contains API keys

function aadhaarBiometricAuth($aadhaar_number, $biometric_data) {
    $api_url = "https://auth.uidai.gov.in/1.6/kyc";
    
    $payload = [
        'uid' => $aadhaar_number,
        'bio' => $biometric_data,
        'txn_id' => uniqid('DBT_'),
        'consent' => 'Y'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer '.UIDAI_API_KEY
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aadhaar = $_POST['aadhaar'];
    $biometric = $_FILES['biometric']['tmp_name']; // From fingerprint scanner
    
    $auth_result = aadhaarBiometricAuth($aadhaar, file_get_contents($biometric));
    
    if($auth_result['status'] === 'success') {
        $_SESSION['biometric_verified'] = true;
        header("Location: exam-portal.php");
    } else {
        $error = "Biometric verification failed: ".$auth_result['message'];
    }
}
?>