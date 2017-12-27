<?php echo $header; ?>
<style type="text/css">
   .maintabs a {
    padding: 20px !important;
   }
</style>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-page" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?> </a></div>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-page" class="form-horizontal">
          <ul class="nav nav-tabs maintabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><i class="fa fa-language" aria-hidden="true"></i> <?php echo $tab_general; ?></a></li>
            <li><a href="#tab-fields" data-toggle="tab"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo $tab_fields; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><i class="fa fa-cogs" aria-hidden="true"></i> <?php echo $tab_page; ?></a></li>
            <li><a href="#tab-link" data-toggle="tab"><i class="fa fa-link" aria-hidden="true"></i> <?php echo $tab_link; ?></a></li>
            <li><a href="#tab-email" data-toggle="tab"><i class="fa fa-bell" aria-hidden="true"></i> <?php echo $tab_email; ?></a></li>
            <li><a href="#tab-success-page" data-toggle="tab"><i class="fa fa-location-arrow" aria-hidden="true"></i> <?php echo $tab_success_page; ?></a></li>
            <li><a href="#tab-css" data-toggle="tab"><i class="fa fa-pencil" aria-hidden="true"></i> <?php echo $tab_css; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
               <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab">
                  <?php if(VERSION >= '2.2.0.0') { ?>
                    <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> 
                    <?php } else{ ?>
                    <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                    <?php } ?> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="page_form_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="page_form_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['description'] : ''; ?></textarea>
                      <?php if (isset($error_description[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_description[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-bottom-description<?php echo $language['language_id']; ?>"><?php echo $entry_bottom_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="page_form_description[<?php echo $language['language_id']; ?>][bottom_description]" placeholder="<?php echo $entry_bottom_description; ?>" id="input-bottom-description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['bottom_description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="page_form_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="page_form_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                    <div class="col-sm-10">
                      <textarea name="page_form_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>
                  <fieldset>
                    <legend><?php echo $text_form_attributes; ?></legend>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-fieldset-title<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_fieldset_title; ?>"><?php echo $entry_fieldset_title; ?></span></label>
                      <div class="col-sm-10">
                        <input type="text" name="page_form_description[<?php echo $language['language_id']; ?>][fieldset_title]" value="<?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['fieldset_title'] : ''; ?>" placeholder="<?php echo $entry_fieldset_title; ?>" id="input-fieldset-title<?php echo $language['language_id']; ?>" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-submit-button<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_submit_button; ?>"><?php echo $entry_submit_button; ?></span></label>
                      <div class="col-sm-10">
                        <input type="text" name="page_form_description[<?php echo $language['language_id']; ?>][submit_button]" value="<?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['submit_button'] : ''; ?>" placeholder="<?php echo $entry_submit_button; ?>" id="input-submit-button<?php echo $language['language_id']; ?>" class="form-control" />
                      </div>
                    </div>
                  </fieldset>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-data">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-top"><span data-toggle="tooltip" title="<?php echo $help_top; ?>"><?php echo $entry_top; ?></span></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <?php if ($top) { ?>
                      <input type="checkbox" name="top" value="1" checked="checked" id="input-top" />
                      <?php } else { ?>
                      <input type="checkbox" name="top" value="1" id="input-top" />
                      <?php } ?>
                      &nbsp; </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-bottom"><span data-toggle="tooltip" title="<?php echo $help_bottom; ?>"><?php echo $entry_bottom; ?></span></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <?php if ($bottom) { ?>
                      <input type="checkbox" name="bottom" value="1" checked="checked" id="input-bottom" />
                      <?php } else { ?>
                      <input type="checkbox" name="bottom" value="1" id="input-bottom" />
                      <?php } ?>
                      &nbsp; </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_captcha; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($captcha) { ?>
                    <input type="radio" name="captcha" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="captcha" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$captcha) { ?>
                    <input type="radio" name="captcha" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="captcha" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
                  <?php if ($error_keyword) { ?>
                  <div class="text-danger"><?php echo $error_keyword; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-link">
             <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_guest; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($show_guest) { ?>
                    <input type="radio" name="show_guest" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="show_guest" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$show_guest) { ?>
                    <input type="radio" name="show_guest" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="show_guest" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_customer_group; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($customer_groups as $customer_group) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($customer_group['customer_group_id'], $page_form_customer_group)) { ?>
                        <input type="checkbox" name="page_form_customer_group[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                        <?php echo $customer_group['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="page_form_customer_group[]" value="<?php echo $customer_group['customer_group_id']; ?>" />
                        <?php echo $customer_group['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $page_form_store)) { ?>
                        <input type="checkbox" name="page_form_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="page_form_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $page_form_store)) { ?>
                        <input type="checkbox" name="page_form_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="page_form_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_information; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($informations as $information) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($information['information_id'], $page_form_information)) { ?>
                        <input type="checkbox" name="page_form_information[]" value="<?php echo $information['information_id']; ?>" checked="checked" />
                        <?php echo $information['title']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="page_form_information[]" value="<?php echo $information['information_id']; ?>" />
                        <?php echo $information['title']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-fields">
              <div class="row">
                <div class="col-sm-4 col-xs-12 col-md-3">
                  <ul class="nav nav-pills nav-stacked" id="pageformfields">
                  <?php $field_row = 0; ?>
                    <?php foreach($fields as $field) { ?>
                    <li class="pageformfields-li"><a href="#tab-field<?php echo $field_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('a[href=\'#tab-field<?php echo $field_row; ?>\']').parent().remove(); $('#tab-field<?php echo $field_row; ?>').remove(); $('#pageformfields a:first').tab('show');"></i> <?php echo (!empty($field['description'][$config_language_id]['field_name']) ? $field['description'][$config_language_id]['field_name'] : $tab_field .'-' . ($field_row + (int)1)); ?> <i class="fa fa-arrows pull-right" aria-hidden="true"></i></a></li>
                    <?php $field_row++; ?>
                    <?php } ?>
                  </ul>
                  <ul class="nav nav-pills nav-stacked adfieldbutton">
                    <li><button type="button" class="btn btn-default btn-block" onclick="addField();"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo $button_add_field; ?></button></li>
                  </ul>
                </div>
                <div class="col-sm-8 col-xs-12 col-md-5">
                  <div class="tab-content" id="tab-content">
                  <?php $field_row = 0; ?>
                  <?php $page_form_option_value_row = 0; ?>
                    <?php foreach($fields as $field) { ?>
                    <div class="tab-pane" id="tab-field<?php echo $field_row; ?>">
                      <fieldset>
                        <legend><?php echo $text_lang_setting ?></legend>
                        <input type="hidden" name="page_form_field[<?php echo $field_row; ?>][page_form_option_id]" value="<?php echo (isset($field['page_form_option_id']) ? $field['page_form_option_id'] : ''); ?>" />
                        <div class="field-group">
                          <ul class="nav nav-tabs" id="field-language<?php echo $field_row; ?>">
                            <?php foreach ($languages as $language) { ?>
                            <li><a href="#field-language<?php echo $field_row; ?>-<?php echo $language['language_id']; ?>" data-toggle="tab">
                            <?php if(VERSION >= '2.2.0.0') { ?>
                            <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> 
                            <?php } else{ ?>
                            <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                            <?php } ?> <?php echo $language['name']; ?></a></li>
                            <?php } ?>
                          </ul>
                          <div class="tab-content">
                            <?php foreach ($languages as $language) { ?>
                            <div class="tab-pane" id="field-language<?php echo $field_row; ?>-<?php echo $language['language_id']; ?>">
                              <div class="form-group required">
                                <label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_field_name; ?>"><?php echo $entry_field_name; ?></span></label>
                                <div class="col-sm-12">
                                  <input type="text" name="page_form_field[<?php echo $field_row; ?>][description][<?php echo $language['language_id']; ?>][field_name]" value="<?php echo isset($field['description'][$language['language_id']]['field_name']) ? $field['description'][$language['language_id']]['field_name'] : ''; ?>" placeholder="<?php echo $entry_field_name; ?>" class="form-control" />
                                  <?php if (isset($error_field_name[$field_row][$language['language_id']])) { ?>
                                  <div class="text-danger"><?php echo $error_field_name[$field_row][$language['language_id']]; ?></div>
                                  <?php } ?>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_field_help; ?>"><?php echo $entry_field_help; ?></span></label>
                                <div class="col-sm-12">
                                  <textarea name="page_form_field[<?php echo $field_row; ?>][description][<?php echo $language['language_id']; ?>][field_help]" class="form-control"><?php echo isset($field['description'][$language['language_id']]['field_help']) ? $field['description'][$language['language_id']]['field_help'] : ''; ?></textarea>
                                </div>
                              </div>
                              <div class="form-group field-placeholder<?php echo $field_row; ?>">
                                <label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_field_placeholder; ?>"><?php echo $entry_field_placeholder; ?></span></label>
                                <div class="col-sm-12">
                                  <input type="text" name="page_form_field[<?php echo $field_row; ?>][description][<?php echo $language['language_id']; ?>][field_placeholder]" value="<?php echo isset($field['description'][$language['language_id']]['field_placeholder']) ? $field['description'][$language['language_id']]['field_placeholder'] : ''; ?>" placeholder="<?php echo $entry_field_placeholder; ?>" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group field-error<?php echo $field_row; ?>">
                                <label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_field_error; ?>"><?php echo $entry_field_error; ?></span></label>
                                <div class="col-sm-12">
                                  <input type="text" name="page_form_field[<?php echo $field_row; ?>][description][<?php echo $language['language_id']; ?>][field_error]" value="<?php echo isset($field['description'][$language['language_id']]['field_error']) ? $field['description'][$language['language_id']]['field_error'] : ''; ?>" placeholder="<?php echo $entry_field_error; ?>" class="form-control" />
                                </div>
                              </div>
                            </div>
                            <?php } ?>
                          </div>
                        </div>
                      </fieldset>
                      <fieldset>
                        <legend><?php echo $text_type_setting ?></legend>
                        <div class="form-group">
                          <label class="col-sm-12 control-label"><?php echo $entry_status; ?></label>
                          <div class="col-sm-12">
                            <select name="page_form_field[<?php echo $field_row; ?>][status]" class="form-control field-status" rel="<?php echo $field_row; ?>">
                              <?php if ($field['status']) { ?>
                              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                              <option value="0"><?php echo $text_disabled; ?></option>
                              <?php } else { ?>
                              <option value="1"><?php echo $text_enabled; ?></option>
                              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_required; ?>"><?php echo $entry_required; ?></span></label>
                          <div class="col-sm-12">
                            <select name="page_form_field[<?php echo $field_row; ?>][required]" class="form-control field-required" rel="<?php echo $field_row; ?>">
                              <?php if ($field['required']) { ?>
                              <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                              <option value="0"><?php echo $text_no; ?></option>
                              <?php } else { ?>
                              <option value="1"><?php echo $text_yes; ?></option>
                              <option value="0" selected="selected"><?php echo $text_no; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group hide">
                          <label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_sort_order; ?>"><?php echo $entry_sort_order; ?></span></label>
                          <div class="col-sm-12">
                            <input type="text" name="page_form_field[<?php echo $field_row; ?>][sort_order]"  value="<?php echo $field['sort_order']; ?>" class="form-control field-sortorder" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_type; ?>"><?php echo $entry_type; ?></span></label>
                          <div class="col-sm-12">
                            <select name="page_form_field[<?php echo $field_row; ?>][type]" class="form-control field-type" rel="<?php echo $field_row; ?>">
                              <optgroup label="<?php echo $text_choose; ?>">
                              <?php if ($field['type'] == 'select') { ?>
                              <option value="select" selected="selected"><?php echo $text_select; ?></option>
                              <?php } else { ?>
                              <option value="select"><?php echo $text_select; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'radio') { ?>
                              <option value="radio" selected="selected"><?php echo $text_radio; ?></option>
                              <?php } else { ?>
                              <option value="radio"><?php echo $text_radio; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'checkbox') { ?>
                              <option value="checkbox" selected="selected"><?php echo $text_checkbox; ?></option>
                              <?php } else { ?>
                              <option value="checkbox"><?php echo $text_checkbox; ?></option>
                              <?php } ?>
                              </optgroup>
                              <optgroup label="<?php echo $text_input; ?>">
                              <?php if ($field['type'] == 'text') { ?>
                              <option value="text" selected="selected"><?php echo $text_text; ?></option>
                              <?php } else { ?>
                              <option value="text"><?php echo $text_text; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'textarea') { ?>
                              <option value="textarea" selected="selected"><?php echo $text_textarea; ?></option>
                              <?php } else { ?>
                              <option value="textarea"><?php echo $text_textarea; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'number') { ?>
                              <option value="number" selected="selected"><?php echo $text_number; ?></option>
                              <?php } else { ?>
                              <option value="number"><?php echo $text_number; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'telephone') { ?>
                              <option value="telephone" selected="selected"><?php echo $text_telephone; ?></option>
                              <?php } else { ?>
                              <option value="telephone"><?php echo $text_telephone; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'email') { ?>
                              <option value="email" selected="selected"><?php echo $text_email; ?></option>
                              <?php } else { ?>
                              <option value="email"><?php echo $text_email; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'email_exists') { ?>
                              <option value="email_exists" selected="selected"><?php echo $text_email_exists; ?></option>
                              <?php } else { ?>
                              <option value="email_exists"><?php echo $text_email_exists; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'password') { ?>
                              <option value="password" selected="selected"><?php echo $text_password; ?></option>
                              <?php } else { ?>
                              <option value="password"><?php echo $text_password; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'confirm_password') { ?>
                              <option value="confirm_password" selected="selected"><?php echo $text_confirm_password; ?></option>
                              <?php } else { ?>
                              <option value="confirm_password"><?php echo $text_confirm_password; ?></option>
                              <?php } ?>
                              </optgroup>
                              <optgroup label="<?php echo $text_file; ?>">
                              <?php if ($field['type'] == 'file') { ?>
                              <option value="file" selected="selected"><?php echo $text_file; ?></option>
                              <?php } else { ?>
                              <option value="file"><?php echo $text_file; ?></option>
                              <?php } ?>
                              </optgroup>
                              <optgroup label="<?php echo $text_date; ?>">
                              <?php if ($field['type'] == 'date') { ?>
                              <option value="date" selected="selected"><?php echo $text_date; ?></option>
                              <?php } else { ?>
                              <option value="date"><?php echo $text_date; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'time') { ?>
                              <option value="time" selected="selected"><?php echo $text_time; ?></option>
                              <?php } else { ?>
                              <option value="time"><?php echo $text_time; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'datetime') { ?>
                              <option value="datetime" selected="selected"><?php echo $text_datetime; ?></option>
                              <?php } else { ?>
                              <option value="datetime"><?php echo $text_datetime; ?></option>
                              <?php } ?>
                              </optgroup>
                              <optgroup label="<?php echo $text_localisation; ?>">
                              <?php if ($field['type'] == 'country') { ?>
                              <option value="country" selected="selected"><?php echo $text_country; ?></option>
                              <?php } else { ?>
                              <option value="country"><?php echo $text_country; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'zone') { ?>
                              <option value="zone" selected="selected"><?php echo $text_zone; ?></option>
                              <?php } else { ?>
                              <option value="zone"><?php echo $text_zone; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'postcode') { ?>
                              <option value="postcode" selected="selected"><?php echo $text_postcode; ?></option>
                              <?php } else { ?>
                              <option value="postcode"><?php echo $text_postcode; ?></option>
                              <?php } ?>
                              <?php if ($field['type'] == 'address') { ?>
                              <option value="address" selected="selected"><?php echo $text_address; ?></option>
                              <?php } else { ?>
                              <option value="address"><?php echo $text_address; ?></option>
                              <?php } ?>
                              </optgroup>
                            </select>
                          </div>
                        </div>
                      </fieldset>
                      <fieldset id="field-values<?php echo $field_row;  ?>">
                        <legend><?php echo $text_value_setting; ?></legend>
                        <table id="pageformoption-value<?php echo $field_row; ?>" class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <td class="text-left required"><?php echo $entry_option_value; ?></td>
                              <td class="text-right"><?php echo $entry_sort_order; ?></td>
                              <td class="text-right"><?php echo $entry_action; ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if(!empty($field['option_value'])) { ?>
                            <?php foreach ($field['option_value'] as $page_form_option_value) { ?>
                            <tr id="pageformoption-value-row<?php echo $field_row; ?>-<?php echo $page_form_option_value_row; ?>">
                              <td class="text-left">
                                <input type="hidden" name="page_form_field[<?php echo $field_row; ?>][option_value][<?php echo $page_form_option_value_row; ?>][page_form_option_value_id]" value="<?php echo $page_form_option_value['page_form_option_value_id']; ?>" />
                                <?php foreach ($languages as $language) { ?>
                                <div class="input-group"><span class="input-group-addon">
                                <?php if(VERSION >= '2.2.0.0') { ?>
                                  <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> 
                                  <?php } else{ ?>
                                  <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                  <?php } ?></span>
                                  <input type="text" name="page_form_field[<?php echo $field_row; ?>][option_value][<?php echo $page_form_option_value_row; ?>][page_form_option_value_description][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($page_form_option_value['page_form_option_value_description'][$language['language_id']]['name']) ? $page_form_option_value['page_form_option_value_description'][$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_option_value; ?>" class="form-control" />
                                  <?php if (isset($error_value_name[$field_row][$page_form_option_value_row][$language['language_id']])) { ?>
                                  <div class="text-danger"><?php echo $error_value_name[$field_row][$page_form_option_value_row][$language['language_id']]; ?></div>
                                  <?php } ?>
                                </div>
                                <?php } ?></td>
                              <td class="text-right"><input type="text" name="page_form_field[<?php echo $field_row; ?>][option_value][<?php echo $page_form_option_value_row; ?>][sort_order]" value="<?php echo $page_form_option_value['sort_order']; ?>" class="form-control" /></td>
                              <td class="text-right"><button type="button" onclick="$('#pageformoption-value-row<?php echo $field_row; ?>-<?php echo $page_form_option_value_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                            </tr>
                            <?php $page_form_option_value_row++; ?>
                            <?php } ?>
                            <?php } ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="2"></td>
                              <td class="text-right"><button type="button" onclick="addPageFormOptionValue('<?php echo $field_row; ?>');" data-toggle="tooltip" title="<?php echo $button_option_value_add; ?>" class="btn  btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                            </tr>
                          </tfoot>
                        </table>
                      </fieldset>
                    </div>
                    <?php $field_row++; ?>
                  <?php } ?>
                  </div>
                </div>
                <div class="col-sm-12 col-xs-12 col-md-4">
                  <table class="table table-bordered table-responsive">
                    <thead><tr><td><?php echo $valid_field_type; ?></td><td><?php echo $valid_field_info; ?></td></tr></thead>
                    <thead><tr><td class="text-center" colspan="2"><?php echo $valid_select_type; ?></td></tr></thead>
                    <tbody>
                      <tr><td><?php echo $text_select; ?></td><td><?php echo $text_select_value; ?></td></tr>
                      <tr><td><?php echo $text_radio; ?></td><td><?php echo $text_radio_value; ?></td></tr>
                      <tr><td><?php echo $text_checkbox; ?></td><td><?php echo $text_checkbox_value; ?></td></tr>
                    </tbody>
                    <thead><tr><td class="text-center" colspan="2"><?php echo $valid_input_type; ?></td></tr></thead>
                    <tbody>
                      <tr><td><?php echo $text_text; ?></td><td><?php echo $text_text_value; ?></td></tr>
                      <tr><td><?php echo $text_textarea; ?></td><td><?php echo $text_textarea_value; ?></td></tr>
                      <tr><td><?php echo $text_number; ?></td><td><?php echo $text_number_value; ?></td></tr>
                      <tr><td><?php echo $text_telephone; ?></td><td><?php echo $text_telephone_value; ?></td></tr>
                      <tr><td><?php echo $text_email; ?></td><td><?php echo $text_email_value; ?></td></tr>
                      <tr><td><?php echo $text_email_exists; ?></td><td><?php echo $text_email_exists_value; ?></td></tr>
                      <tr><td><?php echo $text_password; ?></td><td><?php echo $text_password_value; ?></td></tr>
                      <tr><td><?php echo $text_confirm_password; ?></td><td><?php echo $text_confirm_value; ?></td></tr>
                    </tbody>
                    <thead><tr><td class="text-center" colspan="2"><?php echo $valid_file_type; ?></td></tr></thead>
                    <tbody>
                      <tr><td><?php echo $text_file; ?></td><td><?php echo $text_file_value; ?></td></tr>
                    </tbody>
                    <thead><tr><td class="text-center" colspan="2"><?php echo $valid_date_type; ?></td></tr></thead>
                    <tbody>
                      <tr><td><?php echo $text_date; ?></td><td><?php echo $text_date_value; ?></td></tr>
                      <tr><td><?php echo $text_time; ?></td><td><?php echo $text_time_value; ?></td></tr>
                      <tr><td><?php echo $text_datetime; ?></td><td><?php echo $text_datetime_value; ?></td></tr>
                    </tbody>
                    <thead><tr><td class="text-center" colspan="2"><?php echo $valid_localisation_type; ?></td></tr></thead>
                    <tbody>
                      <tr><td><?php echo $text_country; ?></td><td><?php echo $text_country_value; ?></td></tr>
                      <tr><td><?php echo $text_zone; ?></td><td><?php echo $text_zone_value; ?></td></tr>
                      <tr><td><?php echo $text_postcode; ?></td><td><?php echo $text_postcode_value; ?></td></tr>
                      <tr><td><?php echo $text_address; ?></td><td><?php echo $text_address_value; ?></td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-email">
              <ul class="nav nav-tabs" id="email">
                <li class="active"><a href="#tab-customer" data-toggle="tab"><i class="fa fa-users" aria-hidden="true"></i> <?php echo $tab_customer_email; ?></a></li>
                <li><a href="#tab-admin" data-toggle="tab"><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $tab_admin_email; ?></a></li>
              </ul>
              <div class="tab-content col-sm-9">
                <div class="tab-pane active" id="tab-customer">
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_customer_email_status; ?>"><?php echo $entry_customer_email_status; ?></span></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <?php if ($customer_email_status) { ?>
                        <input type="radio" name="customer_email_status" value="1" checked="checked" />
                        <?php echo $text_yes; ?>
                        <?php } else { ?>
                        <input type="radio" name="customer_email_status" value="1" />
                        <?php echo $text_yes; ?>
                        <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if (!$customer_email_status) { ?>
                        <input type="radio" name="customer_email_status" value="0" checked="checked" />
                        <?php echo $text_no; ?>
                        <?php } else { ?>
                        <input type="radio" name="customer_email_status" value="0" />
                        <?php echo $text_no; ?>
                        <?php } ?>
                      </label>
                    </div>
                  </div>
                  <div class="customeremaillanguage-group">
                    <ul class="nav nav-tabs" id="customer-email-language">
                      <?php foreach ($languages as $language) { ?>
                      <li><a href="#customer-email-language<?php echo $language['language_id']; ?>" data-toggle="tab"><?php if(VERSION >= '2.2.0.0') { ?>
                      <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> 
                      <?php } else{ ?>
                      <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                      <?php } ?> <?php echo $language['name']; ?></a></li>
                      <?php } ?>
                    </ul>
                    <div class="tab-content">
                      <?php foreach ($languages as $language) { ?>
                      <div class="tab-pane" id="customer-email-language<?php echo $language['language_id']; ?>">
                        <div class="form-group required">
                          <label class="col-sm-2 control-label" for="input-customer-subject<?php echo $language['language_id']; ?>"><?php echo $entry_customer_subject; ?></label>
                          <div class="col-sm-10">
                            <input type="text" name="page_form_description[<?php echo $language['language_id']; ?>][customer_subject]" value="<?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['customer_subject'] : ''; ?>" placeholder="<?php echo $entry_customer_subject; ?>" id="input-customer-subject<?php echo $language['language_id']; ?>" class="form-control" />
                            <?php if (isset($error_customer_subject[$language['language_id']])) { ?>
                            <div class="text-danger"><?php echo $error_customer_subject[$language['language_id']]; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="form-group required">
                          <label class="col-sm-2 control-label" for="input-customer-message<?php echo $language['language_id']; ?>"><?php echo $entry_customer_message; ?></label>
                          <div class="col-sm-10">
                            <textarea name="page_form_description[<?php echo $language['language_id']; ?>][customer_message]" placeholder="<?php echo $entry_customer_message; ?>" id="input-customer-message<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['customer_message'] : ''; ?></textarea>
                            <?php if (isset($error_customer_message[$language['language_id']])) { ?>
                            <div class="text-danger"><?php echo $error_customer_message[$language['language_id']]; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="tab-admin">
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_admin_email_status; ?></label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <?php if ($admin_email_status) { ?>
                        <input type="radio" name="admin_email_status" value="1" checked="checked" />
                        <?php echo $text_yes; ?>
                        <?php } else { ?>
                        <input type="radio" name="admin_email_status" value="1" />
                        <?php echo $text_yes; ?>
                        <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if (!$admin_email_status) { ?>
                        <input type="radio" name="admin_email_status" value="0" checked="checked" />
                        <?php echo $text_no; ?>
                        <?php } else { ?>
                        <input type="radio" name="admin_email_status" value="0" />
                        <?php echo $text_no; ?>
                        <?php } ?>
                      </label>
                    </div>
                  </div>
                  <div class="adminemaillanguage-group">
                    <div class="form-group required">
                      <label class="col-sm-2 control-label"><?php echo $entry_admin_email; ?></label>
                      <div class="col-sm-10">
                        <input type="text" name="admin_email" value="<?php echo $admin_email; ?>" class="form-control">
                        <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $alert_admin_email; ?></div>
                        <?php if ($error_admin_email) { ?>
                        <div class="text-danger"><?php echo $error_admin_email; ?></div>
                        <?php } ?>
                      </div>
                    </div>
                    <ul class="nav nav-tabs" id="admin-email-language">
                      <?php foreach ($languages as $language) { ?>
                      <li><a href="#admin-email-language<?php echo $language['language_id']; ?>" data-toggle="tab"><?php if(VERSION >= '2.2.0.0') { ?>
                      <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> 
                      <?php } else{ ?>
                      <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                      <?php } ?> <?php echo $language['name']; ?></a></li>
                      <?php } ?>
                    </ul>
                    <div class="tab-content">
                      <?php foreach ($languages as $language) { ?>
                      <div class="tab-pane" id="admin-email-language<?php echo $language['language_id']; ?>">
                        <div class="form-group required">
                          <label class="col-sm-2 control-label" for="input-admin-subject<?php echo $language['language_id']; ?>"><?php echo $entry_admin_subject; ?></label>
                          <div class="col-sm-10">
                            <input type="text" name="page_form_description[<?php echo $language['language_id']; ?>][admin_subject]" value="<?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['admin_subject'] : ''; ?>" placeholder="<?php echo $entry_admin_subject; ?>" id="input-admin-subject<?php echo $language['language_id']; ?>" class="form-control" />
                            <?php if (isset($error_admin_subject[$language['language_id']])) { ?>
                            <div class="text-danger"><?php echo $error_admin_subject[$language['language_id']]; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="form-group required">
                          <label class="col-sm-2 control-label" for="input-admin-message<?php echo $language['language_id']; ?>"><?php echo $entry_admin_message; ?></label>
                          <div class="col-sm-10">
                            <textarea name="page_form_description[<?php echo $language['language_id']; ?>][admin_message]" placeholder="<?php echo $entry_admin_message; ?>" id="input-admin-message<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['admin_message'] : ''; ?></textarea>
                            <?php if (isset($error_admin_message[$language['language_id']])) { ?>
                            <div class="text-danger"><?php echo $error_admin_message[$language['language_id']]; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <br/>
                <table class="table table-bordered">
                  <thead>
                    <tr><td><?php echo $const_names; ?></td><td><?php echo $const_short_codes; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo $const_logo; ?></td><td>{LOGO}</td>
                    </tr>
                    <tr>
                      <td><?php echo $const_store_name; ?></td><td>{STORE_NAME}</td>
                    </tr>
                    <tr>
                      <td><?php echo $const_store_link; ?></td><td>{STORE_LINK}</td>
                    </tr>
                    <tr>
                      <td><?php echo $const_name; ?></td><td>{INFORMATION}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane" id="tab-success-page">
              <ul class="nav nav-tabs" id="success-language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#success-language<?php echo $language['language_id']; ?>" data-toggle="tab"><?php if(VERSION >= '2.2.0.0') { ?>
                    <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> 
                    <?php } else{ ?>
                    <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                    <?php } ?> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="success-language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-success-title<?php echo $language['language_id']; ?>"><?php echo $entry_success_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="page_form_description[<?php echo $language['language_id']; ?>][success_title]" value="<?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['success_title'] : ''; ?>" placeholder="<?php echo $entry_success_title; ?>" id="input-success-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_success_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_success_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-success-description<?php echo $language['language_id']; ?>"><?php echo $entry_success_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="page_form_description[<?php echo $language['language_id']; ?>][success_description]" placeholder="<?php echo $entry_success_description; ?>" id="input-success-description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($page_form_description[$language['language_id']]) ? $page_form_description[$language['language_id']]['success_description'] : ''; ?></textarea>
                      <?php if (isset($error_success_description[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_success_description[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-css">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $tab_css; ?></label>
                <div class="col-sm-10">
                  <textarea style="height: 250px;" name="css" class="form-control"><?php echo $css; ?></textarea>
                </div>
              </div>           
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
  $('#language a:first').tab('show');
  $('#customer-email-language a:first').tab('show');
  $('#admin-email-language a:first').tab('show');
  $('#success-language a:first').tab('show');

  $('#email a:first').tab('show');

  $('#pageformfields li:first-child a').tab('show');
  <?php foreach($fields as $key => $field) { ?>
  $('#field-language<?php echo $key; ?> li:first-child a').tab('show');
  <?php } ?>
  //--></script>
  <script type="text/javascript"><!--
  $('input[name=\'admin_email_status\']').click(function() {
    if($('input[name=\'admin_email_status\']:checked').val() == 1) {
      $('.adminemaillanguage-group').slideDown(300);
    }else{
      $('.adminemaillanguage-group').slideUp(300);
    }
  });
  $('input[name=\'admin_email_status\']:checked').trigger('click');

  $('input[name=\'customer_email_status\']').click(function() {
    if($('input[name=\'customer_email_status\']:checked').val() == 1) {
      $('.customeremaillanguage-group').slideDown(300);
    }else{
      $('.customeremaillanguage-group').slideUp(300);
    }
  });
  $('input[name=\'customer_email_status\']:checked').trigger('click');
  //--></script>
 
<script type="text/javascript"><!--
$('#pageformfields a:first').tab('show');

var field_row = <?php echo $field_row; ?>;

function addField() {
  html = '<div class="tab-pane" id="tab-field' + field_row + '">';
    html += '<fieldset>';
      html += '<legend><?php echo $text_lang_setting ?></legend>';
      html += '<input type="hidden" name="page_form_field[' + field_row + '][page_form_option_id]" value="" />';
      html += '<div class="field-group">';
        html += '<ul class="nav nav-tabs" id="field-language' + field_row + '">';
          <?php foreach ($languages as $language) { ?>
          html += '<li><a href="#field-language' + field_row + '-<?php echo $language['language_id']; ?>" data-toggle="tab">';
          <?php if(VERSION >= '2.2.0.0') { ?>
          html += '<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />';
          <?php } else{ ?>
          html += '<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />';
          <?php } ?>
         html += ' <?php echo $language['name']; ?></a></li>';
          <?php } ?>
        html += '</ul>';
        html += '<div class="tab-content">';
          <?php foreach ($languages as $language) { ?>
          html += '<div class="tab-pane" id="field-language' + field_row + '-<?php echo $language['language_id']; ?>">';
            html += '<div class="form-group required">';
              html += '<label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_field_name; ?>"><?php echo $entry_field_name; ?></span></label>';
              html += '<div class="col-sm-12">';
                html += '<input type="text" name="page_form_field[' + field_row + '][description][<?php echo $language['language_id']; ?>][field_name]" value="" placeholder="<?php echo $entry_field_name; ?>" class="form-control" />';
              html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
              html += '<label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_field_help; ?>"><?php echo $entry_field_help; ?></span></label>';
              html += '<div class="col-sm-12">';
                html += '<textarea name="page_form_field[' + field_row + '][description][<?php echo $language['language_id']; ?>][field_help]" class="form-control"></textarea>';
              html += '</div>';
            html += '</div>';
            html += '<div class="form-group field-placeholder' + field_row + '">';
              html += '<label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_field_placeholder; ?>"><?php echo $entry_field_placeholder; ?></span></label>';
              html += '<div class="col-sm-12">';
                html += '<input type="text" name="page_form_field[' + field_row + '][description][<?php echo $language['language_id']; ?>][field_placeholder]" value="" placeholder="<?php echo $entry_field_placeholder; ?>" class="form-control" />';
              html += '</div>';
            html += '</div>';
            html += '<div class="form-group field-error' + field_row + '">';
              html += '<label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_field_error; ?>"><?php echo $entry_field_error; ?></span></label>';
              html += '<div class="col-sm-12">';
                html += '<input type="text" name="page_form_field[' + field_row + '][description][<?php echo $language['language_id']; ?>][field_error]" value="" placeholder="<?php echo $entry_field_error; ?>" class="form-control" />';
              html += '</div>';
            html += '</div>';
          html += '</div>';
          <?php } ?>
        html += '</div>';
      html += '</div>';
    html += '</fieldset>';
    html += '<fieldset>';
      html += '<legend><?php echo $text_type_setting ?></legend>';
          html += '<div class="form-group">';
            html += '<label class="col-sm-12 control-label"><?php echo $entry_status; ?></label>';
            html += '<div class="col-sm-12">';
              html += '<select name="page_form_field[' + field_row + '][status]" class="form-control field-status" rel="' + field_row + '">';
                html += '<option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
                html += '<option value="0"><?php echo $text_disabled; ?></option>';
              html += '</select>';
            html += '</div>';
          html += '</div>';
          html += '<div class="form-group">';
            html += '<label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_required; ?>"><?php echo $entry_required; ?></span></label>';
            html += '<div class="col-sm-12">';
              html += '<select name="page_form_field[' + field_row + '][required]" class="form-control field-required" rel="' + field_row + '">';
                html += '<option value="1" selected="selected"><?php echo $text_yes; ?></option>';
                html += '<option value="0"><?php echo $text_no; ?></option>';
              html += '</select>';
            html += '</div>';
          html += '</div>';
          html += '<div class="form-group hide">';
            html += '<label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_sort_order; ?>"><?php echo $entry_sort_order; ?></span></label>';
            html += '<div class="col-sm-12">';
              html += '<input type="text" name="page_form_field[' + field_row + '][sort_order]"  value="' + (field_row + parseInt(1)) + '" class="form-control field-sortorder" />';
            html += '</div>';
          html += '</div>';
          html += '<div class="form-group">';
            html += '<label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_type; ?>"><?php echo $entry_type; ?></span></label>';
            html += '<div class="col-sm-12">';
              html += '<select name="page_form_field[' + field_row + '][type]" class="form-control field-type" rel="' + field_row + '">';
                html += '<optgroup label="<?php echo $text_choose; ?>">';
                html += '<option value="select"><?php echo $text_select; ?></option>';
                html += '<option value="radio"><?php echo $text_radio; ?></option>';
                html += '<option value="checkbox"><?php echo $text_checkbox; ?></option>';
                html += '</optgroup>';
                html += '<optgroup label="<?php echo $text_input; ?>">';
                html += '<option value="text" selected="selected"><?php echo $text_text; ?></option>';
                html += '<option value="textarea"><?php echo $text_textarea; ?></option>';
                html += '<option value="number"><?php echo $text_number; ?></option>';
                html += '<option value="telephone"><?php echo $text_telephone; ?></option>';
                html += '<option value="email"><?php echo $text_email; ?></option>';
                html += '<option value="email_exists"><?php echo $text_email_exists; ?></option>';
                html += '<option value="password"><?php echo $text_password; ?></option>';
                html += '<option value="confirm_password"><?php echo $text_confirm_password; ?></option>';
                html += '</optgroup>';
                html += '<optgroup label="<?php echo $text_file; ?>">';
                html += '<option value="file"><?php echo $text_file; ?></option>';
                html += '</optgroup>';
                html += '<optgroup label="<?php echo $text_date; ?>">';
                html += '<option value="date"><?php echo $text_date; ?></option>';
                html += '<option value="time"><?php echo $text_time; ?></option>';
                html += '<option value="datetime"><?php echo $text_datetime; ?></option>';
                html += '</optgroup>';
                html += '<optgroup label="<?php echo $text_localisation; ?>">';
                html += '<option value="country"><?php echo $text_country; ?></option>';
                html += '<option value="zone"><?php echo $text_zone; ?></option>';
                html += '<option value="postcode"><?php echo $text_postcode; ?></option>';
                html += '<option value="address"><?php echo $text_address; ?></option>';
                html += '</optgroup>';
              html += '</select>';
            html += '</div>';
          html += '</div>';
    html += '</fieldset>';
    html += '<fieldset id="field-values' + field_row + '">';
      html += '<legend><?php echo $text_value_setting; ?></legend>';
        html += '<table id="pageformoption-value' + field_row + '" class="table table-striped table-bordered table-hover">';
          html += '<thead>';
            html += '<tr>';
              html += '<td class="text-left required"><?php echo $entry_option_value; ?></td>';
              html += '<td class="text-right"><?php echo $entry_sort_order; ?></td>';
              html += '<td class="text-right"><?php echo $entry_action; ?></td>';
            html += '</tr>';
          html += '</thead>';
          html += '<tbody>';
          html += '</tbody>';
          html += '<tfoot>';
            html += '<tr>';
              html += '<td colspan="2"></td>';
              html += '<td class="text-right"><button type="button" onclick="addPageFormOptionValue(' + field_row + ');" data-toggle="tooltip" title="<?php echo $button_option_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>';
            html += '</tr>';
          html += '</tfoot>';
        html += '</table>';
    html += '</fieldset>';
  html += '</div>';

  $('#tab-fields #tab-content').append(html);

  $('#pageformfields').append('<li class="pageformfields-li"><a href="#tab-field' + field_row + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick=" $(\'#pageformfields a:first\').tab(\'show\');$(\'a[href=\\\'#tab-field' + field_row + '\\\']\').parent().remove(); $(\'#tab-field' + field_row + '\').remove();"></i> <?php echo $tab_field; ?>-'+ (field_row + parseInt(1))  +' <i class="fa fa-arrows pull-right" aria-hidden="true"></i></a></li>');

  $('#pageformfields a[href=\'#tab-field' + field_row + '\']').tab('show');
  
  $('#field-language'+ field_row +' a:first').tab('show');

  $('[data-toggle=\'tooltip\']').tooltip({
    container: 'body',
    html: true
  });

  $('select[name=\'page_form_field[' + field_row + '][required]\'].field-required').trigger('change');
  $('select[name=\'page_form_field[' + field_row + '][type]\'].field-type').trigger('change');

  field_row++;
}
//--></script>
<script type="text/javascript"><!--
$('select[name=\'type\']').on('change', function() {
  if (this.value == 'select' || this.value == 'radio' || this.value == 'checkbox') {
    $('#pageoption-value').show();
  } else {
    $('#pageoption-value').hide();
  }
});

$('select[name=\'type\']').trigger('change');

var page_form_option_value_row = '<?php echo (isset($page_form_option_value_row) ? $page_form_option_value_row : 0); ?>';

function addPageFormOptionValue(field_row) {
  html  = '<tr id="pageformoption-value-row' + field_row + '-' + page_form_option_value_row + '">'; 
    html += '  <td class="text-left"><input type="hidden" name="page_form_field[' + field_row + '][option_value][' + page_form_option_value_row + '][page_form_option_value_id]" value="" />';
  <?php foreach ($languages as $language) { ?>
  html += '    <div class="input-group">';
  html += '      <span class="input-group-addon">';
  <?php if(VERSION >= '2.2.0.0') { ?>
  html += '<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />';
  <?php } else{ ?>
  html += '<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />';
  <?php } ?>
  html += '</span><input type="text" name="page_form_field[' + field_row + '][option_value][' + page_form_option_value_row + '][page_form_option_value_description][<?php echo $language['language_id']; ?>][name]" value="" placeholder="<?php echo $entry_option_value; ?>" class="form-control" />';
    html += '    </div>';
  <?php } ?>
  html += '  </td>';
  html += '  <td class="text-right"><input type="text" name="page_form_field[' + field_row + '][option_value][' + page_form_option_value_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
  html += '  <td class="text-right"><button type="button" onclick="$(\'#pageformoption-value-row' + field_row + '-' + page_form_option_value_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';  
  
  $('#pageformoption-value' + field_row + ' tbody').append(html);
  
  page_form_option_value_row++;
}
//--></script>
<script type="text/javascript"><!--
$(document).delegate('.field-type', 'change', function() {
  var rel = $(this).attr('rel');
  if (this.value == 'select' || this.value == 'radio' || this.value == 'checkbox') {
    $('#field-values'+ rel).show();
  } else {
    $('#field-values'+ rel).hide();
    $('#field-values'+ rel + ' tbody').html('');
  }

  if (this.value == 'text' || this.value == 'textarea' || this.value == 'number' || this.value == 'telephone' || this.value == 'email' || this.value == 'email_exists' || this.value == 'date' || this.value == 'time' || this.value == 'datetime' || this.value == 'postcode' || this.value == 'address') {
    $('.field-placeholder'+ rel).show();
  } else {
    $('.field-placeholder'+ rel).hide();
  }
});
$('.field-type').trigger('change');

$(document).delegate('.field-required', 'change', function() {
  var rel = $(this).attr('rel');
  if (this.value == '1') {
    $('.field-error'+ rel).show();
  } else {
    $('.field-error'+ rel).hide();
  }
});

$('.field-required').trigger('change');

<?php if(empty($fields)) { ?>
  addField();
<?php } ?>
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
  $("#pageformfields").sortable({
    cursor: "move",
    stop: function() {
      $('#pageformfields .pageformfields-li').each(function() {
        $($(this).find('a').attr('href')).find('.field-sortorder').val(($(this).index() + 1));
      });
    }
  });
});
//--></script>
<?php if(VERSION <= '2.2.0.0') { ?>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({ height: 300 });
$('#input-bottom-description<?php echo $language['language_id']; ?>').summernote({ height: 300 });
$('#input-customer-message<?php echo $language['language_id']; ?>').summernote({ height: 300 });
$('#input-admin-message<?php echo $language['language_id']; ?>').summernote({ height: 300 });
$('#input-success-description<?php echo $language['language_id']; ?>').summernote({ height: 300 });
<?php } ?>
//--></script>
<?php } else{ ?>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script> 
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
  $('#column-left').removeClass('active');
});
</script>
<style>
.pageformfields-li i.pull-right{
  margin-top: 2px;
}

.adfieldbutton{
  border-top: 1px solid #ccc;
  margin-top: 20px;
  padding-top: 5px;
}
#tab-fields .control-label {
  text-align: left !important;
  margin-bottom: 4px;
}
.nav > li > a{
  padding: 15px;
}
</style>
</div>
<?php echo $footer; ?>