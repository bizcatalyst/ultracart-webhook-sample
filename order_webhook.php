<?php
/**
 * Created by PhpStorm.
 * User: perry
 * Date: 5/10/2017
 * Time: 1:00 PM
 */

require_once 'vendor/autoload.php';
require_once 'connection.php';

$json = file_get_contents('php://input');
$payload_obj = json_decode($json);  // array of key-value pairs.  key=event_name, value=order object.

$simple_key = getenv('API_KEY');
$order_api = ultracart\v2\api\OrderApi::usingApiKey($simple_key);
$expansion = "checkout"; // I need to request any objects using the REST API to contain the 'checkout' submodule because I'm examining the custom fields and they're located in the order/checkout sub class.

//Connect to droplet db
$db = new dbObj();
/*
if ($_SERVER['HTTP_HOST']=="localhost") {
  $db->username = "root";
  $db->password = "";
}
*/
$connString =  $db->getConnstring();

//log msg to db
$msg="We are connected!";
$sql = "import into test_log (msg) values '".$msg."'";
mysqli_query($connString, $sql) or die("could not insert into db");
/*
while( $row = mysqli_fetch_assoc($rs) ) {
  $queueTable.="<tr><td>".$row['searchPhrase']."</td><td><div style='max-height:100px;overflow-y:scroll;'>".nl2br($row['importLog']).
                "</div></td><td>".$row['total_products']."</td><td>".$row['num_imported']."</td><td>".$row['date_added']."</td>".
                "<td>".$row['date_started']."</td><td>".$row['date_completed']."</td></tr>";
}
*/

/*
 Sample JSON Payload:
{
  "events":[
    {"order_create":{"merchant_id":"DEMO","order_id":"DEMO-0009104420","current_stage":"Accounts Receivable","creation_dts":"2021-05-18T12:10:19-04:00","language_iso_code":"ENG"}}
  ]
}

 */

?>
<!DOCTYPE html>
<html lang="en">
<body>
<pre>
    <?php echo $json; ?>
</pre>
<br>
<pre>
    <?php var_dump($payload_obj); ?>
</pre>
<br>
<br>
<pre>
<?php

echo "Looping through all events.  They may not all be order_create, so check what type they are.\n";
foreach ($payload_obj->events as $event) {
    if (isset($event->order_create)) {
        $payload_order = $event->order_create;
        echo "Found order_create event. Loading order object using REST API\n";
        echo "Loading order object using REST API\n";
        echo "Requesting Order ID " . $payload_order->order_id . "\n";

        // Examine the custom fields in the webhook payload, and IF I need to update the order, pull the order
        // using REST first, make changes, and then call rest update method.  Do not pass the webhook object
        // into the rest update method.  Although they are the same object, the serialization methods may differ between
        // your code and the SDK.  To be safe, always fetch the SDK object for editing.

        $checkout_fields = $payload_order->checkout;

        // if there's nothing in custom field 1, skip it.
        if(!empty($checkout_fields->custom_field1)){

            // do some kind of comparison of custom field 1 and if criteria is met, update custom field 2
            // the default is program A.  If they heard about us from a friend, use program B.
            $my_marketing_program = 'MarketingProgramA';
            if($checkout_fields->custom_field1 == 'HeardFromFriend'){
                echo "Setting some arbitrary value in custom field 2.  This value means something to someone.\n";
                $my_marketing_program = 'MarketingProgramB';
            }

            // --- Start API section
            echo "Saving the order back to the server.\n";
            $order_response = $order_api->getOrder($payload_order->order_id, $expansion);
            $order = $order_response->getOrder();
            $order->getCheckout()->setCustomField2($my_marketing_program);
            $order_api->updateOrder($order, $payload_order->order_id, $expansion);
            // --- End API section

        } else {
            echo "There was nothing in custom field 1, so not doing anything with this order.\n";
        }

    } else {
        echo 'Event was not order_create, skipping.\n';
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
