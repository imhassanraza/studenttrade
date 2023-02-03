<?php $this->load->view('common/header'); ?>
<section class="become-space section-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 login-popup sign-pop">
                <h2><?php echo lang('registration');?></h2>
                <form id="registration_form_page" action="" method="post">
                    <div class="input-group" style="width:100%;">
                        <span><i class="fa fa-envelope lock-icon"></i></span>
                        <input type="email" class="form-control" id="register_email"  name="email" placeholder="<?php echo lang('email_address'); ?>" required>
                    </div>
                    <div class="input-group" style="width:100%;">
                        <span><i class="fa fa-phone lock-icon"></i></span>
                        <input type="text" class="form-control" id="phone_no"  name="phone_no" placeholder="<?php echo lang('phone_no'); ?>" required>
                    </div>
                    <div class="input-group" style="width:100%;">
                        <span><i class="fa fa-lock lock-icon"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo lang('password'); ?>" required>
                    </div>
                    <div class="input-group" style="width:100%;">
                        <span><i class="fa fa-lock lock-icon"></i></span>
                        <input type="password" name="c_password" class="form-control" placeholder="<?php echo lang('confirm_password'); ?>" required>
                    </div>
                    <div class="forgot-outer">
                        <div class="form-check pull-left confirm-agreement" >
                            <label>
                                <input type="checkbox" name="check_policy" id="check_policy"> <span class="label-text" > </span><span class="remb"><?php echo lang('i_accept_the'); ?> <a href="<?php echo base_url(); ?>terms_and_conditions" target="_blank"> <?php echo lang('terms_of_use'); ?> </a> <?php echo lang('and'); ?> <a href="<?php echo base_url(); ?>privacy_policy" target="_blank"> <?php echo lang('privacy_policy1'); ?> </a></span>
                                <p id="confirm_error" class="text-danger"></p>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" data-loading-text="<?php echo lang('please_wait'); ?>" id="registration_button" class="signup-btn btn"><?php echo lang('sign_up'); ?></button>
                    </div>
                    <div class="text-center">
                        <p class="pull-left"><?php echo lang('already_have_an_account'); ?></p>
                        <a href="<?php echo base_url(); ?>login" class="btn sign-btn pull-right"><?php echo lang('log_in'); ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('common/footer'); ?>

<script type="text/javascript">
    $('#registration_form_page').on('submit', function(event) {
        event.preventDefault();
        if($("#registration_form_page").valid()){
            var confirm_1 = $('#check_policy').prop("checked");
            if(confirm_1 == false){
                $('.remb').css('color' , 'red');
                return false;
            }else{
                $('.remb').css('color' , '');
            }

            $("#registration_button").button('loading');
            var value = $("#registration_form_page").serialize();
            $.ajax({
                url:'<?php echo base_url(); ?>register/submit_user',
                type:'post',
                data:value,
                dataType:'json',
                success:function(status){
                    $("#registration_button").button('reset');
                    if(status.msg=='success'){
                        $.gritter.add({
                            title: '<?php echo lang('success_msg'); ?>',
                            sticky: false,
                            time: '3000',
                            before_open: function(){
                                if($('.gritter-item-wrapper').length >= 3)
                                {
                                    return false;
                                }
                            },
                            text: "<?php echo lang('successfully_signup'); ?>",
                            class_name: 'gritter-success'
                        });
                        $("#registration_form_page")[0].reset();
                        setTimeout( function() { location.reload(); } , 2000);
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
        }
    });
</script>