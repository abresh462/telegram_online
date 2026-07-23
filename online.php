<?php

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include 'madeline.php';

use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;

$api_id = getenv('API_ID');
$api_hash = getenv('API_HASH');
$phone_number = getenv('PHONE_NUMBER');

// Create AppInfo object and set values using methods
$appInfo = new AppInfo();
$appInfo->setApiId((int)$api_id);
$appInfo->setApiHash($api_hash);

// Create settings object with AppInfo
$settings = (new Settings)->setAppInfo($appInfo);

$verification_code = getenv('VERIFICATION_CODE');

$MadelineProto = new \danog\MadelineProto\API('session.madeline', $settings);

if ($verification_code) {
    echo "Starting phone login...\n";
    $MadelineProto->phone_login($phone_number);
    echo "Verification code sent!\n";
    
    echo "Completing login with code: $verification_code\n";
    $MadelineProto->complete_phone_login($verification_code);
    echo "Login successful! Session saved.\n";
} else {
    echo "Starting with existing session...\n";
    $MadelineProto->start();
}

echo "Starting online status loop...\n";
while(1) {
    $MadelineProto->account->updateStatus(offline: false);
    sleep(5);
}
