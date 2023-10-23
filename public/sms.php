<?php
require 'vendor/autoload.php';
use AfricasTalking\SDK\AfricasTalking;
$username = 'mbanza';
$apiKey = '0d8b08f99b4bd1d36cf7dbaa00b9d322e91d4b1968aacaad634300e2f66b3e8a';

$AT = new AfricasTalking($username, $apiKey);
$sms = $AT->sms();

try {
    $result = $sms->send([
        'to' => '+250787654212',
        'message' => 'Welcome to IPRC KIGALI IAP Mornitoring, Tracking and Online Interaction System'
    ]);

    print_r($result);
} catch (GuzzleHttp\Exception\ClientException $e) {
    echo $e->getMessage();
}
?>