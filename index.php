<?php

// curl -sS https://getcomposer.org/installer | php
// php composer.phar require aws/aws-sdk-php

//export AWS_ACCESS_KEY_ID=...
//export AWS_SECRET_ACCESS_KEY=...

$queueUrl = 'https://sqs.ap-south-1.amazonaws.com/<your sqs >';

//download aws sdk for autoload.php
// composer require aws/aws-sdk-php

require_once 'vendor/autoload.php';
$sdk = new \Aws\Sdk();
$sqsClient = $sdk->createSqs(['region' => 'ap-south-1', 'version' => '2012-11-05']);



echo "Sending message\n";
$sqsClient->sendMessage(array(
    'QueueUrl' => $queueUrl,
    'MessageBody' => 'Hello World!',
));



echo "Receiving messages\n";
$result = $sqsClient->receiveMessage([
    'AttributeNames' => ['All'],
    'MaxNumberOfMessages' => 10,
    'QueueUrl' => $queueUrl,
]);
foreach ($result->search('Messages[]') as $message) {
    echo "- Message: {$message['Body']} (Id: {$message['MessageId']})\n";
}



echo "Deleting messages\n";
foreach ($result->search('Messages[]') as $message) {
    $sqsClient->deleteMessage([
        'QueueUrl' => $queueUrl,
        'ReceiptHandle' => $message['ReceiptHandle']
    ]);
    echo "- Deleted: {$message['MessageId']})\n";
}
