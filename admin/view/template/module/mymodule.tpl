<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">

  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>

  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-html" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
  
	<div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>

      <div class="panel-body">
        
		<form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" id="form-html" class="form-horizontal">
          
		  <div class="form-group">            
			<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_title; ?></label>
            <div class="col-sm-10">
              <input type="text" name="mymodule_title" value="<?php echo $mymodule_title; ?>" placeholder="<?php echo $entry_title; ?>" id="input-name" class="form-control" />
			</div>
          </div>

		  <div class="form-group">
			<label class="col-sm-2 control-label" for="input-html"><?php echo $entry_text; ?></label>
			<div class="col-sm-10">
              <textarea name="mymodule_text" placeholder="<?php echo $entry_text; ?>" id="input-description" class="form-control"><?php echo $mymodule_text; ?></textarea>
            </div>
		  </div>

          <div class="form-group">  
			<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="mymodule_status" id="input-status" class="form-control">
                <?php if ($mymodule_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
   			</div>
		  </div>

		</form>

	  </div>
	</div>
    
  </div>
</div>
<?php echo $footer; ?>