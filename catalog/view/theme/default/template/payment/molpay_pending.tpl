<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="" lang="" xml:lang="" >
<head>
    <title>MOLPay Failure Payment Page</title>
</head>
<body>
    <div style="text-align: center; font:10pt Arial; padding-top:50px;">
      <h3>Awaiting for payment !</h3>
      <h3>Your transaction with Fiuu Payment Gateway is now pending, please make a payment at any nearest authorised outlet.</h3>
      <h4 style='padding-top:20px;'>Please stay for a while. We will redirect you to online store.</h4>
      <img src='https://www.onlinepayment.com.my/MOLPay/templates/images/connect.gif' width='44' length='44' border=0>
    </div>
    <script type="text/javascript"><!--
    setTimeout('location = \'<?php echo $continue; ?>\';', 2500);
    //-->
    </script>
</body>
</html>