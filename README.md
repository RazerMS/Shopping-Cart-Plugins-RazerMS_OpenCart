MOLPay OpenCart Plugin
=====================

MOLPay Plugin for OpenCart Shopping Cart develop by MOLPay technical team.


Supported version
-----------------
OpenCart version 1.5.x.x


Notes
-----

MOLPay Sdn. Bhd. is not responsible for any problems that might arise from the use of this module. 
Use at your own risk. Please backup any critical data before proceeding. For any query or 
assistance, please email support@molpay.com 


Installations
-------------

1. Download or clone this repository. Copy all the file and paste it at your opencart root directory.  
`<OpenCart_DIR>/admin/*`  
`<OpenCart_DIR>/catalog/*`

2. Login to OpenCart administration, click on extension menu and click on Payments submenu.

3. You will see list of payment method available on your OpenCart. Click on [Install] link for MOLPay Online Payment Gateway (Visa, MasterCard, Maybank2u, MEPS, FPX, etc) to install this module into your online store.  

4. After you’ve successfully install this module, you need to click on [Edit] link for MOLPay Payment Gateway option to configure this payment module in your OpenCart online store.

5. Fill in your MOLPay Merchant ID & MOLPay Verify Key into the respective fields.

6. Save the configuration.

7. To set the Return URL and callback URL for this module, logon to your MOLPay Control Panel and go to your Merchant Profile. Add the following line into Return URL and callback URL field on your merchant profile and save the changes 

    `Return URL : http://www.yourdomain.com.my/index.php?route=payment/molpay/callback`
    
    `Callback URL : http://www.yourdomain.com.my/index.php?route=payment/molpay/callback_nb`

    **Kindly replace `www.yourdomain.com.my` with your online shop URL.

Contribution
------------

You can contribute to this plugin by sending the pull request to this repository.


Issues
------------

Submit issue to this repository or email to our support@molpay.com


Support
-------

Merchant Technical Support / Customer Care : support@molpay.com <br>
Sales/Reseller Enquiry : sales@molpay.com <br>
Marketing Campaign : marketing@molpay.com <br>
Channel/Partner Enquiry : channel@molpay.com <br>
Media Contact : media@molpay.com <br>
R&D and Tech-related Suggestion : technical@molpay.com <br>
Abuse Reporting : abuse@molpay.com
