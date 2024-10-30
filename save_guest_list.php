<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'];

    // Encryption key (keep this secret and secure)
    $encryption_key = 'your-secret-key'; // Replace with a strong key and store securely
  

    // Initialization Vector (IV)
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));

    // Encrypt the data
    $encrypted_data = openssl_encrypt($data, 'AES-256-CBC', $encryption_key, 0, $iv);

    // Combine IV and encrypted data
    $data_to_save = base64_encode($iv . $encrypted_data);

    // Save the encrypted data to a file
    $file = 'guest_list.dat';

    if (file_put_contents($file, $data_to_save) !== false) {
        echo 'Success';
    } else {
        $error = error_get_last();
        http_response_code(500);
        echo 'Error saving data: ' . $error['message'];
    }
} else {
    http_response_code(405);
    echo 'Method not allowed';
}
?>
