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
        </div>

        <div class="page-body">
            <div class="card">

                <div class="card-block">
                    <div class="table-contentt crm-tablee">
                        <div class="project-tablee">
                            <table id="books_tabls" class="table table-striped dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>User</th>
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
                                        <th>Book Condition</th>
                                        <th>Is Sold</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if(empty($books)) { ?>
                                        <tr>
                                            <td colspan="11"> Books not found </td>
                                        </tr>
                                    <?php } ?>
                                    <?php foreach ($books as $book) { ?>
                                        <tr>
                                            <td><?php echo !empty($book['first_name']) ? $book['first_name'] : $book['email']; ?></td>
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
                                                <?php if ($book['book_condition'] == 0) { ?>
                                                    <label class="label label-info">New</label>
                                                <?php }else{ ?>
                                                    <label class="label label-primary">Used</label>
                                                <?php } ?>
                                            </td>

                                            <td>
                                                <?php if ($book['is_orderd'] == 0) { ?>
                                                    <label class="label label-danger">No</label>
                                                <?php }else{ ?>
                                                    <label class="label label-info">Yes</label>
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
                            <label>Please select a CSV file to upload.</label>
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

    </div>
</div>

<?php $this->load->view('common/admin_footer'); ?>
<script type="text/javascript">
    $(document).ready( function () {
       $('#books_tabls').DataTable( {
            "lengthMenu": [[10, 25, 50 , 100, -1], [10, 25, 50, 100, "All"]]
        });
    });
</script>