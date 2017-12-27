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

      <h2>setari</h2>
      <!-- COMPANIES -->
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-meta-title">Compania implicita</label>
        <div class="col-sm-10">
          <select name="smartbill_company" class="form-control">
            <?php echo $thisSettings->_renderSelect($settings->companies, 'vatCode', 'name', $company->vatCode); ?>
          </select>
          <small>Daca ai mai multe firme pe cont, vei emite pe cea selectata</small>
          <div class="alert alert-danger error" style="display: none;">
            <i class="fa fa-exclamation-circle"></i> Salvati configuratia pentru a incarca datele companiei alese si apoi efectuati setarile pentru emiterea corecta a documentelor in Smart Bill
          </div>
        </div>
      </div>      

      <!-- TAXES -->
      <h3>Setari TVA</h3>
      <?php if ( !empty($company->isTaxPayer) ): ?>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-meta-title">Preturile includ TVA?</label>
        <div class="col-sm-10">
          <select name="smartbill_price_include_vat" class="form-control">
            <?php echo $thisSettings->_renderSelect($thisSettings->yesNoOptions(), 'id', 'name', $SMARTBILL_PRICE_INCLUDE_VAT); ?>
          </select>
          <small>Daca vrei ca preturile sa fie transmise din PrestaShop catre Smart Bill cu TVA inclus</small>
        </div>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-meta-title">Cota TVA produse</label>
        <div class="col-sm-10">
          <select name="smartbill_products_vat" class="form-control">
            <?php echo $thisSettings->_renderSelect($company->defaultVatCode, 'id', 'name', $SMARTBILL_PRODUCTS_VAT); ?>
          </select>
          <small>Ce cota TVA se va aplica produselor pe documentul emis in Smart Bill</small>
        </div>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-meta-title">Cota TVA transport</label>
        <div class="col-sm-10">
          <select name="smartbill_transport_vat" class="form-control">
            <?php echo $thisSettings->_renderSelect($company->taxes, 'id', 'name', $SMARTBILL_TRANSPORT_VAT); ?>
          </select>
        </div>
      </div>
      <?php else: ?>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-meta-title">Neplatitor TVA</label>
        <div class="col-sm-10"></div>
      </div>
      <?php endif; ?>

      <!-- COMPANY SETTINGS -->
      <h3>Setari emitere documente</h3>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-meta-title">Tipul de document emis<br>in Smart Bill</label>
        <div class="col-sm-10">
          <select name="smartbill_document_type" class="form-control">
            <?php echo $thisSettings->_renderSelect($thisSettings->documentTypeOptions(), 'id', 'name', $SMARTBILL_DOCUMENT_TYPE); ?>
          </select>
        </div>
      </div>
      <div class="form-group required series-invoice">
        <label class="col-sm-2 control-label" for="input-meta-title">Serie implicita factura</label>
        <div class="col-sm-10">
          <select name="smartbill_invoice_series" class="form-control">
            <?php echo $thisSettings->_renderSelect($company->invoiceSeries, 'id', 'name', $SMARTBILL_INVOICE_SERIES); ?>
          </select>
        </div>
      </div>
      <div class="form-group required series-proforma">
        <label class="col-sm-2 control-label" for="input-meta-title">Serie implicita proforma</label>
        <div class="col-sm-10">
          <select name="smartbill_proforma_series" class="form-control">
            <?php echo $thisSettings->_renderSelect($company->estimateSeries, 'id', 'name', $SMARTBILL_PROFORMA_SERIES); ?>
          </select>
        </div>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-meta-title">Tipul de cod folosit in OpenCart</label>
        <div class="col-sm-10">
          <select name="smartbill_product_sku_type" class="form-control">
            <?php echo $thisSettings->_renderSelect($thisSettings->productSKUTypes(), 'id', 'name', $SMARTBILL_PRODUCT_SKU_TYPE); ?>
          </select>
          <small>Alege codurile pe care le folosesti in OpenCart si care sunt echivalente cu codurile din Smart Bill</small>
        </div>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-meta-title">Unitatea de masura implicita</label>
        <div class="col-sm-10">
          <select name="smartbill_order_unit_type" class="form-control">
            <?php echo $thisSettings->_renderSelect($company->measureUnits, 'id', 'name', $SMARTBILL_ORDER_UNIT_TYPE); ?>
          </select>
          <small>Ce unitate de masura se va aplica produselor pe documentul emis in Smart Bill</small>
        </div>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-meta-title">Preturile produselor<br>din OpenCart sunt in</label>
        <div class="col-sm-10">
          <select name="smartbill_document_currency" class="form-control">
            <?php echo $thisSettings->_renderSelect($company->currencies, 'symbol', 'name', $SMARTBILL_DOCUMENT_CURRENCY); ?>
          </select>
          <small>Moneda aceasta se va prelua pe documentul emis in Smart Bill</small>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-meta-title">Moneda documentului emis<br>in Smart Bill</label>
        <div class="col-sm-10">
          <select name="smartbill_document_currency_doc" class="form-control">
            <?php echo $thisSettings->_renderSelect($thisSettings->docCurrencyOptions(), 'id', 'name', $SMARTBILL_DOCUMENT_CURRENCY_DOC); ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-meta-title">Include transportul in factura?</label>
        <div class="col-sm-10">
          <select name="smartbill_order_include_transport" class="form-control">
            <?php echo $thisSettings->_renderSelect($thisSettings->yesNoOptions(), 'id', 'name', $SMARTBILL_ORDER_INCLUDE_TRANSPORT); ?>
          </select>
          <small>Daca vrei ca preturile sa fie transmise din OpenCart catre Smart Bill cu TVA inclus</small>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-meta-title">Salveaza clientul in Smart Bill</label>
        <div class="col-sm-10">
          <select name="smartbill_company_save_client" class="form-control">
            <?php echo $thisSettings->_renderSelect($thisSettings->yesNoOptions(), 'id', 'name', $SMARTBILL_COMPANY_SAVE_CLIENT); ?>
          </select>
          <small>Salvand clientul in Smart Bill, vei avea datele lui disponibile pentru emiteri ulterioare</small>
        </div>
      </div>
      <?php if ( !empty($company->isStockEnabled) ): ?>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-meta-title">Gestiune</label>
        <div class="col-sm-10">
          <select name="smartbill_warehouse" class="form-control">
            <?php echo $thisSettings->_renderSelect($company->warehouses, 'id', 'name', $SMARTBILL_WAREHOUSE); ?>
          </select>
        </div>
      </div>
      <?php endif; ?>
    </form>
  </div>
</div>
<script type="text/javascript" src="view/javascript/smartbill.js?1"></script>

<?php echo $footer; ?>