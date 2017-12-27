<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-euplatesc" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" id="form-euplatesc" class="form-horizontal">
          
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="euplatesc_name" value="<?php echo $euplatesc_name; ?>" id="input-name" class="form-control" />
            </div>
		  </div>
		  
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-account"><?php echo $entry_account; ?></label>
            <div class="col-sm-10">
              <input type="text" name="euplatesc_account" value="<?php echo $euplatesc_account; ?>" id="input-account" class="form-control" />
            </div>
		  </div>
		  
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-secret"><?php echo $entry_secret; ?></label>
            <div class="col-sm-10">
              <input type="text" name="euplatesc_secret" value="<?php echo $euplatesc_secret; ?>" id="input-secret" class="form-control" />
            </div>
		  </div>
		  
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
            <div class="col-sm-10">
              <select name="euplatesc_order_status_id" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $euplatesc_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
		  
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status-s"><?php echo $entry_order_status_s; ?></label>
            <div class="col-sm-10">
              <select name="euplatesc_order_status_id_s" id="input-order-status-s" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $euplatesc_order_status_id_s) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status-f"><?php echo $entry_order_status_f; ?></label>
            <div class="col-sm-10">
              <select name="euplatesc_order_status_id_f" id="input-order-status-f" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $euplatesc_order_status_id_f) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="euplatesc_status" id="input-status" class="form-control">
                <?php if ($euplatesc_status) { ?>
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
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="euplatesc_sort_order" value="<?php echo $euplatesc_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
		  
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-secstatus">SecStatus</label>
            <div class="col-sm-10">
              <select name="euplatesc_secstatus" id="input-secstatus" class="form-control">
                <?php if ($euplatesc_secstatus) { ?>
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
            <label class="col-sm-2 control-label" for="input-ratestatus"><?php echo $entry_ratestate; ?></label>
            <div class="col-sm-10">
              <select name="euplatesc_ratestatus" id="input-ratestatus" class="form-control" onchange="euplatesc_change(this);">
                <?php if ($euplatesc_ratestatus) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  
		  <div id="rate_container" style="display:<?php echo $euplatesc_ratestatus?"block":"none";?>;">
		  
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-rate"><?php echo $entry_rate; ?></label>
				<div class="col-sm-10">
					<?php foreach($rate_ep as $code=>$name){ ?>
						<input type="checkbox" value="1" <?php echo $euplatesc_rateactive[$code]?"checked":""; ?> name="euplatesc_rateactive_<?php echo $code;?>" id="input-rate"/> <?php echo $name;?><br>
					<?php }?>
				</div>
			</div>
			
			<?php foreach($rate_ep as $code=>$name){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-rate-<?php echo $code;?>"><?php echo $entry_nrrate.$name; ?>:</label>
					<div class="col-sm-10">
						<input type="text" name="euplatesc_rate_<?php echo $code;?>" value="<?php echo $euplatesc_ratenr[$code]; ?>" id="input-rate-<?php echo $code;?>" class="form-control" />
						<span>Ex: 2,4,6,12</span>
					</div>
				</div>
			<?php }?>
			
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-display"><?php echo $entry_rateorder; ?></label>
            <div class="col-sm-10">
              <input type="text" name="euplatesc_rateorder" value="<?php echo $euplatesc_rateorder; ?>" id="input-display" class="form-control" />
			  <span>Ex: 1,3,2,5,4,6</span>
            </div>
		  </div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-ratedisplay"><?php echo $entry_ratedisplay; ?></label>
				<div class="col-sm-10">
				  <select name="euplatesc_ratedisplay" id="input-ratedisplay" class="form-control">
					<?php if ($euplatesc_ratedisplay) { ?>
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
		  
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 

<script>
	function euplatesc_change(obj){
		if(obj.value==1){
			document.getElementById("rate_container").style.display="block";
		}else{
			document.getElementById("rate_container").style.display="none";
		}
	}
</script>