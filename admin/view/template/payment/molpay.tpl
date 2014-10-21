<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
          <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
          <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <tr>
                        <td><?php echo $entry_merchantid; ?></td>
                        <td><input type="text" name="molpay_merchantid" value="<?php echo $molpay_merchantid; ?>" />
                        <?php if ($error_merchantid) { ?>
                        <span class="error"><?php echo $error_merchantid; ?></span>
                        <?php } ?>
                        </td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_verifykey; ?></td>
                      <td><input type="text" name="molpay_verifykey" value="<?php echo $molpay_verifykey; ?>" />
                        <?php if ($error_verifykey) { ?>
                        <span class="error"><?php echo $error_verifykey; ?></span>
                        <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_order_status; ?></td>
                      <td><select name="molpay_order_status_id">
                          <?php foreach ($order_statuses as $order_status) { ?>
                          <?php if ($order_status['order_status_id'] == $molpay_order_status_id) { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_pending_status; ?></td>
                      <td><select name="molpay_pending_status_id">
                          <?php foreach ($order_statuses as $order_status) { ?>
                          <?php if ($order_status['order_status_id'] == $molpay_pending_status_id) { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_success_status; ?></td>
                        <td><select name="molpay_success_status_id">
                            <?php foreach ($order_statuses as $order_status) { ?>
                            <?php if ($order_status['order_status_id'] == $molpay_success_status_id) { ?>
                            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                            <?php } ?>
                            <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_failed_status; ?></td>
                        <td><select name="molpay_failed_status_id">
                            <?php foreach ($order_statuses as $order_status) { ?>
                            <?php if ($order_status['order_status_id'] == $molpay_failed_status_id) { ?>
                            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                            <?php } ?>
                            <?php } ?>
                          </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_status; ?></td>
                        <td><select name="molpay_status">
                            <?php if ($molpay_status) { ?>
                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                            <option value="0"><?php echo $text_disabled; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_enabled; ?></option>
                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sort_order; ?></td>
                        <td><input type="text" name="molpay_sort_order" value="<?php echo $molpay_sort_order; ?>" size="1" /></td>
                    </tr>
                </table>
            </form>
            <div>
              <b style="color:red;">Next step:</b>
              <ol >
             <li style="padding:5px"> Login to <b><a href="https://www.onlinepayment.com.my/MOLPay/" target="_blank" >MOLPay merchant Admin</a></b> and go to <b style="color:red;">merchant profile</b>. </li>
             <?php $molpay_url = parse_url(HTTP_SERVER);  ?>
              <li style="padding:5px"> Put below url for <b style="color:red;">Return URL</b> value and tick <b style="color:red;">"Enable Return URL with IPN"</b>.
                <br />
              <i> <?php echo $molpay_url['scheme']; ?>://<?php echo $molpay_url['host']; ?>/index.php?route=payment/molpay/return_ipn
              </i></li>

              <li style="padding:5px"> Put below url for <b style="color:red;">Callback URL</b> and tick <b style="color:red;">"Yes"</b> to <b style="color:red;">"Enable Callback URL with IPN"</b>.
                <br /><i> <?php echo $molpay_url['scheme']; ?>://<?php echo $molpay_url['host']; ?>/index.php?route=payment/molpay/callback_ipn </i></li>
              </ol>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>