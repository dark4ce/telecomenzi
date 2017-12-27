<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-banner" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-banner" class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-password"><?php echo $glsform_default_settings; ?> </label>
                        <div class="col-sm-10">
                            <ul class="list-unstyled">
                                <li>
                                    <div class="checkbox">
                                        <label>
                                            <input name="gls_express_parcel" <?php echo $gls_express_parcel == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                                            Express Parcel
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label>
                                            <input name="gls_flex_delivery" <?php echo $gls_flex_delivery == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                                            Flex Delivery Service
                                        </label>
                                    </div>
                                </li>

                                <li>
                                    <div class="checkbox">
                                        <label>
                                            <input name="gls_pick_ship" <?php echo $gls_pick_ship == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                                            Pick & Ship Service
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label>
                                            <input name="gls_pick_return" <?php echo $gls_pick_return == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                                            Pick & Return Service
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label>
                                            <input name="gls_sms" <?php echo $gls_sms == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                                            SMS Service
                                        </label>
                                    </div>
                                    <div id="expand_sms">
                                        <textarea name="gls_sms_msg" id="" cols="10" rows="3" class="form-control"><?php echo strlen($gls_sms_msg) > 0 ? $gls_sms_msg : $glsform_sms_msg; ?></textarea>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label>
                                            <input name="gls_preadvice" <?php echo $gls_preadvice == 1 ? 'checked' : '' ?> type="checkbox" value="1">
                                            Preadvice Service
                                        </label>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>