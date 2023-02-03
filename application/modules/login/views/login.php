<?php $this->load->view('common/header'); ?>
<section class="become-space section-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 login-popup sign-pop">
                <h2><?php echo lang('login'); ?></h2>
                <div id="verification_error" class="alert alert-danger clearfix" style="display: none;">

                </div>

                <div id="verification_success" class="alert alert-success clearfix" style="display: none;">

                </div>
                <form id="login_form_page" action="" method="post">
                    <div class="input-group" style="width:100%;">
                        <span><i class="fa fa-envelope mail-icon"></i></span>
                        <input class="form-control" name="login_email" placeholder="<?php echo lang('email_address'); ?>" required="" type="email">
                    </div>
                    <div class="input-group" style="width:100%;">
                        <span><i class="fa fa-lock lock-icon"></i></span>
                        <input class="form-control" name="login_password" placeholder="<?php echo lang('password'); ?>" required="" type="password">
                    </div>
                    <div class="forgot-outer">
                        <div class="form-check" style="margin-left: -17px;">
                            <label>
                                <input name="check" type="checkbox"> <span class="label-text"> </span><span class="remb"><?php echo lang('remember_me'); ?></span>
                            </label>
                        </div>
                        <div class="">
                            <span class="label-text forgot"><a href="<?php echo base_url(); ?>forgot_password"><?php echo lang('forgot_password'); ?></a> </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="login_button" data-loading-text="<?php echo lang('please_wait'); ?>" class="login-btn btn"><?php echo lang('login'); ?></button>
                    </div>
                    <div class="text-center">
                        <p class="pull-left"><?php echo lang('dont_have_an_account'); ?></p>
                        <a href="<?php echo base_url(); ?>register" class="btn sign-btn pull-right"><?php echo lang('sign_up'); ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('common/footer'); ?>
<script type="text/javascript">

    $('#login_form_page').on('submit', function(event) {
        event.preventDefault();

        if($("#login_form_page").valid()){

            var btn = $(this);
            $("#login_button").button('loading');
            var value = $("#login_form_page").serialize();
            $.ajax({
                url:'<?php echo base_url(); ?>login/login_verify',
                type:'post',
                data:value,
                dataType:'json',
                success:function(status){
                    $("#login_button").button('reset');
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
                            text: "<?php echo lang('successfully_loggedin'); ?>",
                            class_name: 'gritter-success'
                        });
                        location.reload();
                    } else if(status.msg == 'error'){

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

                    } else if(status.msg == 'error_verification') {
                        $("#verification_success").hide();
                        $("#verification_error").html(status.response).show();
                        resendfun();
                    }
                }
            });
        }
    });

</script>