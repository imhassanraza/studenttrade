<?php
$this->load->view('common/admin_header');
$this->load->view('common/admin_sidebar');

?>

<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Contact Us</h4>
            </div>
            <div class="page-header-breadcrumb">
                <a href="<?php echo admin_url(); ?>preference/contactus" class="btn btn-primary">Back to contact us</a>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Contact Us</h5>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="res-config" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Section</th>
                                            <th>Content</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($contactus as $contact) { ?>
                                            <tr>
                                                <td> <?php echo ucwords( str_replace("_"," ",$contact['meta_key']) ); ?> </td>
                                                <td> <?php echo $contact['meta_value']; ?> </td>
                                                <td>
                                                    <a href="<?php echo admin_url(); ?>cms/edit_content/<?php echo $contact['meta_id']; ?>">Edit</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('common/admin_footer'); ?>