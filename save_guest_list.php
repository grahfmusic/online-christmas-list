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

// Check for POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Authenticate the request using the Authorization header
    $headers = getallheaders();
    if (!isset($headers['Authorization']) || $headers['Authorization'] !== 'Bearer ' . API_TOKEN) {
        http_response_code(401);
        $response = ['status' => 'error', 'message' => 'Unauthorized'];
        echo json_encode($response);
        log_error("Unauthorized access attempt.");
        exit;
    }

    // Retrieve the 'data' parameter from POST request
    $data = $_POST['data'] ?? null;

    if ($data) {
        // Validate JSON data
        $decodedData = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            $response = ['status' => 'error', 'message' => 'Invalid JSON data'];
            echo json_encode($response);
            log_error("Invalid JSON data received.");
            exit;
        }

        // Re-encode to ensure consistent formatting
        $encodedData = json_encode($decodedData, JSON_PRETTY_PRINT);
        if ($encodedData === false) {
            http_response_code(500);
            $response = ['status' => 'error', 'message' => 'Error encoding JSON data'];
            echo json_encode($response);
            log_error("Error encoding JSON data.");
            exit;
        }

        // Define the file path securely
        $file = 'guest_list.json';
        $filePath = __DIR__ . DIRECTORY_SEPARATOR . $file;

        // Open the file with locking to prevent concurrent writes
        $fp = fopen($filePath, 'c+');
        if ($fp) {
            if (flock($fp, LOCK_EX)) {  // Acquire an exclusive lock
                ftruncate($fp, 0);      // Truncate the file
                $bytesWritten = fwrite($fp, $encodedData); // Write new data
                fflush($fp);            // Flush output before releasing the lock
                flock($fp, LOCK_UN);    // Release the lock
                fclose($fp);

                if ($bytesWritten !== false) {
                    http_response_code(200);
                    $response = ['status' => 'success', 'message' => 'Data saved successfully'];
                } else {
                    http_response_code(500);
                    $response = ['status' => 'error', 'message' => 'Error saving data'];
                    log_error("Failed to write data to $filePath.");
                }
            } else {
                fclose($fp);
                http_response_code(500);
                $response = ['status' => 'error', 'message' => 'Could not lock the file for writing'];
                log_error("Could not lock the file for writing: $filePath.");
            }
        } else {
            http_response_code(500);
            $response = ['status' => 'error', 'message' => 'Error opening file for writing'];
            log_error("Failed to open file: $filePath.");
        }
    } else {
        http_response_code(400);
        $response = ['status' => 'error', 'message' => 'No data provided'];
        log_error("No data provided in POST request.");
    }
} else {
    http_response_code(405);
    $response = ['status' => 'error', 'message' => 'Method not allowed'];
    log_error("Invalid request method: {$_SERVER['REQUEST_METHOD']}.");
}

echo json_encode($response);
?>

