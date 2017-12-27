<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-carousel" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-carousel" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $glsform_api_country; ?></label>
            <div class="col-sm-10">
              <select name="gls_api" id="gls_api" class="form-control">
                <option <?php echo $gls_api == 'romania' ? 'selected = "selected"' : ''; ?> value="romania">Romania</option>
                <option <?php echo $gls_api == 'hungary' ? 'selected = "selected"' : ''; ?> value="hungary">Hungary</option>
                <option <?php echo $gls_api == 'slovakia' ? 'selected = "selected"' : ''; ?> value="slovakia">Slovakia</option>
                <option <?php echo $gls_api == 'czech' ? 'selected = "selected"' : ''; ?> value="czech">Czech</option>
                <option <?php echo $gls_api == 'slovenia' ? 'selected = "selected"' : ''; ?> value="slovenia">Slovenia</option>
                <option <?php echo $gls_api == 'croatia' ? 'selected = "selected"' : ''; ?> value="croatia">Croatia</option>
              </select>
              <?php if ($error_username) { ?>
              <div class="text-danger"><?php echo $error_username; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $glsform_username; ?></label>
            <div class="col-sm-10">
              <input type="text" name="gls_username" value="<?php echo $gls_username; ?>" placeholder="" id="input-username" class="form-control" />
              <?php if ($error_username) { ?>
              <div class="text-danger"><?php echo $error_username; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-password"><?php echo $glsform_password; ?></label>
            <div class="col-sm-10">
              <input type="password" name="gls_password" value="<?php echo $gls_password; ?>" placeholder="" id="input-password" class="form-control" />
              <?php if ($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-senderid"><?php echo $glsform_senderid; ?> </label>
            <div class="col-sm-10">
              <input type="text" name="gls_senderid" value="<?php echo $gls_senderid; ?>" placeholder="" id="input-senderid" class="form-control" />
            </div>
          </div>
          <hr>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $glsform_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-address"><?php echo $glsform_address; ?></label>
            <div class="col-sm-10">
              <input type="text" name="address" value="<?php echo $address; ?>" placeholder="" id="input-address" class="form-control" />
              <?php if ($error_address) { ?>
              <div class="text-danger"><?php echo $error_address; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-zip"><?php echo $glsform_postcode; ?></label>
            <div class="col-sm-10">
              <input type="text" name="zip" value="<?php echo $zip; ?>" placeholder="" id="input-zip" class="form-control" />
              <?php if ($error_zip) { ?>
              <div class="text-danger"><?php echo $error_zip; ?></div>
              <?php } ?>
            </div>
          </div>
          <!-- <div class="form-group">
            <label class="col-sm-2 control-label" for="input-city"><?php echo $glsform_city; ?></label>
            <div class="col-sm-10">
              <input type="text" name="city" value="<?php echo $city; ?>" placeholder="" id="input-city" class="form-control" />
              <?php if ($error_city) { ?>
              <div class="text-danger"><?php echo $error_city; ?></div>
              <?php } ?>
            </div>
          </div> -->

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-city"><?php echo $glsform_city; ?></label>
            <div class="col-sm-10">
              <input type="hidden" name="city" value="<?php echo $city; ?>" />
              <div id="magicsuggest"></div>
              <?php if ($error_city) { ?>
              <div class="text-danger"><?php echo $error_city; ?></div>
              <?php } ?>
            </div>
          </div>


          <script>
            var ms = $('#magicsuggest').magicSuggest({
              minChars: 2,
              allowFreeEntries: false,
              required: true,
              maxSelection: 1,
              name: 'shipping_city2',
              value: ['<?php echo $city; ?>'],
              valueField: 'id',
              displayField: 'oras',
              data: '<?php echo $postcodes_url; ?>'
            });

            $(ms).on('selectionchange', function(){
              var selectionagicpostcode = ms.getSelection()[0]['postcode'];
              var oras = ms.getSelection()[0]['oras'];
              //alert(selectionagicpostcode);
              if($.isNumeric(selectionagicpostcode)) {
                $('input[name=zip]').val(selectionagicpostcode);
                $('input[name=city]').val(oras);
              }

            });
          </script>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-country"><?php echo $glsform_country; ?></label>
            <div class="col-sm-10">
              <input type="text" name="country" value="<?php echo $country; ?>" placeholder="" id="input-country" class="form-control" />
              <?php if ($error_country) { ?>
              <div class="text-danger"><?php echo $error_country; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-contact"><?php echo $glsform_contact; ?></label>
            <div class="col-sm-10">
              <input type="text" name="contact" value="<?php echo $contact; ?>" placeholder="" id="input-contact" class="form-control" />
              <?php if ($error_contact) { ?>
              <div class="text-danger"><?php echo $error_contact; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-phone"><?php echo $glsform_phone; ?></label>
            <div class="col-sm-10">
              <input type="text" name="phone" value="<?php echo $phone; ?>" placeholder="" id="input-phone" class="form-control" />
              <?php if ($error_phone) { ?>
              <div class="text-danger"><?php echo $error_phone; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $glsform_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" placeholder="" id="input-email" class="form-control" />
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>