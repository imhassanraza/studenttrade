<?php
$this->load->view('common/admin_header');
$this->load->view('common/admin_sidebar');
?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Books</h4>
            </div>
            <div class="page-header-breadcrumb">
                <button type="button" class="btn btn-primary btn-w-m t_m_25" data-toggle="modal" data-target="#add_discount_codes"><i class="fa fa-plus" aria-hidden="true"></i> Add Discount Code</button>
            </div>
        </div>

        <div class="page-body">
            <div class="card">
                <div class="card-block">
                    <div class="table-contentt crm-tablee">
                        <div class="project-tablee">
                            <table id="books_tabls" class="table table-striped dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr #.</th>
                                        <th>Discount Code</th>
                                        <th>Discount Type</th>
                                        <th>Code Value</th>
                                        <th>Valid From</th>
                                        <th>Valid To</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($codes)) { ?>
                                        <?php $i = 1; foreach ($codes as $code) { ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $code['code']; ?></td>
                                                <td>
                                                    <?php if($code['code_type'] == 1) { ?>
                                                        Fixed Value
                                                    <?php } else { ?>
                                                        Percentage
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if($code['code_type'] == 1) { ?>
                                                        <?php echo $code['code_value']; ?>
                                                    <?php } else { ?>
                                                        <?php echo $code['code_value']; ?>%
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo date("d-M-Y", strtotime($code['valid_from']));  ?></td>
                                                <td><?php echo date("d-M-Y", strtotime($code['valid_to'])); ?></td>
                                                <td>
                                                    <?php if($code['status'] == 1) { ?>
                                                        Closed
                                                    <?php } else { ?>
                                                        Active
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm edit_discount_code" data-id="<?php echo $code['id']; ?>" title="Edit Discount Code"> <i class="fa fa-edit"></i> Edit Code</button>
                                                    <button class="btn btn-danger btn-sm delete_discount_code" data-id="<?php echo $code['id']; ?>" title="Delete Discount Code"><i class="fa fa-trash"></i> Delete Code</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <tr>
                                            <td colspan="11"> Discount Codes not found </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ----------------------- BEGAN ADD CODE MODAL --------------------- -->
        <div class="modal" id="add_discount_codes">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Discount Code</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <form id="add_discount_code_form">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Discount code</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Discount Code" name="code" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Discount type</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="code_type">
                                        <option value="1">Fixed Value</option>
                                        <option value="2">Percentage</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Code value</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Code Value" name="code_value" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Valid From To</label>
                                <div class="col-md-9">
                                    <input type="text" name="daterange" class="form-control" value="<?php echo date('m/d/Y'); ?> - <?php echo date('m/d/Y', strtotime(date('m/d/Y'). ' + 2 days')); ?>" />
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn_submit">Submit</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- ----------------------- END ADD BOOKS MODAL --------------------- -->

        <!-- ----------------------- BEGAN EDIT BOOK MODAL --------------------- -->
        <div class="modal" id="edit_discount_code_modal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Books</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body" id="edit_discount_code_modal_body"></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn_submit_edit">Update</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- ----------------------- END ADD BOOKS MODAL --------------------- -->
    </div>
</div>

<?php $this->load->view('common/admin_footer'); ?>
<script src="<?php echo base_url(); ?>admin_assets/js/jquery.validate.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready( function () {
        $('#books_tabls').DataTable( {
            "paging":   true,
            "ordering": true,
            "info":     true,
            "searching":true
        });
    });

    $(document).on("click" , "#btn_submit" , function() {
        $('#add_discount_code_form').validate({
            errorPlacement: function(error, element) {
                if(element.parent().hasClass('input-group')){
                    error.insertBefore( element.parent() );
                }else{
                    error.insertBefore( element );
                }
            }
        });
        if($("#add_discount_code_form").valid()){
            var value = $("#add_discount_code_form").serialize();
            $.ajax({
                url:'<?php echo admin_url(); ?>discount_code/add',
                type:'post',
                data:value,
                dataType:'json',
                success:function(status){
                    if(status.msg=='success'){
                        notify('Success! ', status.response, 'success');
                        $("#add_discount_code_form")[0].reset();
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                    else if(status.msg == 'error'){
                        notify('Error! ', status.response, 'danger');
                    }
                }
            });
        }
    });

    $(document).on("click" , ".delete_discount_code" , function() {
        var id = $(this).attr('data-id');
        swal({
            title: "Are you sure?",
            text: "You want to dalete this code!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, dalete!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:'<?php echo admin_url(); ?>discount_code/delete',
                    type:'post',
                    dataType: 'json',
                    data:{id: id},
                    success:function(res){
                        if(res.msg == 'success'){
                            swal({title: "Deleted!", text: res.response, type: "success"},
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

    $(document).on("click" , ".edit_discount_code" , function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url:'<?php echo admin_url(); ?>discount_code/edit',
            type: 'POST',
            data: { id : id},
            dataType:'json',
            success:function(status){
                if(status.msg=='success'){
                    $('#edit_discount_code_modal_body').html(status.response);
                    $('#edit_discount_code_modal').modal('show');
                }
                else if(status.msg == 'error'){
                    notify('Error! ', status.response, 'danger');
                }
            }
        });
    });

    $(document).on("click" , "#btn_submit_edit" , function() {
        var value = $("#edit_discount_codes_form").serialize();
        $.ajax({
            url:'<?php echo admin_url(); ?>discount_code/update',
            type:'post',
            data:value,
            dataType:'json',
            success:function(status){
                if(status.msg=='success'){
                    notify('Success! ', status.response, 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
                else if(status.msg == 'error'){
                    notify('Error! ', status.response, 'danger');
                }
            }
        });
    });
</script>