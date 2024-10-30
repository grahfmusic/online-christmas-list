<?php
header('Content-Type: application/json');

// Define a simple token for authentication (Replace with a secure method in production)
define('API_TOKEN', 'f6210ea7848bf16861d850de1b7f5449ce1e2b4bfdf6b27bfeeb9019b0645f93');

// Initialize the response array
$response = [];

// Function to log errors
function log_error($message) {
    // Customize the log file path as needed
    error_log(date('[Y-m-d H:i e] ') . $message . PHP_EOL, 3, 'error_log.txt');
}

// Handle preflight requests if any (optional based on your setup)
// Uncomment the following lines if you anticipate preflight requests
/*
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
*/

// Authenticate the request using the Authorization header
$headers = getallheaders();
if (!isset($headers['Authorization']) || $headers['Authorization'] !== 'Bearer ' . API_TOKEN) {
    http_response_code(401);
    $response = ['status' => 'error', 'message' => 'Unauthorized'];
    echo json_encode($response);
    log_error("Unauthorized access attempt.");
    exit;
}

$file = 'guest_list.json';  // The JSON file containing guest list data
$filePath = __DIR__ . DIRECTORY_SEPARATOR . $file;

if (file_exists($filePath)) {
    // Open the file with locking to prevent concurrent reads/writes
    $fp = fopen($filePath, 'r');
    if ($fp) {
        if (flock($fp, LOCK_SH)) {  // Acquire a shared lock
            // Optional: Check if file size is manageable
            $fileSize = filesize($filePath);
            $maxSize = 5 * 1024 * 1024; // 5 MB
            if ($fileSize > $maxSize) {
                http_response_code(413); // Payload Too Large
                $response = ['status' => 'error', 'message' => 'Data payload is too large'];
                echo json_encode($response);
                log_error("Data payload too large: $filePath.");
                flock($fp, LOCK_UN);
                fclose($fp);
                exit;
            }

            $data = fread($fp, $fileSize);
            flock($fp, LOCK_UN);    // Release the lock
            fclose($fp);

            if ($data !== false) {
                // Validate JSON
                json_decode($data);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    http_response_code(500);
                    $response = ['status' => 'error', 'message' => 'Corrupted JSON data'];
                    echo json_encode($response);
                    log_error("Corrupted JSON data in $filePath.");
                    exit;
                }

                $response = ['status' => 'success', 'data' => json_decode($data, true)];
            } else {
                http_response_code(500);
                $response = ['status' => 'error', 'message' => 'Error reading data'];
                log_error("Error reading data from $filePath.");
            }
        } else {
            fclose($fp);
            http_response_code(500);
            $response = ['status' => 'error', 'message' => 'Could not lock the file for reading'];
            log_error("Could not lock the file for reading: $filePath.");
        }
    } else {
        http_response_code(500);
        $response = ['status' => 'error', 'message' => 'Error opening file for reading'];
        log_error("Failed to open file for reading: $filePath.");
    }
} else {
    http_response_code(404);
    $response = ['status' => 'error', 'message' => 'No saved guest list found'];
    log_error("File not found: $filePath.");
}

echo json_encode($response);
?>

