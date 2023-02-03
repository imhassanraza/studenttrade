<?php
$this->load->view('common/admin_header');
$this->load->view('common/admin_sidebar');

?>

<div class="main-body">
  <div class="page-wrapper">
    <div class="page-header">
      <div class="page-header-title">
        <h4>Payments Released</h4>
      </div>
      <div class="page-header-breadcrumb">
        <p> Total Profit : $<?php echo $totalProfit; ?> </p>
      </div>
    </div>
    <div class="page-body">
      <div class="card">

        <div class="card-block">
          <div class="table-content crm-table">
            <div class="project-table">
              <table id="crm-contact" class="table table-striped dt-responsive nowrap">
                <thead>
                  <tr>
                    <th>Booking REF #</th>
                    <th>Trx ID</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Profit</th>
                    <th>Paid To</th>
                    <th>Type</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($payments as $pay) { ?>
                    <tr>
                      <td>
                        <?php $record = singleRow('bookings', '*', 'id = '.$pay['bookings_id']); ?>
                        <a href="javascript:void(0)" class="view_detail" data-id="<?php echo $record['unique_id']; ?>">
                          <?php echo $pay['bookings_id']; ?>
                        </a>
                      </td>
                      <td><?php echo $pay['trx_id']; ?></td>
                      <td><?php echo "$".$pay['total_amount']; ?></td>
                      <td><?php echo "$".$pay['amount']; ?></td>
                      <td><?php echo "$".$pay['profit']; ?></td>
                      <td>
                        Name: <?php echo $pay['owner_name']; ?>
                        <br>
                        Email: <a href="mailto:<?php echo $pay['owner_email']; ?>"><?php echo $pay['owner_email'] ?></a>
                      </td>
                      <td>
                        <?php if ($pay['payment_type'] == "released") {
                          $text = "Released";
                          $class = "label label-sm label-info";
                        }else if ($pay['payment_type'] == "refund") {
                          $text = "Refunded";
                          $class = "label label-sm label-danger";
                        } ?>
                        <label class="<?php echo $class; ?>"><?php echo $text; ?></label>
                      </td>
                      <td><?php echo formatted_date_time($pay['date_added']); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Booking REF #</th>
                    <th>Trx ID</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Profit</th>
                    <th>Paid To</th>
                    <th>Type</th>
                    <th>Date</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Container-fluid ends -->
    </div>
  </div>
</div>
<!-- large modal -->
<div class="modal fade" id="bookingDetailModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Booking Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="booking_detail">


      </div>

    </div>
  </div>
</div>
<?php $this->load->view('common/admin_footer'); ?>

<script type="text/javascript">
  $(document).on('click', ".view_detail", function(e) {
    var booking_id = $(this).attr('data-id');

    $.ajax({
      url:'<?php echo admin_url(); ?>bookings/booking_detail',
      type:'post',
      dataType: 'json',
      data:{ booking_id : booking_id },
      success:function(res){
        if(res.msg == 'success'){
          $("#booking_detail").html(res.response);
          $("#bookingDetailModal").modal('show');
        }else if (res.msg = 'error'){
         $.gritter.add({
          title: 'Error!',
          sticky: false,
          time: '5000',
          before_open: function(){
            if($('.gritter-item-wrapper').length >= 3)
            {
              return false;
            }
          },
          text: res.response,
          class_name: 'gritter-error'
        });
       }
     }
   });

  });

</script>