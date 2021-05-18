<?php
require_once '../vendor/autoload.php';
$simple_key = 'e31be7fff396d8016ff6d52da02dca008f13bf7253e8ca016ff6d52da02dca00';
$coupon_api = ultracart\v2\api\CouponApi::usingApiKey($simple_key);
$api_response = $coupon_api->getCouponByMerchantCode('10OFF');
echo '<html lang="en"><body><pre>';
var_dump($api_response);
// var_dump($api_response->getCoupon());
echo '</pre></body></html>';
?>

