<?php $this->load->view('common/header'); ?>

<section class="become-space section-bg">
    <div class="container">
      <div class="row">

        <div class="col-md-6 col-md-offset-3 login-popup sign-pop">

          <h2><?php echo lang('forgot_password'); ?></h2>
          <span class="remb">
            <?php echo lang('enter_your_email'); ?>
        </span>
        <form id="retrieve_password_form_page" action="" method="post" class="padd-top" novalidate>

            <div class="input-group" style="width:100%;">
                <span>
                    <i class="fa fa-envelope mail-icon"></i>
                </span>
                <input type="email" class="form-control" name="email" placeholder="<?php echo lang('email_address'); ?>">
            </div>
            <div class="text-center">
                <p class="pull-left back-login"><a href="<?php echo base_url(); ?>login"><i class="fa fa-angle-left"></i> <?php echo lang('back_to_login'); ?> </a> </p>
                <button type="submit" id="btn_retrieve_password" class="btn next-btn pull-right"><?php echo lang('send_reset_link'); ?></button>
            </div>
        </form>

    </div>


</div>

</div>
</section>

<?php $this->load->view('common/footer'); ?>
<script type="text/javascript">
    $('#retrieve_password_form_page').on('submit', function(event) {
        event.preventDefault();
        // var btn = $(this);
        $("#btn_retrieve_password").button('loading');
        var value = $("#retrieve_password_form_page").serialize();
        $.ajax({
            url:'<?php echo base_url(); ?>forgot_password/retrieve_password',
            type:'post',
            data:value,
            dataType:'json',
            success:function(status){
                $("#btn_retrieve_password").button('reset');
                if(status.msg=='success'){
                    $.gritter.add({
                        title: '<?php echo lang('success_msg'); ?>',
                        sticky: false,
                        time: '5000',
                        before_open: function(){
                            if($('.gritter-item-wrapper').length >= 3)
                            {
                                return false;
                            }
                        },
                        text: status.response,
                        class_name: 'gritter-success'
                    });
                    $("#retrieve_password_form_page")[0].reset();
                }
                else if(status.msg == 'error'){
                    $.gritter.add({
                        title: '<?php echo lang('error'); ?>',
                        sticky: false,
                        time: '5000',
                        before_open: function(){
                            if($('.gritter-item-wrapper').length >= 3)
                            {
                                return false;
                            }
                        },
                        text: status.response,
                        class_name: 'gritter-error'
                    });
                }
            }
        });

    });
</script>