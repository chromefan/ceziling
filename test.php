<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<!--

<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
-->

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

<input name="cmd" type="hidden" value="_cart">

<input name="upload" type="hidden" value="1">

<input name="business" type="hidden" value="support-facilitator@chinascenic.com">

<input name="lc" type="hidden" value="us">


<input name="item_name_1" type="hidden" value="Test Paper 1"><!--商品名-->

<input name="item_number_1" type="hidden" value="1-1234"><!--物品号-->

<input name="amount_1" type="hidden" value="1.00"><!--价格-->

<input name="quantity_1" type="hidden" value="1"><!--数量-->

<!--
<input name="item_name_2" type="hidden" value="Test Paper 2">

<input name="item_number_2" type="hidden" value="2-ABCD">

<input name="amount_2" type="hidden" value="9.5">

<input name="quantity_2" type="hidden" value="2">
-->



<input name="no_note" type="hidden" value="0">

<input name="no_shipping" type="hidden" value="2">

<input name="currency_code" type="hidden" value="USD">

<input name="invoice" type="hidden" value="12345678901211"><!--订单编号-->

<!-- Enable override of buyers's address stored with PayPal . -->

<input type="hidden" name="address_override" value="1">

<!-- Set variables that override the address stored with PayPal.用户地址信息 -->

<input type="hidden" name="first_name" value="John">

<input type="hidden" name="last_name" value="Doe">

<input type="hidden" name="address1" value="345 Lark Ave">

<input type="hidden" name="city" value="San Jose">

<input type="hidden" name="state" value="CA">

<input type="hidden" name="zip" value="95121">

<input type="hidden" name="country" value="US">

<!-- Set variables that override the address stored with PayPal.用户地址信息结束 -->


<input type="hidden" name="notify_url" value="http://apppay.dili360.com/paypal/notify.php"><!--回调地址-->


<input name="bn" type="hidden" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">

<input name="submit" type="image" alt="PayPal - The safer, easier way to pay online!" src=" https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0">




</form>

</body>
</html>