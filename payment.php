<?php
declare(strict_types = 1);

require_once __DIR__ . '/database/session.php';

$session = Session::getInstance();
$serviceId = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/payment.css">
      <title>Payment</title>
   </head>
   <body>
      <main id="payment_page">
         <header>
            <h2>Payment information</h2>
         </header>
         <form id="payment_form">
            <input type="hidden" name="service_id" value="<?=$serviceId ?>">
            <label>
               Name on Card:
               <input type="text" name="name" required pattern="[a-zA-Z\s]{2,}">
            </label>
            <label>
               Address:
               <input type="text" name="address" required>
            </label>
            <label>
               Credit Card Number:
               <input type="text" name="cc_number" required pattern="\d{13,19}">
            </label>
            <label>
               Expiry Date (MM/YY):
               <input type="text" name="expiry" required pattern="(0[1-9]|1[0-2])\/\d{2}">
            </label>
            <label>
               Security Code (CVV):
               <input type="text" name="cvv" required pattern="\d{3,4}">
            </label>
            <button type="submit" name="action" value="confirm">Confirm Payment</button>
         </form>
      </main>
   </body>
</html>