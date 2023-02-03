<?php $this->load->view('common/header'); ?>
<div class="s-trapeze  login-block">
    <div class="s-trapeze-img" data-interchange=""></div>
    <section class="section s-line-secondary">
        <div class="row">
            <div class="column small-12 medium-12 large-7" style="background: #eeeeee;padding-top: 23px;">
                <header class="s-header">
                    <h2 class="s-headline">Forgot Password<span class="s-headline-decor"></span></h2>
                </header>
            </div>
            <div class="column small-12 medium-12 large-7 large-order-1 services-buttons-column" style="background: #eeeeee;">
                <aside class="sidebar card block-shadow" style="margin-bottom: 0px;">
                    <div class="card-section">
                        <p><?php echo lang('login_email_required'); ?>.</p>
                        <form class="text-center" data-abide="" id="retrieve_password_form" novalidate="" data-e="sm5453-e">
                            <label>
                                <span class="input-group">
                                    <span class="input-group-label zmdi zmdi-email"></span>
                                    <input class="input-group-field" name="email" placeholder="<?php echo lang('email_address'); ?>" required="" type="email">
                                </span>
                            </label>
                            <button class="button expanded" data-loading-text="<?php echo lang('please_wait'); ?>" id="retrieve_password" type="submit"><i class="zmdi zmdi-mail-send"></i>
                                <span><?php echo lang('retrieve_password'); ?></span>
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view('common/footer'); ?>
<script type="text/javascript">
    $('#retrieve_password').click(function(){
        var value = $("#retrieve_password_form").serialize();
        $.ajax({
            url:'<?php echo base_url(); ?>forgot_password/retrieve_password',
            type:'post',
            data:value,
            dataType:'json',
            success:function(status){
                console.log(status);
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
                    setTimeout(function() { window.location = '<?php echo base_url();?>login'; },2000);
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