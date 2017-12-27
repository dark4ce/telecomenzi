<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <!-- <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul> -->
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
      <input type="hidden" name="submitSmartBill" value="1" >
      <h2>autentificare</h2>
      <!-- LOGIN -->
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-meta-title">Nume utilizator / adresa email</label>
        <div class="col-sm-10">
          <input type="text" name="smartbill_user" value="<?php echo !empty($SMARTBILL_USER) ? $SMARTBILL_USER : ''; ?>" class="form-control" >
        </div>
      </div>      
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-meta-title">Parola</label>
        <div class="col-sm-10">
          <input type="password" name="smartbill_pass" class="form-control" >
        </div>
      </div>      
    </form>
  </div>
</div>

<?php echo $footer; ?>