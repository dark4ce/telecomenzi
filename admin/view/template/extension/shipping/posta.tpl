<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-posta" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-posta" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="posta_cost">
			<span data-toggle="tooltip" title="" data-original-title="Costul initial (fara TVA) de la care se porneste calculul cand se adauga taxa pe Kg"><?php echo $entry_cost; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="posta_cost" value="<?php echo $posta_cost; ?>" placeholder="<?php echo $entry_cost; ?>" id="posta_cost" class="form-control" />
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="posta_valoare">
			<span data-toggle="tooltip" title="" data-original-title="Valoarea declarata si asigurata pentru colete. Minimul impus de Posta Romana pentru colete cu ramburs este 20 de Lei. Daca doriti sa declarati aici automat valoarea comenzii contactati-ne si putem efectua modificarea contra cost."><?php echo $entry_insurance; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="posta_valoare" value="<?php echo $posta_valoare; ?>" placeholder="<?php echo $posta_valoare; ?>" id="posta_valoare" class="form-control" />
            </div>
          </div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="posta_kg">
			<span data-toggle="tooltip" title="" data-original-title="Pretul care se adauga pentru fiecare Kg."><?php echo $entry_weight; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="posta_kg" value="<?php echo $posta_kg; ?>" placeholder="<?php echo $posta_kg; ?>" id="posta_kg" class="form-control" />
            </div>
          </div>
		  	<div class="form-group required">
            <label class="col-sm-2 control-label" for="entry_mandat">
			<span data-toggle="tooltip" title="" data-original-title="Aceste date apar automat in formulare dupa completare. Pentru functionarea modulului este necesara completarea acestor date."><?php echo $entry_mandat; ?></span></label>
            <div class="col-sm-10">
			<input type="text" name="posta_exp_name" value="<?php echo $posta_exp_name; ?>" placeholder="<?php echo $entry_expeditor; ?>" id="posta_exp_name" class="form-control" />
			<input type="text" name="posta_exp_cui" value="<?php echo $posta_exp_cui; ?>" placeholder="<?php echo $entry_cui; ?>" id="posta_exp_cui" class="form-control" />
			<input type="text" name="posta_exp_jud" value="<?php echo $posta_exp_jud; ?>" placeholder="<?php echo $entry_jud; ?>" id="posta_exp_jud" class="form-control" />
			<input type="text" name="posta_exp_oras" value="<?php echo $posta_exp_oras; ?>" placeholder="<?php echo $entry_oras; ?>" id="posta_exp_oras" class="form-control" />
			<input type="text" name="posta_exp_code" value="<?php echo $posta_exp_code; ?>" placeholder="<?php echo $entry_code; ?>" id="posta_exp_code" class="form-control" />
			<input type="text" name="posta_exp_adr" value="<?php echo $posta_exp_adr; ?>" placeholder="<?php echo $entry_adr; ?>" id="posta_exp_adr" class="form-control" />
			<input type="text" name="posta_exp_banca" value="<?php echo $posta_exp_banca; ?>" placeholder="<?php echo $entry_banca; ?>" id="posta_exp_banca" class="form-control" />
			<input type="text" name="posta_exp_sucursala" value="<?php echo $posta_exp_sucursala; ?>" placeholder="<?php echo $entry_sucursala; ?>" id="posta_exp_sucursala" class="form-control" />
			<input type="text" name="posta_exp_iban" value="<?php echo $posta_exp_iban; ?>" placeholder="<?php echo $entry_iban; ?>" id="posta_exp_iban" class="form-control" />
			    </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="posta_tax_class_id"><?php echo $entry_tax_class; ?></label>
            <div class="col-sm-10">
              <select name="posta_tax_class_id" id="posta_tax_class_id" class="form-control">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($tax_classes as $tax_class) { ?>
                <?php if ($tax_class['tax_class_id'] == $posta_tax_class_id) { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="posta_geo_zone_id"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="posta_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $posta_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="posta_status" id="input-status" class="form-control">
                <?php if ($posta_status) { ?>
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
            <label class="col-sm-2 control-label" for="posta_sort_order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="posta_sort_order" value="<?php echo $posta_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="posta_sort_order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 