<?php
return ['name' => 'alex'];
$url = "http://workplace2.websitter.org:81/welcome -d" .  '{"a":"a", "bInt":1}';

$post_data = array (
    "bot" => "old",
    "text" => "Привет",
    "uid" => "32d82594-5578-45a8-8e08-4c7dc488320b"
);

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

$output = curl_exec($ch);
curl_close($ch);

echo $output;



?>

<?php
$orderDate = time();

$string = "test_merch_n1;workplace2.websitter.org:81;workplace2_1;".$orderDate.";1000;UAH;domain;1;1000";
$key = "flk3409refn54t54t*FNJRET";
$hash = hash_hmac("md5",$string,$key);
?>

 <form method="post" action="https://secure.wayforpay.com/pay">--}}
<input name="merchantAccount" value="test_merch_n1">
<input name="merchantAuthType" value="SimpleSignature">
<input name="merchantDomainName" value="workplace2.websitter.org:81">
<input name="merchantSignature" value="<?=$hash?>">
<input name="orderReference" value="workplace2_1">
<input name="orderDate" value="<?=$orderDate?>">
<input name="amount" value="1000">
<input name="currency" value="UAH">
<input name="productName[]" value="domain">
<input name="productPrice[]" value="1000">
<input name="productCount[]" value="1">
<input type="submit" value="send">
</form>
<!-- <input name="orderTimeout" value="49000"> -->
<!-- <input name="productName[]" value="Память Kingston DDR3-1600 4096MBPC3-12800"> -->
<!-- <input name="productPrice[]" value="547.36"> -->
<!-- <input name="productCount[]" value="1"> -->
<!-- <input name="clientFirstName" value="Вася">
<input name="clientLastName" value="Пупкин">
<input name="clientAddress" value="пр. Гагарина, 12">
<input name="clientCity" value="Днепропетровск">
<input name="clientEmail" value="some@mail.com"> -->
<!-- <input name="defaultPaymentSystem" value="card"> -->

<!-- merchantAccount - test_merch_n1

merchantSecretKey - flk3409refn54t54t*FNJRET -->

