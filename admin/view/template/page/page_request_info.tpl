<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $back; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-file"></i> <?php echo $text_page_detail; ?></h3>
          </div>
          <table class="table">
            <tbody>
              <tr>
                <td style="width: 1%"><button data-toggle="tooltip" title="<?php echo $text_page_form_title; ?>" class="btn btn-primary"><i class="fa fa-file fa-fw"></i></button></td>
                <td><a href="<?php echo $page_form_href; ?>" target="_blank"><?php echo $page_form_title; ?></a></td>
              </tr>
              <tr>
                <td><button data-toggle="tooltip" title="<?php echo $text_store; ?>" class="btn btn-primary"><i class="fa fa-sitemap fa-fw"></i></button></td>
                <td><a href="<?php echo $store_url; ?>" target="_blank"><?php echo $store_name; ?></a></td>
              </tr>
              <?php if($language_name) { ?>
              <tr>
                <td><button data-toggle="tooltip" title="<?php echo $text_language_name; ?>" class="btn btn-primary"><i class="fa fa-language fa-fw"></i></button></td>
                <td><?php echo $language_name; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><button data-toggle="tooltip" title="<?php echo $text_date_added; ?>" class="btn btn-primary"><i class="fa fa-calendar fa-fw"></i></button></td>
                <td><?php echo $date_added; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-user"></i> <?php echo $text_customer_detail; ?></h3>
          </div>
          <table class="table">
            <tr>
              <td style="width: 1%;"><button data-toggle="tooltip" title="<?php echo $text_customer; ?>" class="btn btn-primary"><i class="fa fa-user fa-fw"></i></button></td>
              <td><?php if ($customer) { ?>
                <a href="<?php echo $customer; ?>" target="_blank"><?php echo $firstname; ?> <?php echo $lastname; ?></a>
                <?php } else { ?>
                <?php echo $firstname; ?> <?php echo $lastname; ?>
                <?php } ?>
              </td>
            </tr>
            <?php if($customer_group) { ?>
            <tr>
              <td><button data-toggle="tooltip" title="<?php echo $text_customer_group; ?>" class="btn btn-primary"><i class="fa fa-group fa-fw"></i></button></td>
              <td><?php echo $customer_group; ?></td>
            </tr>
            <?php } ?>
            <?php if($ip) { ?>
            <tr>
              <td><button data-toggle="tooltip" title="<?php echo $text_ip; ?>" class="btn btn-primary"><i class="fa fa-desktop fa-fw"></i></button></td>
              <td><?php echo $ip; ?></td>
            </tr>
            <?php } ?>
            <?php if($user_agent) { ?>
            <tr>
              <td><button data-toggle="tooltip" title="<?php echo $text_user_agent; ?>" class="btn btn-primary"><i class="fa fa-chrome fa-fw"></i></button></td>
              <td><?php echo $user_agent; ?></td>
            </tr>
            <?php } ?>
          </table>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle"></i> <?php echo $text_fields; ?></h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-responsive">
          <thead>
            <tr>
              <td style="width: 20%;" class="text-left"><?php echo $text_field_name; ?></td>
              <td style="width: 80%;" class="text-left"><?php echo $text_field_value; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach($page_request_options as $page_request_option) { ?>
            <tr>
              <td class="text-left"><label><?php echo $page_request_option['name']; ?></label></td>
              <td class="text-left">
                <?php if ($page_request_option['type'] != 'file') { ?>
                <?php echo $page_request_option['value']; ?>                
                <?php } else { ?>
                <a href="<?php echo $page_request_option['href']; ?>"><?php echo $page_request_option['value']; ?></a>
                <?php } ?>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 
