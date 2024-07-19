<?php
/**
 * Fiuu OpenCart Plugin
 * 
 * @package Payment Gateway
 * @author Fiuu Technical Team <technical@fiuu.com>
 * @version 1.5.0
 */
 
class ControllerPaymentMolpay extends Controller {
    
    private $error = array(); 

    public function index() {
        $this->load->language('payment/molpay');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        
        //if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->model_setting_setting->editSetting('molpay', $this->request->post);				
            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_all_zones'] = $this->language->get('text_all_zones');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');

        $this->data['entry_merchantid'] = $this->language->get('entry_merchantid');
        $this->data['entry_verifykey'] = $this->language->get('entry_verifykey');
        $this->data['entry_order_status'] = $this->language->get('entry_order_status');
        $this->data['entry_pending_status'] = $this->language->get('entry_pending_status');
        $this->data['entry_success_status'] = $this->language->get('entry_success_status');
        $this->data['entry_failed_status'] = $this->language->get('entry_failed_status');	
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['tab_general'] = $this->language->get('tab_general');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['account'])) {
            $this->data['error_merchantid'] = $this->error['account'];
        } else {
            $this->data['error_merchantid'] = '';
        }	

        if (isset($this->error['secret'])) {
            $this->data['error_verifykey'] = $this->error['secret'];
        } else {
            $this->data['error_verifykey'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_payment'),
            'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('payment/molpay', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('payment/molpay', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['molpay_merchantid'])) {
            $this->data['molpay_merchantid'] = $this->request->post['molpay_merchantid'];
        } else {
            $this->data['molpay_merchantid'] = $this->config->get('molpay_merchantid');
        }

        if (isset($this->request->post['molpay_verifykey'])) {
            $this->data['molpay_verifykey'] = $this->request->post['molpay_verifykey'];
        } else {
            $this->data['molpay_verifykey'] = $this->config->get('molpay_verifykey');
        }


        if (isset($this->request->post['molpay_order_status_id'])) {
            $this->data['molpay_order_status_id'] = $this->request->post['molpay_order_status_id'];
        } else {
            $this->data['molpay_order_status_id'] = $this->config->get('molpay_order_status_id'); 
        }

        if (isset($this->request->post['molpay_pending_status_id'])) {
            $this->data['molpay_pending_status_id'] = $this->request->post['molpay_pending_status_id'];
        } else {
            $this->data['molpay_pending_status_id'] = $this->config->get('molpay_pending_status_id');
        }

        if (isset($this->request->post['molpay_success_status_id'])) {
            $this->data['molpay_success_status_id'] = $this->request->post['molpay_success_status_id'];
        } else {
            $this->data['molpay_success_status_id'] = $this->config->get('molpay_success_status_id');
        }

        if (isset($this->request->post['molpay_failed_status_id'])) {
            $this->data['molpay_failed_status_id'] = $this->request->post['molpay_failed_status_id'];
        } else {
            $this->data['molpay_failed_status_id'] = $this->config->get('molpay_failed_status_id');
        }

        $this->load->model('localisation/order_status');

        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['molpay_status'])) {
            $this->data['molpay_status'] = $this->request->post['molpay_status'];
        } else {
            $this->data['molpay_status'] = $this->config->get('molpay_status');
        }

        if (isset($this->request->post['molpay_sort_order'])) {
            $this->data['molpay_sort_order'] = $this->request->post['molpay_sort_order'];
        } else {
            $this->data['molpay_sort_order'] = $this->config->get('molpay_sort_order');
        }

        $this->layout = 'common/layout';
        $this->template = 'payment/molpay.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        $this->response->setOutput($this->render());
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/molpay')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['molpay_merchantid']) {
            $this->error['account'] = $this->language->get('error_merchantid');
        }

        if (!$this->request->post['molpay_verifykey']) {
            $this->error['secret'] = $this->language->get('error_verifykey');
        }


        /***********************************************************
        * AUTO UPDATE TO MERCHANT PROFILE SETTINGS (DO NOT MODIFY)
        ************************************************************/
        $postdata = array();
        $postdata['molpay_merchantid'] = $this->request->post['molpay_merchantid'];
        $postdata['molpay_verifykey']  = $this->request->post['molpay_verifykey'];
        $postdata['molpay_ptype']      = $this->language->get('molpay_ptype');
        $postdata['molpay_pversion']   = $this->language->get('molpay_pversion');
        $postdata['domain']            = HTTP_SERVER;

        $url        = "https://www.onlinepayment.com.my/MOLPay/API/shoppingcart/index.php";
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS     , http_build_query($postdata));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        //curl_setopt($ch, CURLOPT_SSLVERSION, 3);    
        $response = curl_exec($ch);
        curl_close($ch);

        $response_data = explode("\r\n\r\n", "$response", 2);
        $response_header = $response_data[0];
        $response_body = $response_data[1];

        $json = json_decode($response_body);
        if(!$json->status)
        {
            $this->error['warning'] = $this->language->get('error_status');
        } elseif($json->status != "success")
        {
            $this->error['warning'] = $this->language->get('error_settings');
        }
        
        unset($postdata);
        /***********************************************************
        * End of UPDATE TO MERCHANT PROFILE SETTINGS
        ************************************************************/

        if (!$this->error) {
            return true;
        } else {
            return false;
        }	
    }
}
?>
