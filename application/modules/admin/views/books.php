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
                <button type="button" class="btn btn-primary btn-w-m t_m_25" data-toggle="modal" data-target="#add_books"><i class="fa fa-plus" aria-hidden="true"></i> Add Book</button>

                <button type="button" class="btn btn-w-m t_m_25 btn-danger" data-toggle="modal" data-target="#bookscsvmodal"><i class="fa fa-upload" aria-hidden="true"></i> Upload Books Sheet</button>

                <a href="<?php echo admin_url(); ?>books/downloadbookscsv" target="_blank" class="btn btn-w-m t_m_25 btn-warning"><i class="fa fa-download" aria-hidden="true"></i> Download Books Sheet </a>

                <a href="<?php echo admin_url(); ?>books/downloadcsv" target="_blank" class="btn btn-w-m t_m_25 btn-info"><i class="fa fa-download" aria-hidden="true"></i> Download Sample Sheet </a>

            </div>
        </div>

        <div class="page-body">
            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <form action="<?php echo admin_url(); ?>books/search" method="get" id="search_form">
                                <div class="input-group">
                                    <input type="text" class="input form-control" name="keyword" id="keyword" placeholder="Search by book name" value="<?php echo @$_GET['keyword']; ?>">
                                    <span class="input-group-append">
                                        <button type="button" id="search" class="btn btn-primary"> <i class="fa fa-search"></i> Search</button>
                                        <?php if(!empty(@$_GET['keyword'])) { ?>
                                            <button type="button" id="clear_search" class="btn btn-danger"> <i class="fa fa-eraser"></i> Clear</button>
                                        <?php } ?>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-contentt crm-tablee">
                        <div class="project-tablee">
                            <table id="books_tabls" class="table table-striped dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>University</th>
                                        <th>Field Of Study</th>
                                        <th>Full Time Semester </th>
                                        <th>Part Time Semester</th>
                                        <th>Mandatory/Optional</th>
                                        <th>Price</th>
                                        <th>ISBN</th>
                                        <th>Book Name</th>
                                        <th>Extra Information</th>
                                        <th>Module</th>
                                        <th>Only Used</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($books)) { ?>
                                        <?php foreach ($books as $book) { ?>
                                            <tr>
                                                <td><?php echo $book['university']; ?></td>
                                                <td><?php echo $book['field_of_study']; ?></td>
                                                <td><?php echo $book['full_time_semester']; ?></td>
                                                <td><?php echo $book['part_time_semester']; ?></td>
                                                <td><?php if(!$book['mandatory_or_optional']) { ?> Ja <?php } else { ?>  Nein <?php } ?></td>
                                                <td><?php echo $book['price']; ?> CHF</td>
                                                <td><?php echo $book['ISBN']; ?></td>
                                                <td><?php echo $book['book_name']; ?></td>
                                                <td><?php echo $book['extra_information']; ?></td>
                                                <td><?php echo $book['module']; ?></td>
                                                <td>
                                                    <?php if($book['only_used'] == 1) { ?>
                                                        Ja
                                                    <?php } else { ?>
                                                        Nein
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm edit_book" data-id="<?php echo $book['id']; ?>" title="Edit Book"> <i class="fa fa-edit"></i> Edit Book</button>
                                                    <button class="btn btn-danger btn-sm delete_book" data-id="<?php echo $book['id']; ?>" title="Delete Book"><i class="fa fa-trash"></i> Delete Book</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <tr>
                                            <td colspan="11"> Books not found </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <?php if (isset($links)) { ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-5">
                                <!-- <p>Showing <?php //echo $start_index+1; ?> to <?php // echo $start_index+50; ?> of <?php // echo $total_books; ?> entries</p> -->
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="simpletable_paginate">
                                    <?php echo $links ?>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                </div>
            </div>
            <!-- Container-fluid ends -->
        </div>


        <!-- --------------------------- upload csv modal ------------------------- -->
        <div class="modal" id="bookscsvmodal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Upload Books Sheet</h4>

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form role="form" id="bookscsvform" class="form-inline" enctype="multipart/form-data">
                            <label>Please select a XLSX file to upload.</label>
                            <div class="form-group">
                                <input type="file" class="form-control" name="bookscsv">
                            </div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="uploadcsv">Upload</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- ----------------------- end upload csv modal --------------------- -->


        <!-- ----------------------- BEGAN ADD BOOK MODAL --------------------- -->
        <div class="modal" id="add_books">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Books</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form id="add_books_form">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">University</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="University" name="university">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Field Of Study</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Field Of Study" name="field_of_study">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Full Time Semester</label>
                                <div class="col-md-9">
                                    <input type="number" min="1" class="form-control" placeholder="Full Time Semester" name="full_time_semester">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Part Time Semester</label>
                                <div class="col-md-9">
                                    <input type="number" min="1" class="form-control" placeholder="Part Time Semester" name="part_time_semester">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Module</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Module" name="module">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Price</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">CHF</span>
                                        <input type="text" class="form-control" placeholder="Price" name="price" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">ISBN</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="ISBN" name="ISBN" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Book Name</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" placeholder="Book Name" name="book_name" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Extra Information</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" placeholder="Extra Information" name="extra_information"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Mandatory</label>
                                <div class="col-md-9">
                                    <div class="form-radio">
                                        <div class="radio radio-inline">
                                            <label>
                                                <input type="radio" name="mandatory_or_optional" checked="checked" value="0">
                                                <i class="helper"></i>Yes
                                            </label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <label>
                                                <input type="radio" name="mandatory_or_optional" value="1">
                                                <i class="helper"></i>No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Only Used</label>
                                <div class="col-md-9">
                                    <div class="checkbox-fade fade-in-primary">
                                        <label>
                                            <input type="checkbox" name="only_used">
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span> <span>Yes</span>
                                        </label>
                                    </div>
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


        <!-- ----------------------- BEGAN ADD BOOK MODAL --------------------- -->
        <div class="modal" id="edit_book_modal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Books</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body" id="edit_book_modal_body"></div>

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
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching":false
        });

    });

    $("#uploadcsv").click(function() {
        var btn = $(this);
        $(btn).addClass('disabled').text('Please wait...');
        var formData = new FormData($("#bookscsvform")[0]);
        $.ajax({
            url:'<?php echo admin_url(); ?>books/upload_books_csv',
            type: 'POST',
            data: formData,
            async: true,
            contentType: false,
            dataType:'json',
            processData: false,
            success:function(status){
                $(btn).removeClass('disabled').text('Upload');
                if(status.msg=='success'){
                    $('#bookscsvform')[0].reset();
                    notify('Success! ', status.response, 'success');
                    setTimeout(function(){ location.reload(); }, 2000);
                }
                else if(status.msg == 'error'){
                    notify('Error! ', status.response, 'danger');
                }
            }
        });
    });


    $(document).on("click" , "#btn_submit" , function() {
        $('#add_books_form').validate({
            errorPlacement: function(error, element) {
                if(element.parent().hasClass('input-group')){
                    error.insertBefore( element.parent() );
                }else{
                    error.insertBefore( element );
                }
            }
        });
        if($("#add_books_form").valid()){
            var value = $("#add_books_form").serialize();
            $.ajax({
                url:'<?php echo admin_url(); ?>books/add',
                type:'post',
                data:value,
                dataType:'json',
                success:function(status){

                    if(status.msg=='success'){
                        notify('Success! ', status.response, 'success');
                        $("#add_books_form")[0].reset();
                        location.reload();
                    }

                    else if(status.msg == 'error'){
                        notify('Error! ', status.response, 'danger');
                    }
                }
            });
        }
    });


    $(document).on("click" , ".delete_book" , function() {
        var id = $(this).attr('data-id');
        swal({
            title: "Are you sure?",
            text: "You want to dalete this book!",
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
                    url:'<?php echo admin_url(); ?>books/delete',
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

    $(document).on("click" , ".edit_book" , function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url:'<?php echo admin_url(); ?>books/edit',
            type: 'POST',
            data: { id : id},
            dataType:'json',
            success:function(status){
                if(status.msg=='success'){
                    $('#edit_book_modal_body').html(status.response);
                    $('#edit_book_modal').modal('show');
                }
                else if(status.msg == 'error'){
                    notify('Error! ', status.response, 'danger');
                }
            }
        });
    });

    $(document).on("click" , "#btn_submit_edit" , function() {

        $('#edit_books_form').validate({
            errorPlacement: function(error, element) {
                if(element.parent().hasClass('input-group')){
                    error.insertBefore( element.parent() );
                }else{
                    error.insertBefore( element );
                }
            }
        });

        if($("#edit_books_form").valid()){
            var value = $("#edit_books_form").serialize();
            $.ajax({
                url:'<?php echo admin_url(); ?>books/update',
                type:'post',
                data:value,
                dataType:'json',
                success:function(status){
                    if(status.msg=='success'){
                        notify('Success! ', status.response, 'success');
                        location.reload();
                    }
                    else if(status.msg == 'error'){
                        notify('Error! ', status.response, 'danger');
                    }
                }
            });
        }
    });

    $("#search").click(function() {
        if($.trim($("#keyword").val()) !== '') {
            $("#search_form").submit();
        }  else {
            notify('Error! ', "Search field is required.", 'danger');
        }
    });


    $(document).on('click', '#clear_search', function() {
        window.location.href = "<?php echo admin_url(); ?>books";
    });


</script>