<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-users"></i> <?php echo $heading_title; ?></h3>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
           <td><?php echo 'Select' ?></td>
          <td class="text-left"><?php echo $column_customer_id; ?></td>
          <td><?php echo $column_customer_name; ?></td>
          <td><?php echo $column_customer_email; ?></td>
          <td><?php echo $column_date_added; ?></td>
        </tr>
      </thead>
      <tbody>
        <?php if ($recentcustomers) { ?>
            <?php foreach ($recentcustomers as $customer) { ?>
                <tr>
                  <td><input type="checkbox" name="checkbox[]" value="" id="checkbox"></td>
                  <td class="text-left"><?php echo $customer['customer_id']; ?></td>
                  <td><?php echo $customer['name']; ?></td>
                  <td><?php echo $customer['email']; ?></td>
                  <td><?php echo $customer['date_added']; ?></td> 
                </tr>
            <?php } ?>
        <?php } else { ?>
        <tr>
          <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>