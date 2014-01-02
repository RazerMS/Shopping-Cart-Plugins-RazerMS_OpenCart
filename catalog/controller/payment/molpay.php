<?php
/**
 * MOLPay OpenCart Plugin
 * 
 * @package Payment Gateway
 * @author MOLPay Technical Team <technical@molpay.com>
 * @version 1.4.0
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

            $this->data['returnurl'] = $this->url->link('payment/molpay/callback', '', 'SSL');
		
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/molpay.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/payment/molpay.tpl';
            } else {
                    $this->template = 'default/template/payment/molpay.tpl';
            }	
		
            $this->render();
    }
	
	/* return url */
    public function callback() {
 
        $this->load->model('checkout/order');

        $merchantid = $this->config->get('molpay_merchantid');
        $verifykey = $this->config->get('molpay_verifykey');

        $tranID 	= $_POST['tranID'];
        $orderid 	= $_POST['orderid'];
        $status 	= $_POST['status'];
        $domain 	= $_POST['domain'];
        $amount 	= $_POST['amount'];
        $currency 	= $_POST['currency'];
        $appcode 	= $_POST['appcode'];
        $paydate 	= $_POST['paydate'];
        $skey 		= $_POST['skey'];

        $key0 = md5($tranID.$orderid.$status.$domain.$amount.$currency);
        $key1 = md5($paydate.$merchantid.$key0.$appcode.$verifykey);

        if ( $skey != $key1 ) 
            $status = -1 ;

        $order_info = $this->model_checkout_order->getOrder($this->request->post['orderid']); // orderid

        $this->model_checkout_order->confirm($this->request->post['orderid'], $this->config->get('molpay_order_status_id'));
        
        if ( $status == "00" )  {
            $this->model_checkout_order->update($orderid , $this->config->get('molpay_success_status_id'), 'MP Normal Return', true);
            $this->redirect(HTTP_SERVER . 'index.php?route=checkout/success');
        } else {
            $this->model_checkout_order->update($orderid , $this->config->get('molpay_failed_status_id'), 'MP Normal Return', true);
            
            $this->data['continue'] = $this->url->link('checkout/cart');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/molpay_fail.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/payment/molpay_fail.tpl';
            } else {
                $this->template = 'default/template/payment/molpay_fail.tpl';
            }
            $this->response->setOutput($this->render());			
        }
    }
     
     /* callback */
    public function callback_nb()   {
        $this->load->model('checkout/order');

        $merchantid = $this->config->get('molpay_merchantid');
        $verifykey = $this->config->get('molpay_verifykey');

        $nbcb		= $_POST['nbcb'];
        $tranID		= $_POST['tranID'];
        $orderid	= $_POST['orderid'];
        $status		= $_POST['status'];
        $domain		= $_POST['domain'];
        $amount		= $_POST['amount'];
        $currency	= $_POST['currency'];
        $appcode	= $_POST['appcode'];
        $paydate	= $_POST['paydate'];
        $skey		= $_POST['skey'];

        $key0 = md5($tranID.$orderid.$status.$domain.$amount.$currency);
        $key1 = md5($paydate.$merchantid.$key0.$appcode.$verifykey);

        if ( $skey != $key1 )
            $status = -1 ;

        if ($nbcb == 1) {
            echo "CBTOKEN:MPSTATOK";
            $order_info = $this->model_checkout_order->getOrder($this->request->post['orderid']); // orderid
            
            //Confirm the order If not created yet
            $this->model_checkout_order->confirm($this->request->post['orderid'], $this->config->get('molpay_order_status_id'));
            
            if ( $status == "00" ) {                
                $this->model_checkout_order->update($orderid , $this->config->get('molpay_success_status_id'), 'MP Callback Return', true);
            }
            else { 
                $this->model_checkout_order->update($orderid, $this->config->get('molpay_failed_status_id'), 'MP Callback Return', true);
            }
        }
    }
}
?>