<?php

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include 'madeline.php';

$api_id = getenv('API_ID');
$api_hash = getenv('API_HASH');
$phone_number = getenv('PHONE_NUMBER');

// Check if verification code is provided
$verification_code = getenv('VERIFICATION_CODE');

$settings = [
    'app_info' => [
        'api_id' => (int)$api_id,
        'api_hash' => $api_hash,
    ],
];

$MadelineProto = new \danog\MadelineProto\API('session.madeline', $settings);

if ($verification_code) {
    // First time setup with verification code
    echo "Starting phone login...\n";
    $MadelineProto->phone_login($phone_number);
    echo "Verification code sent!\n";
    
    echo "Completing login with code: $verification_code\n";
    $MadelineProto->complete_phone_login($verification_code);
    echo "Login successful! Session saved.\n";
} else {
    // Normal start with existing session
    echo "Starting with existing session...\n";
    $MadelineProto->start();
}

echo "Starting online status loop...\n";
while(1) {
    $MadelineProto->account->updateStatus(offline: false);
    sleep(5);
}
