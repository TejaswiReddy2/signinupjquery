<section class="sign-in">
    <div class="container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src="{ASSET_INCLUDE_URL}images/signin-image.jpg" alt="sing up image"></figure>
            </div>

            <div class="signin-form">
                <h4 class="form-title">Hello, <?php echo $this->session->userdata('VB_FULL_NAME');?></h4>
                <h4 class="form-title">Welcome to VBloggers, Below are your details:</h4>
                <form name="verificationForm" id="currentPageForm" class="verificationForm dez-form p-b30" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                      <input disabled type="text" class="form-control otp" placeholder="" value="<?php echo $this->session->userdata('VB_FULL_NAME');?>"/>
                    </div>
                    <div class="form-group">
                      <label for="your_name"><i class="zmdi zmdi-email material-icons-name"></i></label>
                      <input disabled type="text" class="form-control otp" placeholder="" value="<?php echo $this->session->userdata('VB_USER_EMAIL');?>"/>
                    </div>
                    <div class="form-group">
                      <label for="your_name"><i class="zmdi zmdi-phone material-icons-name"></i></label>
                      <input disabled type="text" class="form-control otp" placeholder="" value="<?php echo $this->session->userdata('VB_USER_MOBILE');?>"/>
                    </div>
                    <div class="form-group form-button">
                        <a href="{BASE_URL}logout" class="form-submit">Logout ?</a>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</section>
