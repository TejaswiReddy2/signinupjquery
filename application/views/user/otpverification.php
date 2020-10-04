<section class="sign-in">
    <div class="container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src="{ASSET_INCLUDE_URL}images/signin-image.jpg" alt="sing up image"></figure>
                <a href="{BASE_URL}login" class="signup-image-link">Back</a>
            </div>

            <div class="signin-form">
                <h4 class="form-title">Enter your OTP sent to your registered mobile number <br> ( use 4321 for verification )</h4>
                <form name="verificationForm" id="currentPageForm" class="verificationForm dez-form p-b30" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                      <input type="number" name="otp" required autocomplete="off" id="otp" class="form-control otp" placeholder="Code" value="<?php if(set_value('otp')): echo set_value('otp');endif;?>"/>
                      <?php if(form_error('otp')):?>
                        <p for="otp" class="error"><?php echo form_error('otp');?></p>
                      <?php endif;?>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="saveChanges" id="saveChanges" class="form-submit" value="Verify"/>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
  $(document).ready(function(){
        $('#currentPageForm').validate({
           
          messages:{
            otp : {required:"OTP  is required"},
          },
          submitHandler: function(form){
            var verifyotp = $('#otp').val();
            $.ajax({
            type: 'post',
            url:BASEURL+"otp-verification",
            data: {verifyotp:verifyotp}, 
            success: function(result){ 
              result 	=	result.trim();
              if(result == 'success'){ 
                var message = '<p>Phone Verification Done Successfully</p>';
                alertMessageModelPopup(message,'Success');
                setTimeout(function(){ redirecthome()}, 3000);
              } 
              else if(result == 'wrongotp'){ 
                var message = '<p>OTP mismatch!!.Plesae enter correct otp</p>'; 
                alertMessageModelPopup(message,'Warning');
                return false;
              } 
              else if(result == 'active'){ 
                var message = '<p>Your phone is already verified,Plesae Login</p>'; 
                alertMessageModelPopup(message,'Warning');
                return false;
              } 
              else if(result == 'blocked'){ 
                var message = '<p>Your account is blocked,Plesae contact administrator.</p>'; 
                alertMessageModelPopup(message,'Warning');
                setTimeout(function(){ redirecthome()}, 3000);
              } 
              else {
                var message = '<p>Something went wrong.</p>'; 
                alertMessageModelPopup(message,'Warning');
                return false;
              }
            }
        });
      return false;
          }
        });
  });

function redirecthome(){
window.location.href = BASEURL+'my-profile';
}
</script>