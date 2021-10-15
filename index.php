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


        echo "Sending message\n";
        $client->sendMessage(array(
            'QueueUrl' => 'https://sqs.ap-south-1.amazonaws.com/<sqs url>', // write your SQS url here
            'MessageBody' => 'Your Message here', // write your message here.
         ));


        echo "Get message\n";
        $res = $client->receiveMessage(array(
                        'QueueUrl'          => 'https://sqs.ap-south-1.amazonaws.com/<sqs url>',
                        'WaitTimeSeconds'   => 1
                    ));
                    if ($res->getPath('Messages')) {
                
                
                        foreach ($res->getPath('Messages') as $msg) {
                            echo "Received Msg: ".$msg['Body']."<br>";
                            echo "MessageId".$msg['MessageId']."<br>";
                            // Do something useful with $msg['Body'] here
                            echo "Delete message\n";
                            $res = $client->deleteMessage(array(
                                'QueueUrl'      => 'https://sqs.ap-south-1.amazonaws.com/<sqs url>',
                                'ReceiptHandle' => $msg['ReceiptHandle']
                            ));
                        }
                    }
                    else
                    {
                            echo "no data found";
                    }

?>
