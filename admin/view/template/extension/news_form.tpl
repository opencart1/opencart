<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error) { ?>
  <div class="warning"><?php echo $error; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/feed.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_submit; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
     <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="language" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#tab-language-<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
        </div>
        <?php foreach ($languages as $language) { ?>
          <div id="tab-language-<?php echo $language['language_id']; ?>">
            <table class="form">
                <tr>
                    <td class="left"><?php echo $text_title; ?></td>
                    <td><input type="text" name="news[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($news[$language['language_id']]) ? $news[$language['language_id']]['title'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td><?php echo $text_description; ?></td>
                    <td><textarea name="news[<?php echo $language['language_id']; ?>][description]" id="description-<?php echo $language['language_id']; ?>"><?php echo isset($news[$language['language_id']]) ? $news[$language['language_id']]['description'] : ''; ?></textarea></td>
                </tr>
            </table>
          </div>
        <?php } ?>
            <table class="form">
                <tr>
                    <td><?php echo $text_keyword; ?></td>
                    <td><input type="text" value="<?php echo $keyword; ?>" name="keyword" /></td>
                </tr>
                <tr>
                    <td><?php echo $text_status; ?></td>
                    <td><select name="status">
                        <option <?php if ($status == '1') { ?>selected="selected" <?php } ?>value="1"><?php echo $text_enabled; ?></option>
                        <option <?php if ($status == '0') { ?>selected="selected" <?php } ?>value="0"><?php echo $text_disabled; ?></option>
                    </select></td>
                </tr>
            </table>
     </form>
    </div>
  </div>
</div>
 
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description-<?php echo $language['language_id']; ?>', {
    filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script>
<script type="text/javascript"><!--
$('#language a').tabs();
//--></script>
<?php echo $footer; ?>