<?php
/**
 * MOLPay OpenCart Plugin
 * 
 * @package Payment Gateway
 * @author MOLPay Technical Team <technical@molpay.com>
 * @version 1.5.0
 */

class ControllerPaymentMolpay extends Controller {
    
    protected function index() {
            $this->data['button_confirm'] = $this->language->get('button_confirm');
            
            $this->load->model('checkout/order');
		
            $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
            $this->data['action'] = 'https://www.onlinepayment.com.my/MOLPay/pay/'.$this->config->get('molpay_merchantid').'/';
            
            $this->data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
            $this->data['orderid'] = $this->session->data['order_id'];
            $this->data['bill_name'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
            $this->data['bill_email'] = $order_info['email'];
            $this->data['bill_mobile'] = $order_info['telephone'];
            $this->data['country'] = $order_info['payment_iso_code_2'];
            $this->data['currency'] = $order_info['currency_code'];
            $this->data['vcode'] = md5($this->data['amount'].$this->config->get('molpay_merchantid').$this->data['orderid'].$this->config->get('molpay_verifykey'));
            
            $products = $this->cart->getProducts();
            foreach ($products as $product) {
                $this->data['prod_desc'][]= $product['name']." x ".$product['quantity'];
            }

            $this->data['order_id'] = $this->session->data['order_id'];
            
            $this->data['lang'] = $this->session->data['language'];

            $this->data['returnurl'] = $this->url->link('payment/molpay/return_ipn', '', 'SSL');
		
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/molpay.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/payment/molpay.tpl';
            } else {
                    $this->template = 'default/template/payment/molpay.tpl';
            }	
		
            $this->render();
    }
	
