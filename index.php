<?php
    require 'vendor/autoload.php';

    use Aws\Sqs\SqsClient;



        $client = SqsClient::factory(array(

        'credentials' => array (
            'key' => '<write your key here>',
            'secret' => '<write your secret key here'
        ),

        'region' => 'ap-south-1',
        'version' => 'latest'
        ));
        
        $client->sendMessage(array(
            'QueueUrl' => 'https://sqs.ap-south-1.amazonaws.com/<sqs url>', // write your SQS url here
            'MessageBody' => 'Your Message here', // write your message here.
         ));
        
?>
