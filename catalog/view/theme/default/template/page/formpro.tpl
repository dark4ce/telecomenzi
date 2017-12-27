<div id="FormProModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $heading_title; ?></h4>
      </div>
      <div class="modal-body">
        <?php echo trim($description); ?>
        <div class="form-horizontal">
          <fieldset id="pageform-pro">
            <?php if($fieldset_title) { ?>
            <legend><?php echo $fieldset_title; ?></legend>
            <?php } ?>

            <div class="hide" style="display: none">
              <span class="text_processing"><?php echo $text_processing; ?></span>
              <span class="text_select"><?php echo $text_select; ?></span>
              <span class="text_none"><?php echo $text_none; ?></span>
            </div>

            <?php if ($page_form_pro_options) { ?>
              <?php foreach ($page_form_pro_options as $page_form_pro_option) { ?>
                <?php if ($page_form_pro_option['type'] == 'select') { ?>
                  <div class="form-group<?php echo ($page_form_pro_option['required'] ? ' required' : ''); ?>">
                    <label class="control-label col-sm-12" for="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>"><?php echo $page_form_pro_option['field_name']; ?></label>
                    <?php if(!empty($page_form_pro_option['field_help'])) { ?>
                    <div class="col-sm-12 text-help"><?php echo $page_form_pro_option['field_help']; ?></div>
                    <?php } ?>
                    <div class="col-sm-12">
                      <select name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>]" id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>" class="form-control">
                        <?php /* <option value=""><?php echo $text_select; ?></option> */ ?>
                        <?php foreach ($page_form_pro_option['page_form_pro_option_value'] as $page_form_pro_option_value) { ?>
                        <option value="<?php echo $page_form_pro_option_value['page_form_pro_option_value_id']; ?>"><?php echo $page_form_pro_option_value['name']; ?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($page_form_pro_option['type'] == 'radio') { ?>
                  <div class="form-group<?php echo ($page_form_pro_option['required'] ? ' required' : ''); ?>">
                    <label class="control-label col-sm-12"><?php echo $page_form_pro_option['field_name']; ?></label>
                    <?php if(!empty($page_form_pro_option['field_help'])) { ?>
                    <div class="col-sm-12 text-help"><?php echo $page_form_pro_option['field_help']; ?></div>
                    <?php } ?>
                    <div class="col-sm-12">
                      <div id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>">
                        <?php foreach ($page_form_pro_option['page_form_pro_option_value'] as $page_form_pro_option_value) { ?>
                        <div class="radio-inline">
                          <label>
                            <input type="radio" name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>]" value="<?php echo $page_form_pro_option_value['page_form_pro_option_value_id']; ?>" />
                            <?php echo $page_form_pro_option_value['name']; ?>
                          </label>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($page_form_pro_option['type'] == 'checkbox') { ?>
                  <div class="form-group<?php echo ($page_form_pro_option['required'] ? ' required' : ''); ?>">
                    <label class="control-label col-sm-12"><?php echo $page_form_pro_option['field_name']; ?></label>
                    <?php if(!empty($page_form_pro_option['field_help'])) { ?>
                    <div class="col-sm-12 text-help"><?php echo $page_form_pro_option['field_help']; ?></div>
                    <?php } ?>
                    <div class="col-sm-12">
                      <div id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>">
                        <?php foreach ($page_form_pro_option['page_form_pro_option_value'] as $page_form_pro_option_value) { ?>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>][]" value="<?php echo $page_form_pro_option_value['page_form_pro_option_value_id']; ?>" />
                            <?php echo $page_form_pro_option_value['name']; ?>
                          </label>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                <?php if (in_array($page_form_pro_option['type'], array('text', 'number', 'telephone', 'email', 'email_exists', 'postcode', 'address'))) { ?>
                  <div class="form-group<?php echo ($page_form_pro_option['required'] ? ' required' : ''); ?>">
                    <label class="control-label col-sm-12" for="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>"><?php echo $page_form_pro_option['field_name']; ?></label>
                    <?php if(!empty($page_form_pro_option['field_help'])) { ?>
                    <div class="col-sm-12 text-help"><?php echo $page_form_pro_option['field_help']; ?></div>
                    <?php } ?>
                    <div class="col-sm-12">
                      <input type="text" name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>]" id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>" value="" class="form-control" placeholder="<?php echo $page_form_pro_option['field_placeholder']; ?>">
                    </div>
                  </div>
                <?php } ?>
                <?php if ($page_form_pro_option['type'] == 'textarea') { ?>
                  <div class="form-group<?php echo ($page_form_pro_option['required'] ? ' required' : ''); ?>">
                    <label class="control-label col-sm-12" for="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>"><?php echo $page_form_pro_option['field_name']; ?></label>
                    <?php if(!empty($page_form_pro_option['field_help'])) { ?>
                    <div class="col-sm-12 text-help"><?php echo $page_form_pro_option['field_help']; ?></div>
                    <?php } ?>
                    <div class="col-sm-12">
                      <textarea name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>]" rows="5" placeholder="<?php echo $page_form_pro_option['field_placeholder']; ?>" id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>" class="form-control"></textarea>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($page_form_pro_option['type'] == 'file') { ?>
                  <div class="form-group<?php echo ($page_form_pro_option['required'] ? ' required' : ''); ?>">
                    <label class="control-label col-sm-12"><?php echo $page_form_pro_option['field_name']; ?></label>
                    <div class="col-sm-3">
                      <button type="button" id="builder-button-upload<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                      <input type="hidden" name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>]" value="" id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>" />
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($page_form_pro_option['type'] == 'date') { ?>
                  <div class="form-group<?php echo ($page_form_pro_option['required'] ? ' required' : ''); ?>">
                    <label class="control-label col-sm-12" for="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>"><?php echo $page_form_pro_option['field_name']; ?></label>
                    <?php if(!empty($page_form_pro_option['field_help'])) { ?>
                    <div class="col-sm-12 text-help"><?php echo $page_form_pro_option['field_help']; ?></div>
                    <?php } ?>
                    <div class="col-sm-12">
                      <div class="input-group date">
                        <input type="text" name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>]" value="" data-date-format="YYYY-MM-DD" id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>" class="form-control" placeholder="<?php echo $page_form_pro_option['field_placeholder']; ?>" />
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($page_form_pro_option['type'] == 'datetime') { ?>
                  <div class="form-group<?php echo ($page_form_pro_option['required'] ? ' required' : ''); ?>">
                    <label class="control-label col-sm-12" for="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>"><?php echo $page_form_pro_option['field_name']; ?></label>
                    <?php if(!empty($page_form_pro_option['field_help'])) { ?>
                    <div class="col-sm-12 text-help"><?php echo $page_form_pro_option['field_help']; ?></div>
                    <?php } ?>
                    <div class="col-sm-12">
                      <div class="input-group datetime">
                        <input type="text" name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>]" value="" data-date-format="YYYY-MM-DD HH:mm" id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>" class="form-control" placeholder="<?php echo $page_form_pro_option['field_placeholder']; ?>" />
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($page_form_pro_option['type'] == 'time') { ?>
                  <div class="form-group<?php echo ($page_form_pro_option['required'] ? ' required' : ''); ?>">
                    <label class="control-label col-sm-12" for="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>"><?php echo $page_form_pro_option['field_name']; ?></label>
                    <?php if(!empty($page_form_pro_option['field_help'])) { ?>
                    <div class="col-sm-12 text-help"><?php echo $page_form_pro_option['field_help']; ?></div>
                    <?php } ?>
                    <div class="col-sm-12">
                      <div class="input-group time">
                        <input type="text" name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>]" value="" data-date-format="HH:mm" id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>" class="form-control" placeholder="<?php echo $page_form_pro_option['field_placeholder']; ?>" />
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                        </span>
                      </div>
                    </div>
                  </div>
                <?php } ?>
                <?php if ($page_form_pro_option['type'] == 'country') { ?>
                  <div class="form-group<?php echo ($page_form_pro_option['required'] ? ' required' : ''); ?>">
                    <label class="control-label col-sm-12" for="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>"><?php echo $page_form_pro_option['field_name']; ?></label>
                    <?php if(!empty($page_form_pro_option['field_help'])) { ?>
                    <div class="col-sm-12 text-help"><?php echo $page_form_pro_option['field_help']; ?></div>
                    <?php } ?>
                    <div class="col-sm-12">
                      <select name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>]" id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>" class="form-control builder_country_id">
                        <option value=""><?php echo $text_select; ?></option>
                        <?php foreach ($countries as $country) { ?>
                        <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                <?php } ?>
                <?php if ($page_form_pro_option['type'] == 'zone') { ?>
                  <div class="form-group<?php echo ($page_form_pro_option['required'] ? ' required' : ''); ?>">
                    <label class="control-label col-sm-12" for="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>"><?php echo $page_form_pro_option['field_name']; ?></label>
                    <?php if(!empty($page_form_pro_option['field_help'])) { ?>
                    <div class="col-sm-12 text-help"><?php echo $page_form_pro_option['field_help']; ?></div>
                    <?php } ?>
                    <div class="col-sm-12">
                      <?php if($country_exists) { ?>
                      <select name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>]" id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>" class="form-control zone_id"></select>
                      <?php } else{ ?>
                      <select name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>]" id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>" class="form-control zone_id">
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
                <?php if (in_array($page_form_pro_option['type'], array('password', 'confirm_password'))) { ?>
                  <div class="form-group<?php echo ($page_form_pro_option['required'] ? ' required' : ''); ?>">
                    <label class="control-label col-sm-12" for="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>"><?php echo $page_form_pro_option['field_name']; ?></label>
                    <?php if(!empty($page_form_pro_option['field_help'])) { ?>
                    <div class="col-sm-12 text-help"><?php echo $page_form_pro_option['field_help']; ?></div>
                    <?php } ?>
                    <div class="col-sm-12">
                      <input type="password" name="field[<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>]" id="input-field<?php echo $page_form_pro_option['page_form_pro_option_id']; ?>" value="" class="form-control">
                    </div>
                  </div>
                <?php } ?>
              <?php } ?>
            <?php } ?>

            <div class="cicaptcha">
              <?php echo $captcha; ?>
            </div>

            <div class="buttons">
              <div class="pull-right">
                <button type="button" class="btn btn-primary button" id="button-submit-formbuilder" onclick="FORMBUILDERPRO.add('<?php echo $page_form_pro_id; ?>');" <?php echo $product_id ? 'data-product-id='. $product_id : ''; ?>><?php echo $button_continue; ?></button>
              </div>
            </div>
          </fieldset>
        </div>
        <?php echo trim($bottom_description); ?>
      </div>
    </div>
  </div>
<script type="text/javascript">
$('#FormProModal .date').datetimepicker({
  pickTime: false
});

$('#FormProModal .datetime').datetimepicker({
  pickDate: true,
  pickTime: true
});

$('#FormProModal .time').datetimepicker({
  pickDate: false
});

$('#FormProModal').on('hidden.bs.modal', function() {
  $(this).remove();
});
</script>
<style type="text/css">
#FormProModal .control-label { text-align: left; margin-bottom: 3px; }
#FormProModal .text-help{ margin-bottom: 3px; font-size: 11px; }
<?php echo $css; ?>
</style>
</div>