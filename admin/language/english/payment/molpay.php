<?php
/**
 * Fiuu OpenCart Plugin
 * 
 * @package Payment Gateway
 * @author Fiuu Technical Team <technical@fiuu.com>
 * @version 1.5.0
 */

// Versioning
$_['molpay_ptype'] = "OpenCart";
$_['molpay_pversion'] = "1.5.0";

// Heading
$_['heading_title']      = 'Fiuu Payment Gateway (Visa, MasterCard, Maybank2u, MEPS, FPX, etc)';

// Text 
$_['text_payment']       = 'Payment';
$_['text_success']       = 'Success: You have modified Fiuu Payment Gateway account details!';
$_['text_molpay']	     = '<a onclick="window.open(\'http://www.fiuu.com/\');" style="text-decoration:none;"><img src="http://www.molpay.com/molpay_checkout.gif" alt="Fiuu Payment Gateway" title="Fiuu Payment Gateway" style="border: 0px solid #EEEEEE;" height=63 width=198/></a>';

// Entry
$_['entry_merchantid']      = 'Fiuu Merchant ID:';
$_['entry_verifykey']       = 'Fiuu Verify Key:<br /><span class="help">Please refer to your Fiuu Merchant Profile for this key.</span>';
$_['entry_order_status']    = 'Order Status:';
$_['entry_pending_status']  = 'Pending Status:';
$_['entry_success_status']  = 'Success Status:';
$_['entry_failed_status']   = 'Failed Status:';
$_['entry_status']          = 'Status:';
$_['entry_sort_order']      = 'Sort Order:';

// Error
$_['error_permission']      = 'Warning: You do not have permission to modify Fiuu Online Payment Gateway!';
$_['error_merchantid']      = '<b>Fiuu Merchant ID</b> Required!';
$_['error_verifykey']       = '<b>Fiuu Verify Key</b> Required!';
$_['error_settings']        = 'Fiuu merchant id and verify key mismatch, contact support@fiuu.com to assist.';
$_['error_status']          = 'Unable to connect Fiuu API.';
?>