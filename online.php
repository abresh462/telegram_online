<?php

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include 'madeline.php';

// Read credentials from environment variables
$api_id = getenv('API_ID');
$api_hash = getenv('API_HASH');
$phone_number = getenv('PHONE_NUMBER');

// Create settings with your credentials
$settings = [
    'app_info' => [
        'api_id' => (int)$api_id,
        'api_hash' => $api_hash,
    ],
];

$MadelineProto = new \danog\MadelineProto\API('session.madeline', $settings);
$MadelineProto->start();

while(1) {
    $MadelineProto->account->updateStatus(offline: false);
    sleep(5);
}
