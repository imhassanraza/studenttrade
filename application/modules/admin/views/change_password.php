<?php
$this->load->view('common/admin_header');
$this->load->view('common/admin_sidebar');

?>

<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Change password</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?php echo admin_url(); ?>dashboard">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>dashboard">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>change_password">Change password</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Change password</h5>
                            <span>Use the form below to change your password.</span>
                        </div>
                        <div class="card-block col-md-6 offset-md-3">
                            <form id="change_password_form" method="post" action="" novalidate>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Old Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="old_password" class="form-control" placeholder="Enter your old password" name="old_password" required>
                                        <span class="messages"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">New Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="new_password" placeholder="Enter new password" name="new_password" required>
                                        <span class="messages"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Confirm Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="c_password" placeholder="Confirm password" name="c_password" required>
                                        <span class="messages"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2"></label>
                                    <div class="col-sm-12">
                                        <button type="button" id="submit" class="btn btn-primary m-b-0">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('common/admin_footer'); ?>
<script src="<?php echo base_url(); ?>admin_assets/js/jquery.validate.min.js"
    type="text/javascript"></script>

    <script type="text/javascript">
        $('#change_password_form').validate({
            errorElement: 'div',
            errorClass: 'text-danger',
            focusInvalid: true,
            ignore: "",
            rules: {
                old_password: {
                    required: true,
                },
                new_password: {
                    required: true,
                },
                c_password: {
                    required: true,
                    equalTo:"#new_password"
                },
            },

            messages: {
                old_password: "Please Enter Old Password.",
                new_password: "Please Enter New Password",
                c_password:{
                    required : "Please Enter Confirm Password.",
                    equalTo : "Confirm Password does not match.",
                },
                highlight: function (e) {
                    $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
                },
                success: function (e) {
                    $(e).closest('.form-group').removeClass('has-error');
                    /*.addClass('has-info');*/
                    $(e).remove();
                },

                errorPlacement: function (error, element) {
                    if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                        var controls = element.closest('div[class*="col-"]');
                        if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
                        else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                    }
                    else if(element.is('.select2')) {
                        error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                    }
                    else if(element.is('.chosen-select')) {
                        error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                    }
                    else error.insertAfter(element.parent());
                },
                submitHandler: function (form) {
                },
                invalidHandler: function (form) {
                }
            }
        });

        $('#submit').click(function(e){
            if($("#change_password_form").valid()){
                var btn = $(this);
                $(btn).button('loading');
                var value = $("#change_password_form").serialize();
                $.ajax({
                    url:'<?php echo admin_url(); ?>update_password',
                    type:'post',
                    data:value,
                    dataType:'json',
                    success:function(status){
                        if(status.msg=='success'){
                            notify('Success! ', status.response, 'success');
                            $(btn).button('reset');
                        }
                        else if(status.msg == 'error'){
                            notify('Error! ', status.response, 'danger');
                            $(btn).button('reset');
                        }
                    }
                });
            }
        });

    </script>