<?php
declare(strict_types = 1);

require_once __DIR__ . '/database/session.php';

$session = Session::getInstance();
$serviceId = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;
$type = $_GET['type'] ?? 'order';
?>



<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/payment.css">
      <script src="javascript/script.js" defer></script>
      <title>Payment</title>
   </head>
   <body>
      <main id="payment_page">
         <header>
            <h2>Payment information</h2>
         </header>
         <div id="payment_errors" class="error-container"></div>
         <form id="payment_form">
            <input type="hidden" name="csrf" value="<?= $session->getCSRFToken() ?>">
            <input type="hidden" name="service_id" value="<?=$serviceId ?>">
            <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">
            <label>
               Name on Card:
               <input type="text" name="name" required>
            </label>
            <label>
               Address:
               <input type="text" name="address" required>
            </label>
            <label>
               Credit Card Number:
               <input type="text" name="cc_number" required>
            </label>
            <label>
               Expiry Date (MM/YY):
               <input type="text" name="expiry" required>
            </label>
            <label>
               Security Code (CVV):
               <input type="text" name="cvv" required>
            </label>
            <button type="submit" name="action" value="confirm">Confirm Payment</button>
         </form>
      </main>
   </body>
</html>