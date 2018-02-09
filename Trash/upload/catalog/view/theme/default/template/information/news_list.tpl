<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
   <?php echo $content_top; ?>
    
   <div class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
         <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
      <?php } ?>
   </div>
    
   <h1><?php echo $heading_title; ?></h1>
   <center>
      <table style="width:80%; border-collapse: collapse; border-left: 1px solid #eeeeee; border-right: 1px solid #eeeeee;">
         <tr style="font-weight:bold;">
            <td style="width:30%; padding:10px 0px 10px 10px; background:#eeeeee; text-align:left;"><?php echo $text_title; ?></td>
            <td style="width:50%; padding:10px 0px 10px 10px; background:#eeeeee; text-align:left;"><?php echo $text_description; ?></td>
            <td style="width:10%; padding:10px 10px 10px 10px; background:#eeeeee; text-align:right;"></td>
         </tr>
         <?php foreach ($all_news as $news) { ?>
            <tr>
               <td style="padding:10px 0px 10px 10px; text-align:left; border-bottom: 1px solid #eeeeee;"><?php echo $news['title']; ?></td>
               <td style="padding:10px 0px 10px 10px; text-align:left; border-bottom: 1px solid #eeeeee; border-left: 1px solid #eeeeee;"><?php echo $news['description']; ?></td>
               <td style="padding:10px 10px 10px 10px; text-align:right; border-bottom: 1px solid #eeeeee; border-left: 1px solid #eeeeee;"><a href="<?php echo $news['view']; ?>"><?php echo $text_view; ?></a></td>
            </tr>
         <?php } ?>
      </table>
   </center>
    
   <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>