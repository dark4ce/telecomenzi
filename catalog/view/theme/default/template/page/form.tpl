<?php echo $header; ?>
<style type="text/css">
.form-horizontal .control-label{ text-align: left; margin-bottom: 3px; }
.form-horizontal .text-help{ margin-bottom: 3px; font-size: 11px; }
<?php echo $css; ?>
</style>
<div id="container" class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>

    <?php if ($column_left && $column_right) { ?>
    <?php $field_class = 'col-sm-12'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $field_class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $field_class = 'col-sm-6'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1 class="secondary-title"><?php echo $heading_title; ?></h1>
      <?php echo $description; ?>
      <div class="form-horizontal">
        <fieldset id="pageform">
          <?php if($fieldset_title) { ?>
          <legend><?php echo $fieldset_title; ?></legend>
          <?php } ?>
          <?php if ($page_form_options) { ?>
            <?php foreach ($page_form_options as $page_form_option) { ?>
              <?php if ($page_form_option['type'] == 'select') { ?>
                <div class="form-group<?php echo ($page_form_option['required'] ? ' required' : ''); ?>">
                  <label class="control-label col-sm-12" for="input-field<?php echo $page_form_option['page_form_option_id']; ?>"><?php echo $page_form_option['field_name']; ?></label>
                  <?php if(!empty($page_form_option['field_help'])) { ?>
                  <div class="col-sm-12 text-help"><?php echo $page_form_option['field_help']; ?></div>
                  <?php } ?>
                  <div class="<?php echo $field_class; ?>">
                    <select name="field[<?php echo $page_form_option['page_form_option_id']; ?>]" id="input-field<?php echo $page_form_option['page_form_option_id']; ?>" class="form-control">
                      <option value=""><?php echo $text_select; ?></option>
                      <?php foreach ($page_form_option['page_form_option_value'] as $page_form_option_value) { ?>
                      <option value="<?php echo $page_form_option_value['page_form_option_value_id']; ?>"><?php echo $page_form_option_value['name']; ?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <?php } ?>
                <?php if ($page_form_option['type'] == 'radio') { ?>
                <div class="form-group<?php echo ($page_form_option['required'] ? ' required' : ''); ?>">
                  <label class="control-label col-sm-12"><?php echo $page_form_option['field_name']; ?></label>
                  <?php if(!empty($page_form_option['field_help'])) { ?>
                  <div class="col-sm-12 text-help"><?php echo $page_form_option['field_help']; ?></div>
                  <?php } ?>
                  <div class="<?php echo $field_class; ?>">
                    <div id="input-field<?php echo $page_form_option['page_form_option_id']; ?>">
                      <?php foreach ($page_form_option['page_form_option_value'] as $page_form_option_value) { ?>
                      <div class="radio-inline">
                        <label>
                          <input type="radio" name="field[<?php echo $page_form_option['page_form_option_id']; ?>]" value="<?php echo $page_form_option_value['page_form_option_value_id']; ?>" />
                          <?php echo $page_form_option_value['name']; ?>
                        </label>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php if ($page_form_option['type'] == 'checkbox') { ?>
                <div class="form-group<?php echo ($page_form_option['required'] ? ' required' : ''); ?>">
                  <label class="control-label col-sm-12"><?php echo $page_form_option['field_name']; ?></label>
                  <?php if(!empty($page_form_option['field_help'])) { ?>
                  <div class="col-sm-12 text-help"><?php echo $page_form_option['field_help']; ?></div>
                  <?php } ?>
                  <div class="<?php echo $field_class; ?>">
                    <div id="input-field<?php echo $page_form_option['page_form_option_id']; ?>">
                      <?php foreach ($page_form_option['page_form_option_value'] as $page_form_option_value) { ?>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="field[<?php echo $page_form_option['page_form_option_id']; ?>][]" value="<?php echo $page_form_option_value['page_form_option_value_id']; ?>" />
                          <?php echo $page_form_option_value['name']; ?>
                        </label>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
              <?php if (in_array($page_form_option['type'], array('text', 'number', 'telephone', 'email', 'email_exists', 'postcode', 'address'))) { ?>
                <div class="form-group<?php echo ($page_form_option['required'] ? ' required' : ''); ?>">
                  <label class="control-label col-sm-12" for="input-field<?php echo $page_form_option['page_form_option_id']; ?>"><?php echo $page_form_option['field_name']; ?></label>
                  <?php if(!empty($page_form_option['field_help'])) { ?>
                  <div class="col-sm-12 text-help"><?php echo $page_form_option['field_help']; ?></div>
                  <?php } ?>
                  <div class="<?php echo $field_class; ?>">
                    <input type="text" name="field[<?php echo $page_form_option['page_form_option_id']; ?>]" id="input-field<?php echo $page_form_option['page_form_option_id']; ?>" value="" class="form-control" placeholder="<?php echo $page_form_option['field_placeholder']; ?>">
                  </div>
                </div>
              <?php } ?>
              <?php if ($page_form_option['type'] == 'textarea') { ?>
                <div class="form-group<?php echo ($page_form_option['required'] ? ' required' : ''); ?>">
                  <label class="control-label col-sm-12" for="input-field<?php echo $page_form_option['page_form_option_id']; ?>"><?php echo $page_form_option['field_name']; ?></label>
                  <?php if(!empty($page_form_option['field_help'])) { ?>
                  <div class="col-sm-12 text-help"><?php echo $page_form_option['field_help']; ?></div>
                  <?php } ?>
                  <div class="<?php echo $field_class; ?>">
                    <textarea name="field[<?php echo $page_form_option['page_form_option_id']; ?>]" rows="5" placeholder="<?php echo $page_form_option['field_placeholder']; ?>" id="input-field<?php echo $page_form_option['page_form_option_id']; ?>" class="form-control"></textarea>
                  </div>
                </div>
                <?php } ?>
                <?php if ($page_form_option['type'] == 'file') { ?>
                <div class="form-group<?php echo ($page_form_option['required'] ? ' required' : ''); ?>">
                  <label class="control-label col-sm-12"><?php echo $page_form_option['field_name']; ?></label>
                  <div class="col-sm-3">
                    <button type="button" id="button-upload<?php echo $page_form_option['page_form_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                    <input type="hidden" name="field[<?php echo $page_form_option['page_form_option_id']; ?>]" value="" id="input-field<?php echo $page_form_option['page_form_option_id']; ?>" />
                  </div>
                </div>
                <?php } ?>
                <?php if ($page_form_option['type'] == 'date') { ?>
                <div class="form-group<?php echo ($page_form_option['required'] ? ' required' : ''); ?>">
                  <label class="control-label col-sm-12" for="input-field<?php echo $page_form_option['page_form_option_id']; ?>"><?php echo $page_form_option['field_name']; ?></label>
                  <?php if(!empty($page_form_option['field_help'])) { ?>
                  <div class="col-sm-12 text-help"><?php echo $page_form_option['field_help']; ?></div>
                  <?php } ?>
                  <div class="<?php echo $field_class; ?>">
                    <div class="input-group date">
                      <input type="text" name="field[<?php echo $page_form_option['page_form_option_id']; ?>]" value="" data-date-format="YYYY-MM-DD" id="input-field<?php echo $page_form_option['page_form_option_id']; ?>" class="form-control" placeholder="<?php echo $page_form_option['field_placeholder']; ?>" />
                      <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                      </span>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php if ($page_form_option['type'] == 'datetime') { ?>
                <div class="form-group<?php echo ($page_form_option['required'] ? ' required' : ''); ?>">
                  <label class="control-label col-sm-12" for="input-field<?php echo $page_form_option['page_form_option_id']; ?>"><?php echo $page_form_option['field_name']; ?></label>
                  <?php if(!empty($page_form_option['field_help'])) { ?>
                  <div class="col-sm-12 text-help"><?php echo $page_form_option['field_help']; ?></div>
                  <?php } ?>
                  <div class="<?php echo $field_class; ?>">
                    <div class="input-group datetime">
                      <input type="text" name="field[<?php echo $page_form_option['page_form_option_id']; ?>]" value="" data-date-format="YYYY-MM-DD HH:mm" id="input-field<?php echo $page_form_option['page_form_option_id']; ?>" class="form-control" placeholder="<?php echo $page_form_option['field_placeholder']; ?>" />
                      <span class="input-group-btn">
                      <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                      </span>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php if ($page_form_option['type'] == 'time') { ?>
                <div class="form-group<?php echo ($page_form_option['required'] ? ' required' : ''); ?>">
                  <label class="control-label col-sm-12" for="input-field<?php echo $page_form_option['page_form_option_id']; ?>"><?php echo $page_form_option['field_name']; ?></label>
                  <?php if(!empty($page_form_option['field_help'])) { ?>
                  <div class="col-sm-12 text-help"><?php echo $page_form_option['field_help']; ?></div>
                  <?php } ?>
                  <div class="<?php echo $field_class; ?>">
                    <div class="input-group time">
                      <input type="text" name="field[<?php echo $page_form_option['page_form_option_id']; ?>]" value="" data-date-format="HH:mm" id="input-field<?php echo $page_form_option['page_form_option_id']; ?>" class="form-control" placeholder="<?php echo $page_form_option['field_placeholder']; ?>" />
                      <span class="input-group-btn">
                      <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                      </span>
                    </div>
                  </div>
                </div>
              <?php } ?>
              <?php if ($page_form_option['type'] == 'country') { ?>
                <div class="form-group<?php echo ($page_form_option['required'] ? ' required' : ''); ?>">
                  <label class="control-label col-sm-12" for="input-field<?php echo $page_form_option['page_form_option_id']; ?>"><?php echo $page_form_option['field_name']; ?></label>
                  <?php if(!empty($page_form_option['field_help'])) { ?>
                  <div class="col-sm-12 text-help"><?php echo $page_form_option['field_help']; ?></div>
                  <?php } ?>
                  <div class="<?php echo $field_class; ?>">
                    <select name="field[<?php echo $page_form_option['page_form_option_id']; ?>]" id="input-field<?php echo $page_form_option['page_form_option_id']; ?>" class="form-control country_id">
                      <option value=""><?php echo $text_select; ?></option>
                      <?php foreach ($countries as $country) { ?>
                      <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              <?php } ?>
              <?php if ($page_form_option['type'] == 'zone') { ?>
                <div class="form-group<?php echo ($page_form_option['required'] ? ' required' : ''); ?>">
                  <label class="control-label col-sm-12" for="input-field<?php echo $page_form_option['page_form_option_id']; ?>"><?php echo $page_form_option['field_name']; ?></label>
                  <?php if(!empty($page_form_option['field_help'])) { ?>
                  <div class="col-sm-12 text-help"><?php echo $page_form_option['field_help']; ?></div>
                  <?php } ?>
                  <div class="<?php echo $field_class; ?>">
                    <?php if($country_exists) { ?>
                    <select name="field[<?php echo $page_form_option['page_form_option_id']; ?>]" id="input-field<?php echo $page_form_option['page_form_option_id']; ?>" class="form-control zone_id"></select>
                    <?php } else{ ?>
                    <select name="field[<?php echo $page_form_option['page_form_option_id']; ?>]" id="input-field<?php echo $page_form_option['page_form_option_id']; ?>" class="form-control zone_id">
                      <option value=""><?php echo $text_select; ?></option>
                      <?php foreach($zones as $zone) { ?>
                      <option value="<?php echo $zone['zone_id']; ?>"><?php echo $zone['name']; ?>
                      </option>
                      <?php } ?>
                    </select>
                    <?php } ?>
                  </div>
                </div>
              <?php } ?>
              <?php if (in_array($page_form_option['type'], array('password', 'confirm_password'))) { ?>
                <div class="form-group<?php echo ($page_form_option['required'] ? ' required' : ''); ?>">
                  <label class="control-label col-sm-12" for="input-field<?php echo $page_form_option['page_form_option_id']; ?>"><?php echo $page_form_option['field_name']; ?></label>
                  <?php if(!empty($page_form_option['field_help'])) { ?>
                  <div class="col-sm-12 text-help"><?php echo $page_form_option['field_help']; ?></div>
                  <?php } ?>
                  <div class="<?php echo $field_class; ?>">
                    <input type="password" name="field[<?php echo $page_form_option['page_form_option_id']; ?>]" id="input-field<?php echo $page_form_option['page_form_option_id']; ?>" value="" class="form-control">
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
          <?php } ?>
          <div class="cicaptcha">
            <?php echo $captcha; ?>
          </div>
          
          <div class="buttons">
            <div class="pull-left">
              <button type="button" class="btn btn-primary button" id="button-submit"><?php echo $button_continue; ?></button>
            </div>
          </div>
        </fieldset>
      </div>
      <?php echo $bottom_description; ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
<script type="text/javascript"><!--
$('#button-submit').on('click', function() {
  $.ajax({
    url: 'index.php?route=page/form/add&page_form_id=<?php echo $page_form_id; ?>',
    type: 'post',
    data: $('#pageform input[type=\'text\'], #pageform input[type=\'hidden\'], #pageform input[type=\'password\'], #pageform input[type=\'radio\']:checked, #pageform input[type=\'checkbox\']:checked, #pageform select, #pageform textarea'),
    dataType: 'json',
    beforeSend: function() {
      $('#button-submit').button('loading');
    },
    complete: function() {
      $('#button-submit').button('reset');
    },
    success: function(json) {
      $('.alert, .text-danger').remove();
      $('.form-group').removeClass('has-error');

      if (json['error']) {

        if (json['error']['field']) {
          for (i in json['error']['field']) {
            var element = $('#input-field' + i.replace('_', '-'));
            if (element.parent().hasClass('input-group')) {
              element.parent().after('<div class="text-danger">' + json['error']['field'][i] + '</div>');
            } else {
              element.after('<div class="text-danger">' + json['error']['field'][i] + '</div>');
            }
          }
        }

        if(json['captcha']) {
          $('.cicaptcha').html(json['captcha']);
        }

        if (json['error']['warning']) {
          $('.breadcrumb').after('<div class="alert alert-danger warning"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

          $('html, body').animate({ scrollTop: 0 }, 'slow');
        }

        // Highlight any found errors
        $('.text-danger').parent().parent().addClass('has-error');
      }

      if (json['success']) {
        location = json['success'];
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});
//--></script>
<script type="text/javascript"><!--
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

$('button[id^=\'button-upload\']').on('click', function() {
  var node = this;

  $('#form-upload').remove();

  $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

  $('#form-upload input[name=\'file\']').trigger('click');

  if (typeof timer != 'undefined') {
      clearInterval(timer);
  }

  timer = setInterval(function() {
    if ($('#form-upload input[name=\'file\']').val() != '') {
      clearInterval(timer);

      $.ajax({
        url: 'index.php?route=tool/upload',
        type: 'post',
        dataType: 'json',
        data: new FormData($('#form-upload')[0]),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $(node).button('loading');
        },
        complete: function() {
          $(node).button('reset');
        },
        success: function(json) {
          $('.text-danger').remove();

          if (json['error']) {
            $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
          }

          if (json['success']) {
            alert(json['success']);

            $(node).parent().find('input').val(json['code']);
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    }
  }, 500);
});
//--></script>
<script type="text/javascript"><!--
$('.country_id').on('change', function() {
  $.ajax({
    url: 'index.php?route=page/form/country&country_id=' + this.value,
    dataType: 'json',
    beforeSend: function() {
      $('.country_id').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
    },
    complete: function() {
      $('.fa-spin').remove();
    },
    success: function(json) {

      html = '<option value=""><?php echo $text_select; ?></option>';

      if (json['zone'] && json['zone'] != '') {
        for (i = 0; i < json['zone'].length; i++) {
          html += '<option value="' + json['zone'][i]['zone_id'] + '"';
          html += '>' + json['zone'][i]['name'] + '</option>';
        }
      } else {
        html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
      }

      $('.zone_id').html(html);
    }
  });
});

$('.country_id').trigger('change');
//--></script>
</div>
<?php echo $footer; ?>