	/* return url */
    public function return_ipn() {
 
        $this->load->model('checkout/order');

        $verifykey = $this->config->get('molpay_verifykey');

        $_POST['treq']=   1;

        $tranID = $_POST['tranID'];
        $orderid = $_POST['orderid'];
        $status = $_POST['status'];
        $domain = $_POST['domain'];
        $amount = $_POST['amount'];
        $currency = $_POST['currency'];
        $appcode = $_POST['appcode'];
        $paydate = $_POST['paydate'];
        $skey = $_POST['skey'];

        /***********************************************************
        * Backend acknowledge method for IPN (DO NOT MODIFY)
        ************************************************************/
        while ( list($k,$v) = each($_POST) ) {
          $postData[]= $k."=".$v;
        }
        $postdata   = implode("&",$postData);
        $url        = "https://www.onlinepayment.com.my/MOLPay/API/chkstat/returnipn.php";
        $ch         = curl_init();
        curl_setopt($ch, CURLOPT_POST           , 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS     , $postdata);
        curl_setopt($ch, CURLOPT_URL            , $url);
        curl_setopt($ch, CURLOPT_HEADER         , 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT    , TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , FALSE);
        //curl_setopt($ch, CURLOPT_SSLVERSION     , 3);
        $result = curl_exec( $ch );
        curl_close( $ch );
        /***********************************************************
        * End of Acknowledge method for IPN
        ************************************************************/

        $key0 = md5($tranID.$orderid.$status.$domain.$amount.$currency);
        $key1 = md5($paydate.$domain.$key0.$appcode.$verifykey);

        if ( $skey != $key1 ) 
            $status = -1 ;

        $order_info = $this->model_checkout_order->getOrder($this->request->post['orderid']); // orderid

        $this->model_checkout_order->confirm($this->request->post['orderid'], $this->config->get('molpay_order_status_id'));
        
        if ( $status == "00" )  {
            $this->model_checkout_order->update($orderid , $this->config->get('molpay_success_status_id'), 'MP Normal Return', false);
            $this->redirect(HTTP_SERVER . 'index.php?route=checkout/success');
        } elseif( $status == "22" ) {
            $this->model_checkout_order->update($orderid , $this->config->get('molpay_pending_status_id'), 'MP Normal Return', false);
            $this->redirect(HTTP_SERVER . 'index.php?route=checkout/success');		
        } else {
            $this->model_checkout_order->update($orderid , $this->config->get('molpay_failed_status_id'), 'MP Normal Return', false);
            
            $this->data['continue'] = $this->url->link('checkout/cart');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/molpay_fail.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/payment/molpay_fail.tpl';
            } else {
                $this->template = 'default/template/payment/molpay_fail.tpl';
            }
            $this->response->setOutput($this->render());            
        }
    }
     
    /*****************************************************
    * Callback with IPN(Instant Payment Notification)
    ******************************************************/
    public function callback_ipn()   {
        $this->load->model('checkout/order');

        $verifykey = $this->config->get('molpay_verifykey');

        $nbcb = $_POST['nbcb'];
        $tranID = $_POST['tranID'];
        $orderid = $_POST['orderid'];
        $status = $_POST['status'];
        $domain = $_POST['domain'];
        $amount = $_POST['amount'];
        $currency = $_POST['currency'];
        $appcode = $_POST['appcode'];
        $paydate = $_POST['paydate'];
        $skey = $_POST['skey'];

        $key0 = md5($tranID.$orderid.$status.$domain.$amount.$currency);
        $key1 = md5($paydate.$domain.$key0.$appcode.$verifykey);

        if ( $skey != $key1 )
            $status = -1 ;

            $order_info = $this->model_checkout_order->getOrder($this->request->post['orderid']); // orderid
            
	    //Confirm the order If not created yet
	    $this->model_checkout_order->confirm($this->request->post['orderid'], $this->config->get('molpay_order_status_id'));
	    
	    if ( $status == "00" ) {                
	        $this->model_checkout_order->update($orderid , $this->config->get('molpay_success_status_id'), 'MP Callback Return', false);
	    } elseif ( $status == "22" ) { 
	        $this->model_checkout_order->update($orderid, $this->config->get('molpay_pending_status_id'), 'MP Callback Return', false);
	    } elseif ( $status == "11" ) {
	        $this->model_checkout_order->update($orderid, $this->config->get('molpay_failed_status_id'), 'MP Callback Return', false);
	    } else { 
	        $this->model_checkout_order->update($orderid, $this->config->get('molpay_failed_status_id'), 'MP Callback Return', false);
	    }
	    
        if ($nbcb == 1) {
            echo "CBTOKEN:MPSTATOK";
        }
    }

    /*****************************************************
    * Notification with IPN(Instant Payment Notification)
    ******************************************************/
    public function notification_ipn()   {
        $this->load->model('checkout/order');

        $verifykey = $this->config->get('molpay_verifykey');

        $nbcb = $_POST['nbcb'];
        $tranID = $_POST['tranID'];
        $orderid = $_POST['orderid'];
        $status = $_POST['status'];
        $domain = $_POST['domain'];
        $amount = $_POST['amount'];
        $currency = $_POST['currency'];
        $appcode = $_POST['appcode'];
        $paydate = $_POST['paydate'];
        $skey = $_POST['skey'];

        $key0 = md5($tranID.$orderid.$status.$domain.$amount.$currency);
        $key1 = md5($paydate.$domain.$key0.$appcode.$verifykey);

        if ( $skey != $key1 )
            $status = -1 ;

        
            $order_info = $this->model_checkout_order->getOrder($this->request->post['orderid']); // orderid
            
            //Confirm the order If not created yet
            $this->model_checkout_order->confirm($this->request->post['orderid'], $this->config->get('molpay_order_status_id'));
            
            if ( $status == "00" ) {                
                $this->model_checkout_order->update($orderid , $this->config->get('molpay_success_status_id'), 'MP Callback Return', false);
            } elseif ( $status == "22" ) { 
                $this->model_checkout_order->update($orderid, $this->config->get('molpay_pending_status_id'), 'MP Callback Return', false);
            } elseif ( $status == "11" ) {
                $this->model_checkout_order->update($orderid, $this->config->get('molpay_failed_status_id'), 'MP Callback Return', false);
            } else { 
                $this->model_checkout_order->update($orderid, $this->config->get('molpay_failed_status_id'), 'MP Callback Return', false);
            }
        if ($nbcb == 2) {
            echo "CBTOKEN:MPSTATOK";
        }
    }
}
?>
