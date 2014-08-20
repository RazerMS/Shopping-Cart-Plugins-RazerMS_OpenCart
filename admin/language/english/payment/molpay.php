<?php
/**
 * MOLPay OpenCart Plugin
 * 
 * @package Payment Gateway
 * @author MOLPay Technical Team <technical@molpay.com>
 * @version 1.5.0
 */

// Versioning
$_['molpay_ptype'] = "OpenCart";
$_['molpay_pversion'] = "1.5.0";

// Heading
$_['heading_title']      = 'MOLPay Malaysia Online Payment Gateway (Visa, MasterCard, Maybank2u, MEPS, FPX, etc)';

// Text 
$_['text_payment']       = 'Payment';
$_['text_success']       = 'Success: You have modified MOLPay Malaysia Online Payment Gateway account details!';
$_['text_molpay']	     = '<a onclick="window.open(\'http://www.molpay.com/\');" style="text-decoration:none;"><img src="http://www.molpay.com/molpay_checkout.gif" alt="MOLPay Online Payment Gateway" title="MOLPay Malaysia Online Payment Gateway" style="border: 0px solid #EEEEEE;" height=63 width=198/></a>';

// Entry
$_['entry_merchantid']      = 'MOLPay Merchant ID:';
$_['entry_verifykey']       = 'MOLPay Verify Key:<br /><span class="help">Please refer to your MOLPay Merchant Profile for this key.</span>';
$_['entry_order_status']    = 'Order Status:';
$_['entry_pending_status']  = 'Pending Status:';
$_['entry_success_status']  = 'Success Status:';
$_['entry_failed_status']   = 'Failed Status:';
$_['entry_status']          = 'Status:';
$_['entry_sort_order']      = 'Sort Order:';

// Error
$_['error_permission']      = 'Warning: You do not have permission to modify MOLPay Malaysia Online Payment Gateway!';
$_['error_merchantid']      = '<b>MOLPay Merchant ID</b> Required!';
$_['error_verifykey']       = '<b>MOLPay Verify Key</b> Required!';
$_['error_settings']        = 'MOLPay merchant id and verify key mismatch, contact support@molpay.com to assist.';
$_['error_status']          = 'Unable to connect MOLPay API.';
?>