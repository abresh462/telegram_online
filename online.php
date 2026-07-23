<?php

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include 'madeline.php';

use danog\MadelineProto\Settings;

$api_id = getenv('API_ID');
$api_hash = getenv('API_HASH');
$phone_number = getenv('PHONE_NUMBER');

// Create settings object (new syntax)
$settings = (new Settings)
    ->setAppInfo($api_id, $api_hash);

// Check if verification code is provided
$verification_code = getenv('VERIFICATION_CODE');

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
