<?php
/**
 * Created by PhpStorm.
 * User: perry
 * Date: 5/10/2017
 * Time: 1:00 PM
 */

require_once 'vendor/autoload.php';
$simple_key = 'e31be7fff396d8016ff6d52da02dca008f13bf7253e8ca016ff6d52da02dca00';
$order_api = ultracart\v2\api\OrderApi::usingApiKey($simple_key);
$expansion = "checkout"; // I need to request any objects using the REST API to contain the 'checkout' submodule because I'm examining the custom fields and they're located in the order/checkout sub class.


$json = file_get_contents('php://input');
$payload_obj = json_decode($json);  // array of key-value pairs.  key=event_name, value=order object.


?>
<!DOCTYPE html>
<html lang="en">
<body>

<pre>
<?php
echo 'Looping through all events.  There are ' . count($payload_obj->events) . "to examine.  They may not all be order_create, so check what type they are.";
foreach ($payload_obj->events as $event) {
    if (isset($event->order_create)) {
        echo 'Found order_create event. Loading order object using REST API';
        echo 'Requesting Order ID ' . $event->order_id;

        $order_response = $order_api->getOrder($event->order_id, $expansion);
        $order = $order_response->getOrder();
        $checkout_fields = $order->getCheckout();

        if(!empty($checkout_fields->getCustomField1())){
            // do some kind of comparison of custom field 1 and if criteria is met, update custom field 2
            if($checkout_fields->getCustomField1() == 'HeardFromFriend'){
                echo "Updating order, setting some arbitrary value in custom field 2.  This value means something to someone.";
                $checkout_fields->setCustomField2('MarketingProgramB');
            } else {
                echo "Updating order, setting some regular value in custom field 2.  This value means something to someone.";
                $checkout_fields->setCustomField2('MarketingProgramA');
            }
            echo "Saving the order back to the server.";
            $order_api->updateOrder($order, $event->order_id, $expansion);
        } else {
            echo "There was nothing in custom field 1, so not doing anything with this order.";
        }

    } else {
        echo 'Event was not order_create, skipping.';
    }


}
?>
</pre>
Finished examining webhook events.
<br>

These are all of the order events.
<pre>
"order_create"
"order_delete"
"order_payment_process"
"order_refund"
"order_reject"
"order_ship"
"order_stage_change"
"order_update"
</pre>

</body>
</html>