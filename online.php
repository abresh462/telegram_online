$settings = [
    'app_info' => [
        'api_id' => getenv('API_ID'),
        'api_hash' => getenv('API_HASH')
    ]
];

$MadelineProto = new \danog\MadelineProto\API('session.madeline', $settings);
$MadelineProto->start();
