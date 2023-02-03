<?php
$this->load->view('common/admin_header');
$this->load->view('common/admin_sidebar');

?>

<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Users</h4>
            </div>
            <div class="page-header-breadcrumb">
                <a href="<?php echo admin_url(); ?>users/add_user" class="btn btn-primary">Add User</a>

                <a href="<?php echo admin_url(); ?>users/inactive_users" class="btn btn-info">Inactive Users</a>

                <a href="<?php echo admin_url(); ?>users/deleted_users" class="btn btn-danger">Deleted Users</a>
                <a href="<?php echo admin_url(); ?>users/get_users_email_addresses" class="btn btn-inverse btn_inverse_white"><i class="fa fa-download"></i> Export Users</a>
            </div>
        </div>

        <div class="page-body">
            <div class="card">

                <div class="card-block">
                    <div class="table-contentt crmm-table">
                        <div class="project-tablee">
                            <table id="users_tabls" class="table table-striped dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Email Address</th>
                                        <th>Transfer Payment</th>
                                        <th>Paypal Email</th>
                                        <th>IBAN (Bank) Number</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i= 1; foreach ($users as $user) { ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo admin_url(); ?>users/edit_user/<?php echo $user['id']; ?>" title="Edit">
                                                    <?php if(!empty($user['first_name'])) { ?>
                                                        <?php echo $user['first_name']." ".$user['last_name']; ?>
                                                    <?php } else { ?>
                                                        (NA) Update?
                                                    <?php } ?>
                                                </a>
                                            </td>
                                            <td> <?php echo $user['gender']; ?> </td>
                                            <td> <?php echo $user['email']; ?> </td>

                                            <td>
                                                <?php if ($user['amount_tranfer'] == 0) { ?>
                                                    <label class="label label-success">PayPal</label>
                                                <?php }else{ ?>
                                                    <label class="label label-success">Bank Account</label>
                                                <?php } ?>
                                            </td>

                                            <td> <?php echo $user['paypal_email']; ?> </td>
                                            <td> <?php echo $user['iban_number']; ?> </td>
                                            <td> <?php echo $user['phone']; ?> </td>
                                            <td>
                                                <?php echo wordwrap($user['address1']." ".$user['address2']." ".$user['city']." ".$user['state']." ".$user['zip'], 30, "<br>\n"); ?>
                                            </td>

                                            <td>
                                                <label class="label <?php if($user['status']) {?> label-success <?php } else { ?> label-danger <?php } ?>">
                                                    <?php if($user['status']) {?> Active <?php } else { ?> Inactive <?php } ?>
                                                </label>
                                            </td>
                                            <td>
                                                <?php if($user['status']) {?>
                                                    <label class="btn btn-danger btn-sm inactive_status" data-id="<?php echo $user['id']; ?>"> Inactive </label>
                                                <?php } else { ?>
                                                    <label class="btn btn-success btn-sm active_status" data-id="<?php echo $user['id']; ?>"> Active </label>
                                                <?php } ?>

                                                <?php if($user['is_banned']){ ?>
                                                    <label class="btn btn-info btn-sm banned" data-id="<?php echo $user['id']; ?>" data-banned="remove_banned"  title="Remove banned">
                                                        Remove ban
                                                    </label>
                                                <?php } else { ?>
                                                    <label class="btn btn-warning btn-sm banned" data-id="<?php echo $user['id']; ?>" data-banned="add_banned" title="Add to banned">Ban user</label>
                                                <?php } ?>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid ends -->
        </div>
    </div>
</div>

<?php $this->load->view('common/admin_footer'); ?>

<script type="text/javascript">
    $(document).ready( function () {
        $('#users_tabls').DataTable( {
            "lengthMenu": [[10, 25, 50 , 100, -1], [10, 25, 50, 100, "All"]]
        });
    });

    $('body').on('click', '.inactive_status', function (event) {

        var u_id = $(this).attr('data-id');
        swal({
            title: "Are you sure?",
            text: "You want to inactive this user!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, inactive it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {

                $.ajax({
                    url:'<?php echo admin_url(); ?>users/inactive_status',
                    type:'post',
                    dataType: 'json',
                    data:{ user_id : u_id },
                    success:function(res){
                        if(res.msg == 'success'){
                            swal({title: "Inactive!", text: res.response, type: "success"},
                                function(){
                                    location.reload();
                                });
                        }else if (res.msg = 'error'){
                            swal("Cancelled", res.response, "error");
                        }
                    }
                });
            } else {
                swal("Cancelled", "", "error");
            }
        });
    });

    $('body').on('click', '.active_status', function (event) {

        var u_id = $(this).attr('data-id');
        swal({
            title: "Are you sure?",
            text: "You want to active this user!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, active it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {

                $.ajax({
                    url:'<?php echo admin_url(); ?>users/active_status',
                    type:'post',
                    dataType: 'json',
                    data:{ user_id : u_id },
                    success:function(res){
                        if(res.msg == 'success'){
                            swal({title: "Active!", text: res.response, type: "success"},
                                function(){
                                    location.reload();
                                });
                        }else if (res.msg = 'error'){
                            swal("Cancelled", res.response, "error");
                        }
                    }
                });
            } else {
                swal("Cancelled", "", "error");
            }
        });
    });

    $('body').on('click', '.banned', function (event) {

        var user_id = $(this).attr('data-id');
        var banned = $(this).attr('data-banned');

        swal({
            title: "Are you sure?",
            text: "You want to perform this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, please!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {

                $.ajax({
                    url:'<?php echo admin_url(); ?>users/'+banned,
                    type:'post',
                    data:{ user_id : user_id },
                    dataType:'json',
                    success:function(res){
                        if(res.msg == 'success'){
                            swal({title: "Active!", text: res.response, type: "success"},
                                function(){
                                    location.reload();
                                });
                        }else if (res.msg = 'error'){
                            swal("Cancelled", res.response, "error");
                        }
                    }
                });
            } else {
                swal("Cancelled", "", "error");
            }
        });
    });

</script>