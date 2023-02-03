<?php
$this->load->view('common/admin_header');
$this->load->view('common/admin_sidebar');

?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>General Settings</h4>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="sub-title">Manage Settings</div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs md-tabs setting-tabs" role="tablist">
                        <li class="nav-item col-lg-6">
                            <a class="nav-link active" data-toggle="tab" href="#home5" role="tab">General Text and Settings</a>
                        </li>
                        <li class="nav-item col-lg-6">
                            <a class="nav-link" data-toggle="tab" href="#cms_pages" role="tab">CMS Pages</a>
                        </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content col-md-8 offset-md-2 card-block">
                        <div class="tab-pane active" id="home5" role="tabpanel">
                            <?php if(!empty($this->session->flashdata('alert_success'))): ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Success!</strong> <?php echo $this->session->flashdata('alert_success'); ?>
                                </div>
                                <?php elseif(!empty($this->session->flashdata('alert_error'))): ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Error!</strong> <?php echo $this->session->flashdata('alert_error'); ?>
                                    </div>
                                <?php endif; ?>
                                <h3> Home </h3>
                                <hr>
                                <form method="post" action="<?php echo admin_url(); ?>settings/general_settings/update_home" enctype="multipart/form-data" novalidate="">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Banner Image (Best Image Size 1920 x 768) </label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="banner_image" type="file">
                                        </div>
                                        <div class="col-sm-12 offset-md-1 text-center"><br>
                                            <img class="img-responsive" style="max-width: 250px;" src="<?php echo base_url(); ?>/assets/images/<?php echo get_section_content('home' , 'banner_image'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Welcome Text (English)</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="welcome_text_english" id="welcome_text" placeholder="Enter welcome text" type="text" value="<?php echo get_section_content('home' , 'welcome_text_english'); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Welcome Text (German)</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="welcome_text_german" id="welcome_text" placeholder="Enter welcome text" type="text" value="<?php echo get_section_content('home' , 'welcome_text_german'); ?>">
                                        </div>
                                    </div>

                                    <!-- <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Welcome Description (English)</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="welcome_desc_english" id="welcome_desc" placeholder="Enter welcome description"><?php //echo get_section_content('home' , 'welcome_desc_english'); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Welcome Description (German)</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="welcome_desc_german" id="welcome_desc" placeholder="Enter welcome description"><?php //echo get_section_content('home' , 'welcome_desc_german'); ?></textarea>
                                        </div>
                                    </div> -->

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Footer Text (English)</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="footer_text_english" id="footer_text" placeholder="Enter footer text"><?php echo get_section_content('home' , 'footer_text_english'); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Footer Text (German)</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="footer_text_german" id="footer_text" placeholder="Enter footer text"><?php echo get_section_content('home' , 'footer_text_german'); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4"></label>
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-primary m-b-0 float-right">Submit</button>
                                        </div>
                                    </div>
                                </form>

                                <!-- <h3> Social links </h3> -->
                                <!-- <hr> -->
                                <!-- <form method="post" action="<?php // echo admin_url(); ?>settings/general_settings/update_social_links" novalidate="">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Facebook</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="facebook" id="facebook" placeholder="Enter facebook link includeing http://" type="text" value="<?php // echo get_section_content('social_links' , 'facebook'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Twitter</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="twitter" id="twitter" placeholder="Enter twitter link includeing http://" type="text" value="<?php // echo get_section_content('social_links' , 'twitter'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Instagram</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="instagram" id="instagram" placeholder="Enter instagram link includeing http://" type="text" value="<?php // echo get_section_content('social_links' , 'instagram'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4"></label>
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-primary m-b-0 float-right">Submit</button>
                                        </div>
                                    </div>
                                </form> -->

                                <h3> Contact Us </h3>
                                <hr>
                                <form method="post" action="<?php echo admin_url(); ?>settings/general_settings/update_contact_us" novalidate="">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Address</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="contactus_address" id="contactus_address" placeholder="Enter company address" type="text" value="<?php echo get_section_content('contactus' , 'contactus_address'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Phone Number</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="contactus_phone" id="contactus_phone" placeholder="Enter company phone number" type="text" value="<?php echo get_section_content('contactus' , 'contactus_phone'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Email</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="contactus_email" id="contactus_email" placeholder="Enter company email address" type="email" value="<?php echo get_section_content('contactus' , 'contactus_email'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4"></label>
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-primary m-b-0 float-right">Submit</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="tab-pane" id="social_links5" role="tabpanel">

                            </div>
                            <div class="tab-pane" id="cms_pages" role="tabpanel">

                                <form method="post" action="<?php echo admin_url(); ?>settings/general_settings/update_aboutus" novalidate="">

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h3> About Us (English) </h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea name="aboutus_text1_english" id="editor0"><?php echo get_section_content('aboutus' , 'about_us_english'); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h3> About Us (German) </h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea name="aboutus_text1_german" id="editor1"><?php echo get_section_content('aboutus' , 'about_us_german'); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4"></label>
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-primary m-b-0 float-right">Submit</button>
                                        </div>
                                    </div>
                                </form>
                                <br />

                                <form method="post" action="<?php echo admin_url(); ?>settings/general_settings/update_charity" novalidate="">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h3> Charity (English) </h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea name="charity1_english" id="editor2"><?php echo get_section_content('charity' , 'charity_english'); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h3> Charity (German) </h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea name="charity1_german" id="editor3"><?php echo get_section_content('charity' , 'charity_german'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary m-b-0 float-right">Submit</button>
                                        </div>
                                    </div>
                                </form>
                                <br />
                                <!-- <form method="post" action="<?php // echo admin_url(); ?>settings/general_settings/how_it_works" novalidate="">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h3> How it works (English) </h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea name="how_it_works_english" id="editor4"><?php // echo get_section_content('how_it_works' , 'how_it_works_english'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h3> How it works (German) </h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea name="how_it_works_german" id="editor5"><?php // echo get_section_content('how_it_works' , 'how_it_works_german'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4"></label>
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-primary m-b-0 float-right">Submit</button>
                                        </div>
                                    </div>
                                </form> -->
                                <!-- <br /> -->
                                <form method="post" action="<?php echo admin_url(); ?>settings/general_settings/update_terms_and_conditions" novalidate="">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h3> Terms and conditions (English) </h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea name="tcondition1_english" id="editor6"><?php echo get_section_content('termconditions' , 'termconditions_english'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h3> Terms and conditions (German) </h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea name="tcondition1_german" id="editor7"><?php echo get_section_content('termconditions' , 'termconditions_german'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary m-b-0 float-right">Submit</button>
                                        </div>
                                    </div>
                                </form>
                                <br />
                                <form method="post" action="<?php echo admin_url(); ?>settings/general_settings/update_privacy_policy" novalidate="">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h3> Privacy policy (English) </h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea name="ppolicy1_english" id="editor8"><?php echo get_section_content('privacypolicy' , 'privacypolicy_english'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h3> Privacy policy (German) </h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea name="ppolicy1_german" id="editor9"><?php echo get_section_content('privacypolicy' , 'privacypolicy_german'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary m-b-0 float-right">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('common/admin_footer'); ?>
        <script src="<?php echo base_url(); ?>/admin_assets/bower_components/ckeditor/ckeditor.js"></script>
        <script src="<?php echo base_url(); ?>/admin_assets/bower_components/ckeditor/config.js"></script>
        <script type="text/javascript">
        </script>
        <script>
            for (i = 0; i <= 9; i++) {
                if (i == 4 || i == 5) {
                    continue;
                }
                CKEDITOR.replace( 'editor'+i, {
                    extraPlugins: 'image2,uploadimage,texttransform',
                    format_tags: 'p;h1;h2;h3;pre',
                    removeDialogTabs: 'image:advanced;link:advanced',
                    height: 450
                } );
            }

        </script>
        <script src="https://rawgit.com/RobinHerbots/Inputmask/4.x/dist/jquery.inputmask.bundle.js"></script>
        <script>
            $('#contactus_phone').inputmask({mask: '+99 99 999 99 99'});
        </script>