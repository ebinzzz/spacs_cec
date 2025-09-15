<?php
$APP_ID = "987985098e521954d9eed3ba7a589789";
$SECRET_KEY = "cfsk_ma_prod_c79cb7aa90c526835e4806b00ab87764_6b2ff4c4";
$CASHFREE_URL = "https://www.cashfree.com/checkout/post/submit"; // ✅ PRODUCTION

$event_id = 1;
$name = "ebin";
$email ="ebin.cec@gmail.com";
$phone = 8590594735;
$amount = 100;

$orderId = "SPACS" . time();
$returnUrl = "https://yourdomain.com/payment_success.php";
$notifyUrl = "https://yourdomain.com/payment_notify.php";

$data = [
    "appId" => $APP_ID,
    "orderId" => $orderId,
    "orderAmount" => $amount,
    "orderCurrency" => "INR",
    "orderNote" => "SPACS Event Registration",
    "customerName" => $name,
    "customerPhone" => $phone,
    "customerEmail" => $email,
    "returnUrl" => $returnUrl,
    "notifyUrl" => $notifyUrl
];

ksort($data);
$signatureData = "";
foreach ($data as $key => $value) {
    $signatureData .= "$key$value";
}
$signature = hash_hmac('sha256', $signatureData, $SECRET_KEY, false);
?>

<form action="<?= $CASHFREE_URL ?>" method="post" id="paymentForm">
    <?php foreach ($data as $key => $value): ?>
        <input type="hidden" name="<?= $key ?>" value="<?= htmlspecialchars($value) ?>" />
    <?php endforeach; ?>
    <input type="hidden" name="signature" value="<?= $signature ?>" />
</form>

<script>
    document.getElementById('paymentForm').submit();
</script>
