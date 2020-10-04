<section class="sign-in">
    <div class="container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src="{ASSET_INCLUDE_URL}images/signin-image.jpg" alt="sing up image"></figure>
                <a href="{BASE_URL}sign-up" class="signup-image-link">Create an account</a>
            </div>

            <div class="signin-form">
                <h2 class="form-title">Reset Password</h2>
                <h4 class="form-title">Enter your OTP sent to your registered mobile number. ( use 4321 as OTP )</h4>
                <form name="loginForm" id="currentPageForm" class="loginForm dez-form p-b30" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                      <input type="number" name="otp" required autocomplete="off" id="otp" class="form-control otp" placeholder="Code" value="<?php if(set_value('otp')): echo set_value('otp');endif;?>"/>
                      <?php if(form_error('otp')):?>
                        <p for="otp" class="error"><?php echo form_error('otp');?></p>
                      <?php endif;?>
                    </div>
                    <div class="form-group">
                        <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                        <input required autocomplete="off" type="password" name="password" id="password" class="form-control password" value="<?php if(set_value('password')): echo set_value('password');endif;?>" placeholder="Password"/>
                        <?php if(form_error('password')):?>
                          <p for="password" class="error"><?php echo form_error('password');?></p>
                        <?php endif;?>
                     </div>
                      <div class="form-group">
                        <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                        <input required autocomplete="off" type="password" name="confirm_password" id="confirm_password" class="form-control confirm_password" value="<?php if(set_value('confirm_password')): echo set_value('confirm_password');endif;?>" placeholder="Confirm Password"/>
                        <?php if(form_error('confirm_password')):?>
                          <p for="confirm_password" class="error"><?php echo form_error('confirm_password');?></p>
                        <?php endif;?>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="saveChanges" id="saveChanges" class="form-submit" value="Log in"/>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
  $(document).ready(function(){
       $('#currentPageForm').validate({
           rules:{
            password : {minlength: 6 , maxlength: 20},
            confirm_password : {minlength: 6 , maxlength: 20 ,equalTo:"#password"}
          },
          messages:{
            otp    : {required:"OTP is required"},
            password 		 : {required:"Please Enter Your Password."},
            confirm_password : {required:"Confirm Password Must Match Your Password."},
          },
          submitHandler: function(form){
            var otp    = $('#otp').val();
            var password = $('#password').val();
            var confirm_password = $('#confirm_password').val();
            $.ajax({
                url:BASEURL+"reset-password",
                type:'post',
                data:{otp:otp,password:password,confirm_password:confirm_password},
                success:function(result){
                  var result 	=	result.trim();	
                  if(result == 'success'){
                    var message = "Password Reset Successfully.Please Login";
                    alertMessageModelPopup(message,'Success');
                    setTimeout(function(){ redirectlogin()}, 1000);
                  }
                  else if(result == 'blocked'){ 
                    var message = 'Your Account Is Blocked,Please Contact Administrator.'; 
                    alertMessageModelPopup(message,'Warning');
                    setTimeout(function(){ redirecthome()}, 3000);
                  } 
                  else if(result == 'wrongotp'){ 
                    var message = 'OTP mismatch!!.Please Enter Correct OTP'; 
                    alertMessageModelPopup(message,'Warning');
                    return false;
                  }
                }
            });
          }
       });
  });

function redirectlogin(){
window.location.href = BASEURL+'login';
}

function redirecthome(){
window.location.href = BASEURL;

}

</script>