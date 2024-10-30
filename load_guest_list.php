<?php
$file = 'guest_list.dat';

if (file_exists($file)) {
    $data = file_get_contents($file);

    // Decode the data
    $data = base64_decode($data);

    // Extract the IV and encrypted data
    $iv_length = openssl_cipher_iv_length('AES-256-CBC');
    $iv = substr($data, 0, $iv_length);
    $encrypted_data = substr($data, $iv_length);

    // Decryption key (same as encryption key)
    $encryption_key = 'your-secret-key'; // Use the same key as in save_guest_list.php

    // Decrypt the data
    $decrypted_data = openssl_decrypt($encrypted_data, 'AES-256-CBC', $encryption_key, 0, $iv);

    if ($decrypted_data === false) {
        http_response_code(500);
        echo 'Error decrypting data.';
        exit;
    }

    header('Content-Type: application/json');
    echo $decrypted_data;
} else {
    http_response_code(404);
    echo 'File not found';
}
?>
