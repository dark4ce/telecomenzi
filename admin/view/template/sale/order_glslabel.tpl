<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <img style="margin-right:20px;" class="pull-right" src="<?php echo HTTP_SERVER; ?>image/gls-logo.png">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>

  <form method="POST" action="">
    <div class="container-fluid">
      <?php foreach ($orders as $order) { ?>
      <div style="page-break-after: always;">
        <button style="margin-top:7px;" type="submit" id="printeaza-eticheta" class="btn btn-info pull-right"><?php echo $glsform_printlabel; ?></button>
        <h1><?php echo $glsform_create_label_for; ?> <?php echo $text_invoice; ?> #<?php echo $order['order_id']; ?></h1>
        <table class="table table-bordered">
          <thead>
          <tr>
            <td colspan="2"><?php echo $text_order_detail; ?></td>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td style="width: 50%;"><address>
                <strong><?php echo $order['store_name']; ?></strong><br />
                <?php echo $order['store_address']; ?>
              </address>
              <b><?php echo $text_telephone; ?></b> <?php echo $order['store_telephone']; ?><br />
              <?php if ($order['store_fax']) { ?>
              <b><?php echo $text_fax; ?></b> <?php echo $order['store_fax']; ?><br />
              <?php } ?>
              <b><?php echo $text_email; ?></b> <?php echo $order['store_email']; ?><br />
              <b><?php echo $text_website; ?></b> <a href="<?php echo $order['store_url']; ?>"><?php echo $order['store_url']; ?></a></td>
            <td style="width: 50%;"><b><?php echo $text_date_added; ?></b> <?php echo $order['date_added']; ?><br />
              <?php if ($order['invoice_no']) { ?>
              <b><?php echo $text_invoice_no; ?></b> <?php echo $order['invoice_no']; ?><br />
              <?php } ?>
              <b><?php echo $text_order_id; ?></b> <?php echo $order['order_id']; ?><br />
              <b><?php echo $text_payment_method; ?></b> <?php echo $order['payment_method']; ?><br />
              <?php if ($order['shipping_method']) { ?>
              <b><?php echo $text_shipping_method; ?></b> <?php echo $order['shipping_method']; ?><br />
              <?php } ?></td>
          </tr>
          </tbody>
        </table>
        <?php if(isset($error_gls)) : ?>
        <div class="alert alert-danger">
          <?php echo $error_gls; ?>
        </div>
        <?php endif; ?>
        <table class="table table-bordered">
          <thead>
          <tr>
            <td style="width: 33.3%;"><b><?php echo $glsform_sender; ?></b></td>
            <td style="width: 33.3%;"><b><?php echo $glsform_recipient; ?></b></td>
            <td style="width: 33.3%;"><b><?php echo $glsform_settings; ?></b></td>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td style="vertical-align: top;">
              <?php if(isset($senders)) : $i = 0; ?>
              <div  class="form-group">
                <label for="sender" class="control-label"><?php echo $glsform_choose_sender; ?></label>
                <select id="sender" class="form-control input-sm">
                  <?php foreach($senders as $sender) : ?>
                  <option value="<?php echo $i; ?>"><?php echo $sender['name']; ?></option>
                  <?php $i++; endforeach; ?>
                </select>
              </div>
              <?php endif; ?>
              <input type="hidden" name="sender_username" value="" />
              <input type="hidden" name="sender_password" value="" />
              <input type="hidden" name="sender_api_country" value="" />
              <input type="hidden" name="sender_senderid" value="" />
              <div class="form-group">
                <label for="name" class="control-label"><?php echo $glsform_name; ?></label>
                <input type="text" name="sender_name" readonly class="form-control input-sm" value="" id="name" placeholder="">
                <?php if ($error['sender_name']) { ?>
                <div class="text-danger"><?php echo $error['sender_name']; ?></div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="address" class="control-label"><?php echo $glsform_address; ?></label>
                <input type="text" name="sender_address" readonly class="form-control input-sm" value="" id="address" placeholder="">
                <?php if ($error['sender_address']) { ?>
                <div class="text-danger"><?php echo $error['sender_address']; ?></div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="postcode" class="control-label"><?php echo $glsform_postcode; ?></label>
                <input type="text" name="sender_postcode" readonly class="form-control input-sm" value="" id="postcode" placeholder="">
                <?php if ($error['sender_postcode']) { ?>
                <div class="text-danger"><?php echo $error['sender_postcode']; ?></div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="city" class="control-label"><?php echo $glsform_city; ?></label>
                <input type="text" name="sender_city" readonly class="form-control input-sm" value="" id="city" placeholder="">
                <?php if ($error['sender_city']) { ?>
                <div class="text-danger"><?php echo $error['sender_city']; ?></div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="country" class="control-label"><?php echo $glsform_country; ?></label>
                <input type="text" name="sender_country" readonly class="form-control input-sm" value="" id="country" placeholder="">
                <?php if ($error['sender_country']) { ?>
                <div class="text-danger"><?php echo $error['sender_country']; ?></div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="contact" class="control-label"><?php echo $glsform_contact; ?></label>
                <input type="text" name="sender_contact" readonly class="form-control input-sm" id="contact" placeholder="">
                <?php if ($error['sender_contact']) { ?>
                <div class="text-danger"><?php echo $error['sender_contact']; ?></div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="phone" class="control-label"><?php echo $glsform_phone; ?></label>
                <input type="text" name="sender_phone" readonly class="form-control input-sm" value="" id="phone" placeholder="">
                <?php if ($error['sender_phone']) { ?>
                <div class="text-danger"><?php echo $error['sender_phone']; ?></div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="email" class="control-label"><?php echo $glsform_email; ?></label>
                <input type="email" name="sender_email" readonly class="form-control input-sm" value="" id="email" placeholder="">
                <?php if ($error['sender_email']) { ?>
                <div class="text-danger"><?php echo $error['sender_email']; ?></div>
                <?php } ?>
              </div>
            </td>
            <td style="vertical-align: top;">


              <div class="form-group">
                <label for="name" class="control-label"><?php echo $glsform_name; ?></label>
                <input type="text" name="shipping_name" class="form-control input-sm" value="<?php echo $order['shipping_name']; ?>" id="name" placeholder="">
                <?php if ($error['shipping_name']) { ?>
                <div class="text-danger"><?php echo $error['shipping_name']; ?></div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="address" class="control-label"><?php echo $glsform_address; ?></label>
                <input type="text" name="shipping_address" class="form-control input-sm" value="<?php echo $order['shipping_address']; ?>" id="address" placeholder="">
                <?php if ($error['shipping_address']) { ?>
                <div class="text-danger"><?php echo $error['shipping_address']; ?></div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="postcode" class="control-label"><?php echo $glsform_postcode; ?></label>
                <input type="text" name="shipping_postcode" readonly class="form-control input-sm" value="<?php echo $order['shipping_postcode']; ?>" id="postcode" placeholder="">
                <?php if ($error['shipping_postcode']) { ?>
                <div class="text-danger"><?php echo $error['shipping_postcode']; ?></div>
                <?php } ?>
              </div>
              <!--
              <div class="form-group">
                <label for="city" class="control-label"><?php echo $glsform_city; ?></label>
                <input type="text" name="shipping_city" class="form-control input-sm" value="<?php echo $order['shipping_city']; ?>" id="city" placeholder="">
                <?php if ($error['shipping_city']) { ?>
                <div class="text-danger"><?php echo $error['shipping_city']; ?></div>
                <?php } ?>
              </div>
              -->
              <div class="form-group">
                <label for="city" class="control-label"><?php echo $glsform_city; ?></label>
                <input type="hidden" name="shipping_city" value="<?php echo $order['shipping_city']; ?>" />
                <div id="magicsuggest"></div>
              </div>

              <script>
                var ms = $('#magicsuggest').magicSuggest({
                  minChars: 2,
                  allowFreeEntries: false,
                  required: true,
                  maxSelection: 1,
                  name: 'shipping_city2',
                  value: ['<?php echo $order['shipping_city']; ?>'],
                  valueField: 'id',
                  displayField: 'oras',
                  data: '<?php echo $postcodes_url; ?>'
                });

                $(ms).on('selectionchange', function(){
                  var selectionagicpostcode = ms.getSelection()[0]['postcode'];
                  var oras = ms.getSelection()[0]['oras'];
                  //alert(selectionagicpostcode);
                  if($.isNumeric(selectionagicpostcode)) {
                    $('input[name=shipping_postcode]').val(selectionagicpostcode);
                    $('input[name=shipping_city]').val(oras);
                  }

                });
              </script>

              <div class="form-group">
                <label for="country" class="control-label"><?php echo $glsform_country; ?></label>
                <input type="text" name="shipping_country" class="form-control input-sm" value="<?php echo $order['shipping_country']; ?>" id="country" placeholder="">
                <?php if ($error['shipping_country']) { ?>
                <div class="text-danger"><?php echo $error['shipping_country']; ?></div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="contact" class="control-label"><?php echo $glsform_contact; ?></label>
                <input type="text" name="shipping_contact" class="form-control input-sm" value="<?php echo $order['shipping_contact']; ?>" id="contact" placeholder="">
                <?php if ($error['shipping_contact']) { ?>
                <div class="text-danger"><?php echo $error['shipping_contact']; ?></div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="phone" class="control-label"><?php echo $glsform_phone; ?></label>
                <input type="text" name="shipping_phone" class="form-control input-sm" value="<?php echo $order['telephone']; ?>" id="phone" placeholder="">
                <?php if ($error['shipping_phone']) { ?>
                <div class="text-danger"><?php echo $error['shipping_phone']; ?></div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="email" class="control-label"><?php echo $glsform_email; ?></label>
                <input type="email" name="shipping_email" class="form-control input-sm" value="<?php echo $order['email']; ?>" id="email" placeholder="">
                <?php if ($error['shipping_email']) { ?>
                <div class="text-danger"><?php echo $error['shipping_email']; ?></div>
                <?php } ?>
              </div>


            </td>
            <td style="vertical-align: top;">
              <div class="form-group">
                <label class="control-label" for="gls_pickupdate"><?php echo $glsform_pickupdate; ?></label>
                <div class="input-group date">
                  <input type="text" name="gls_pickupdate" value="<?php echo $gls_pickupdate; ?>" data-date-format="YYYY-MM-DD" id="gls_pickupdate" class="form-control input-sm" />
                <span class="input-group-btn">
                <button class="btn btn-default btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
              </div>
              <div class="form-group">
                <label for="gls_content" class="control-label"><?php echo $glsform_info; ?></label>
                <input type="text" name="gls_content" class="form-control input-sm" value="<?php echo $gls_content; ?>" id="gls_content" placeholder="">
              </div>
              <div class="form-group">
                <label for="gls_clientref" class="control-label"><?php echo $glsform_clientref; ?></label>
                <input type="text" name="gls_clientref" class="form-control input-sm" value="<?php echo $gls_clientref; ?>" id="gls_clientref" placeholder="">
              </div>
              <div class="form-group">
                <label for="gls_codamount" class="control-label"><?php echo $glsform_codamount; ?></label>
                <input type="text" name="gls_codamount" class="form-control input-sm" value="<?php echo $gls_codamount; ?>" id="gls_codamount" placeholder="">
              </div>
              <div class="form-group">
                <label for="gls_codref" class="control-label"><?php echo $glsform_codref; ?></label>
                <input type="text" name="gls_codref" class="form-control input-sm" value="<?php echo $gls_codref; ?>" id="gls_codref" placeholder="">
              </div>

              <h4><?php echo $glsform_services; ?>:</h4>
              <div class="form-group">
                <ul class="list-unstyled">
                  <li> <!-- T12 -->
                    <div id="gls_express_parcel_checkbox" class="checkbox">
                      <label>
                        <input class="check_services_errors" data-servicesdisable="gls_flex_delivery_checkbox,gls_pick_ship_checkbox,gls_pick_return_checkbox" id="gls_express_parcel" name="gls_express_parcel" <?php echo $gls_express_parcel == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                        Express Parcel
                      </label>
                    </div>
                  </li>
                  <li> <!-- FDS -->
                    <div id="gls_flex_delivery_checkbox" class="checkbox">
                      <label>
                        <input id="gls_flex_delivery" class="checkbox_extend check_services_errors" data-servicesdisable="gls_pick_return_checkbox,gls_express_parcel_checkbox" data-extendid="expand_flex" name="gls_flex_delivery" <?php echo $gls_flex_delivery == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                        Flex Delivery Service
                      </label>
                    </div>
                    <div id="expand_flex" style="display:none;">
                      <div class="form-group">
                        <label class="control-label" for="gls_flex_delivery_email"><?php echo $glsform_email; ?></label>
                        <input class="form-control input-sm" name="gls_flex_delivery_email" type="email" value="<?php echo "$gls_flex_delivery_email"; ?>">

                        <label class="control-label" for="gls_flex_delivery_sms"><?php echo $glsform_phone; ?></label>
                        <input class="form-control input-sm" name="gls_flex_delivery_sms" type="text" value="<?php echo "$gls_flex_delivery_sms"; ?>">
                      </div>
                    </div>
                  </li>

                  <li> <!-- PSS -->
                    <div id="gls_pick_ship_checkbox" class="checkbox">
                      <label>
                        <input id="gls_pick_ship" class="checkbox_extend check_services_errors" data-servicesdisable="gls_sms_checkbox,gls_express_parcel_checkbox,gls_pick_return_checkbox,gls_exchange_service_checkbox,gls_docreturn_checkbox,gls_declaredvalueinsurance_checkbox" data-extendid="expand_pick_ship" name="gls_pick_ship" <?php echo $gls_pick_ship == 1 ? 'checked' : ''; ?> type="checkbox" value="1" />
                        Pick & Ship Service
                      </label>
                    </div>
                    <div id="expand_pick_ship" style="display:none;">
                      <div class="form-group">
                        <label class="control-label" for="gls_pick_ship_date"><?php echo $glsform_date; ?> </label>
                        <div class="input-group date">
                          <input type="text" name="gls_pick_ship_date" value="<?php echo $gls_pick_ship_date; ?>" data-date-format="YYYY-MM-DD" id="gls_pick_ship_date" class="form-control input-sm" />
                          <span class="input-group-btn">
                          <button class="btn btn-default btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                          </span>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li> <!-- PRS -->
                    <div id="gls_pick_return_checkbox" class="checkbox">
                      <label>
                        <input id="gls_pick_return" class="checkbox_extend check_services_errors" data-servicesdisable="gls_flex_delivery_checkbox,gls_sms_checkbox,gls_express_parcel_checkbox,gls_pick_ship_checkbox,gls_exchange_service_checkbox,gls_docreturn_checkbox,gls_declaredvalueinsurance_checkbox"  data-extendid="expand_pick_return" name="gls_pick_return" <?php echo $gls_pick_return == 1 ? 'checked' : ''; ?> type="checkbox" value="1" />
                        Pick & Return Service
                      </label>
                    </div>
                    <div id="expand_pick_return" style="display:none;">
                      <div class="form-group">
                        <label class="control-label" for="gls_pick_return_date"><?php echo $glsform_date; ?> </label>
                        <div class="input-group date">
                          <input type="text" name="gls_pick_return_date" value="<?php echo $gls_pick_return_date; ?>" data-date-format="YYYY-MM-DD" id="gls_pick_return_date" class="form-control input-sm" />
                          <span class="input-group-btn">
                          <button class="btn btn-default btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                          </span>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li> <!-- SM1 -->
                    <div id="gls_sms_checkbox" class="checkbox">
                      <label>
                        <input id="gls_sms" class="checkbox_extend check_services_errors"  data-servicesdisable="gls_pick_ship_checkbox,gls_pick_return_checkbox" data-extendid="expand_sms" name="gls_sms" <?php echo $gls_sms == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                        SMS Service
                      </label>
                    </div>
                    <div id="expand_sms" style="display:none;">
                      <textarea name="gls_sms_msg" id="" cols="10" rows="3" class="form-control"><?php echo strlen($gls_sms_msg) > 0 ? $gls_sms_msg : $glsform_sms_msg ?></textarea>
                    </div>
                  </li>
                  <li> <!-- SM2 -->
                    <div id="gls_preadvice_checkbox" class="checkbox">
                      <label>
                        <input class="checkbox_extend" data-extendid="expand_preadvice" name="gls_preadvice" <?php echo $gls_preadvice == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                        Preadvice Service
                      </label>
                    </div>
                    <div id="expand_preadvice" style="display:none;">
                      Phone: <input class="form-control input-sm" name="gls_preadvice_phone" type="text" value="<?php echo "$gls_preadvice_phone"; ?>">
                    </div>
                  </li>
                  <li> <!-- XS -->
                    <div id="gls_exchange_service_checkbox" class="checkbox">
                      <label>
                        <input id="gls_exchange_service" name="gls_exchange_service" <?php echo $gls_exchange_service == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                        Exchange Service
                      </label>
                    </div>
                  </li>
                  <li> <!-- SZL -->
                    <div id="gls_docreturn_checkbox" class="checkbox">
                      <label>
                        <input id="gls_docreturn" class="checkbox_extend check_services_errors" data-servicesdisable="gls_pick_ship_checkbox,gls_pick_return_checkbox" data-extendid="expand_docnr" name="gls_docreturn" <?php echo $gls_docreturn == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                        Document Return Service
                      </label>
                    </div>
                    <div id="expand_docnr" style="display:none;">
                      <?php echo $glsform_document_number; ?><input class="form-control input-sm" name="gls_docreturn_num" type="text" value="<?php echo "$gls_docreturn_num"; ?>">
                    </div>
                  </li>
                  <li> <!-- INS -->
                    <div id="gls_declaredvalueinsurance_checkbox" class="checkbox">
                      <label>
                        <input id="gls_declaredvalueinsurance" class="checkbox_extend check_services_errors" data-servicesdisable="gls_pick_ship_checkbox,gls_pick_return_checkbox" data-extendid="expand_declaredvalueinsurance" name="gls_declaredvalueinsurance" <?php echo $gls_declaredvalueinsurance == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                        Declared Value Insurance Service
                      </label>
                    </div>
                    <div id="expand_declaredvalueinsurance" style="display:none;">
                      <?php echo $glsform_max_insurance_value; ?> <input class="form-control input-sm" name="gls_declaredvalueinsurance_num" type="text" value="<?php echo "$gls_declaredvalueinsurance_num"; ?>">
                    </div>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
        <table class="table table-bordered">
          <thead>
          <tr>
            <td><b><?php echo $column_product; ?></b></td>
            <td><b><?php echo $column_model; ?></b></td>
            <td class="text-right"><b><?php echo $column_quantity; ?></b></td>
            <td class="text-right"><b><?php echo $column_price; ?></b></td>
            <td class="text-right"><b><?php echo $column_total; ?></b></td>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($order['product'] as $product) { ?>
          <tr>
            <td><?php echo $product['name']; ?>
              <?php foreach ($product['option'] as $option) { ?>
              <br />
              &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
              <?php } ?></td>
            <td><?php echo $product['model']; ?></td>
            <td class="text-right"><?php echo $product['quantity']; ?></td>
            <td class="text-right"><?php echo $product['price']; ?></td>
            <td class="text-right"><?php echo $product['total']; ?></td>
          </tr>
          <?php } ?>
          <?php foreach ($order['voucher'] as $voucher) { ?>
          <tr>
            <td><?php echo $voucher['description']; ?></td>
            <td></td>
            <td class="text-right">1</td>
            <td class="text-right"><?php echo $voucher['amount']; ?></td>
            <td class="text-right"><?php echo $voucher['amount']; ?></td>
          </tr>
          <?php } ?>
          <?php foreach ($order['total'] as $total) { ?>
          <tr>
            <td class="text-right" colspan="4"><b><?php echo $total['title']; ?></b></td>
            <td class="text-right"><?php echo $total['text']; ?></td>
          </tr>
          <?php } ?>
          </tbody>
        </table>
        <?php if ($order['comment']) { ?>
        <table class="table table-bordered">
          <thead>
          <tr>
            <td><b><?php echo $text_comment; ?></b></td>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td><?php echo $order['comment']; ?></td>
          </tr>
          </tbody>
        </table>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
  </form>

  <script>
    $(document).ready(function(){

      var services_errors = $('.check_services_errors');

      services_errors.change(function(){
        var divtoexpand = $(this).data('servicesdisable');
        var divtoexpandarr = divtoexpand.split(',');

          for ( var i = 0, l = divtoexpandarr.length; i < l; i++ ) {
            if(this.checked) {
              $('#'+divtoexpandarr[i]).fadeOut('slow');
            }  else {
              $('#'+divtoexpandarr[i]).fadeIn('slow');
            }
          }
      });


      var checkbox_extended =  $('.checkbox_extend');

      checkbox_extended.each(function(i, obj) {
        var divtoexpand = $(this).data('extendid');
        if(this.checked) {
          $('#'+divtoexpand).fadeIn('slow');
        } else {
          $('#'+divtoexpand).fadeOut('slow');
        }
      });

      checkbox_extended.change(function(){
        var divtoexpand = $(this).data('extendid');
        if(this.checked) {
          $('#'+divtoexpand).fadeIn('slow');
        } else {
          $('#'+divtoexpand).fadeOut('slow');
        }
      });
      var sender_json = <?php echo $sender_json; ?>;

      fill_sender(0);
      $('select').on('change', function() {
        fill_sender(this.value);

      });
      function fill_sender(sender_id) {
        for(key in sender_json[sender_id])
        {
          if(sender_json[sender_id].hasOwnProperty(key))
            $('input[name='+key+']').val(sender_json[sender_id][key]);
        }
      }
      <?php if( isset($_GET['gls_printnow']) && $_GET['gls_printnow'] == 'true') : ?>
      $( "#printeaza-eticheta" ).click();
      <?php endif; ?>

      $('.date').datetimepicker({
        pickTime: false
      });

      $('.datetime').datetimepicker({
        pickDate: true,
        pickTime: true
      });

      $('.time').datetimepicker({
        pickDate: false
      });


    });
  </script>

</div>
<?php echo $footer; ?>