<?php
require_once('header.php');
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Update Website Information</h3></div>
                <div class="card-body">
                    <form action="info_pro.php" method="POST" enctype="multipart/form-data">
                        <div class="card-header"><h4 class="font-weight-light my-4">Basic Information</h4></div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="website_name" id="WebsiteName" type="text" placeholder="yout website name" value="<?php info('website_name'); ?>" required/>
                            <label for="WebsiteName">Website Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="logo" id="logo" type="file" placeholder="Upload Your logo"/>
                            <label for="logo">Logo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="full_name" id="full_name" type="text" placeholder="Upload Your logo" value="<?php info('comapny_full_name'); ?>"/>
                            <label for="full_name">company full name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="slogon" id="Slogon" type="text" placeholder="Company Slogon Text" value="<?php info('slogon'); ?>"/>
                            <label for="Slogon">Slogon</label>
                        </div>
                        <div class="card-header"><h4 class="font-weight-light my-4">Contact Information</h4></div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="phone" id="phone" type="text" placeholder="Company Phone Number" value="<?php info('phone'); ?>"/>
                            <label for="phone">Phone</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="fax" id="Fax" type="text" placeholder="Company Fax Number" value="<?php info('fax'); ?>"/>
                            <label for="Fax">Fax</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="mobile" id="Mobile" type="text" placeholder="Company Mobile Number" value="<?php info('mobile'); ?>"/>
                            <label for="Mobile">Mobile</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="email" id="email" type="text" placeholder="Company Contact E-mail" value="<?php info('e-mail'); ?>"/>
                            <label for="email">E-mail</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="address" id="address" type="text" placeholder="Company Address" value="<?php info('address'); ?>"/>
                            <label for="address">Address</label>
                        </div>
                        <div class="row">
                            <div class="">Location</div>
                            <div class="form-floating mb-3 col-sm-6">
                                <input class="form-control" name="lat" id="Lat" type="text" placeholder="Company Lat Cordnate" value="<?php info('lat'); ?>"/>
                                <label for="Lat">Lat</label>
                            </div>
                            <div class="form-floating mb-3  col-sm-6">
                                <input class="form-control" name="long" id="Long" type="text" placeholder="Company Long Cordnate" value="<?php info('long'); ?>"/>
                                <label for="Long">Long</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="">Business Hours</div>
                            <div class="form-floating mb-3 col-sm-6">
                                <input class="form-control" name="start" id="start" type="time" placeholder="Business Daily Start Hours"  value="<?php info('start_hour'); ?>"/>
                                <label for="start">Start</label>
                            </div>
                            <div class="form-floating mb-3 col-sm-6">
                                <input class="form-control" name="end" id="end" type="time" placeholder="Business Daily End Hours"  value="<?php info('end_hour'); ?>"/>
                                <label for="end">End</label>
                            </div>
                        </div>
                        <div class="card-header"><h4 class="font-weight-light my-4">Social Media Links</h4></div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="facebook" id="facebook" type="text" placeholder="Facebook Account Url" value="<?php info('facebook'); ?>"/>
                            <label for="facebook">Facebook</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="twitter" id="twitter" type="text" placeholder="Twitter Account Url" value="<?php info('twitter'); ?>"/>
                            <label for="twitter">Twitter</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="instagram" id="Instagram" type="text" placeholder="Instagram Account Url" value="<?php info('instagram'); ?>"/>
                            <label for="Instagram">Instagram</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="linkedIn" id="LinkedIn" type="text" placeholder="LinkedIn Account Url" value="<?php info('linkedin'); ?>"/>
                            <label for="LinkedIn">LinkedIn</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="google" id="google" type="text" placeholder="Google Plus Account Url" value="<?php info('google'); ?>"/>
                            <label for="google">Google Plus</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="youtube" id="Youtube" type="text" placeholder="Youtube Account Url" value="<?php info('youtube'); ?>"/>
                            <label for="Youtube">Youtube Plus</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input class="form-control" name="navcolor" id="NavColor" type="color" placeholder="Select Navigation Bar Color" value="<?php info('navcolor'); ?>"/>
                            <label for="NavColor">Navigation Bar Color</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input class="form-control" name="socialcolor" id="SocialColor" type="color" placeholder="Select Social Media bar Color" value="<?php info('socialcolor'); ?>"/>
                            <label for="SocialColor">Social Media Bar Color</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input class="form-control" name="footercolor" id="FooterColor" type="color" placeholder="Select Footer Color" value="<?php info('footercolor'); ?>"/>
                            <label for="FooterColor">Social Media Bar Color</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input class="form-control" name="buttoncolor" id="ButtonColor" type="color" placeholder="Select Buttons Color" value="<?php info('buttoncolor'); ?>"/>
                            <label for="ButtonColor">Social Buttons Color</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select name="dir" id="sitedir"class="form-control">
                                <option value="ltr" 
                                <?php 
                                    if($_SESSION['siteInfoArray']['dir'] == 'ltr'){
                                        echo ' selected ';
                                    }
                                ?>
                                >LTR</option>
                                <option value="rtl"
                                <?php 
                                    if($_SESSION['siteInfoArray']['dir'] == 'rtl'){
                                        echo ' selected ';
                                    }
                                ?>
                                >RTL</option>
                            </select>
                            <label for="sitedir">Site Direction</label>
                        </div>

                        <div class="align-items-center justify-content-between mt-4 mb-0">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once('footer.php');
?>