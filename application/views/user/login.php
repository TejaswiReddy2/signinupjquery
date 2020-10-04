<section class="sign-in">
    <div class="container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src="{ASSET_INCLUDE_URL}images/signin-image.jpg" alt="sing up image"></figure>
                <a href="{BASE_URL}sign-up" class="signup-image-link">Create an account</a>
            </div>

            <div class="signin-form">
                <h2 class="form-title">Login</h2>
                <form name="loginForm" id="currentPageForm" class="loginForm dez-form p-b30" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                      <input required autocomplete="off" type="number" name="mobile_number" id="mobile_number" class="form-control mobile_number" value="<?php if(set_value('mobile_number')): echo set_value('mobile_number');endif;?>" placeholder="Enter Your Mobile Number"/>
                      <?php if(form_error('mobile_number')):?>
                        <p for="mobile_number" class="error"><?php echo form_error('mobile_number');?></p>
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
                        <input type="checkbox" value="yes" name="remember-me" id="remember-me" class="agree-term" />
                        <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                    </div>
                    <a href="{BASE_URL}forgot-password" class="signup-image-link">Forgot Password?</a>
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
            mobile_number:{minlength:10 , maxlength:12},
            password:{minlength:6}
          },
          messages:{
            mobile_number:{required:"Please Enter Your Mobile Number."},
            password:{required:"Please Enter Your Password."},
          },
          submitHandler:function(form){
            var mobile_number   	= $('#mobile_number').val();
            var password 			= $("#password").val();
            if($('#remember-me').prop("checked") == true){
            var loggedin     	 	= $('#remember-me').val();
            var formType 			  =	'login';
            }
            $.ajax({
                url:BASEURL+"login",
                type:'post',
                data:{mobile_number:mobile_number,password:password,loggedin:loggedin,formType:formType},
                success:function(result){	
                  result 		=	result.trim();
                  resultData	=	result.split('____');
                  if(resultData[0] == 'success'){
                    var message = "Login-ed";
                    alertMessageModelPopup(message,'Success');
                    setTimeout(function(){ redirectuserdashboard()}, 1000);
                  }
                  else if(resultData[0] == 'wrongpassword'){
                      var message = "Password Mismatch";
                      alertMessageModelPopup(message,'Error');
                      return false;
                  }
                  else if(resultData[0] == 'accountinactive'){
                      var message = "Phone Is Not Verified.Please Verify";
                      alertMessageModelPopup(message,'Warning');
                      setTimeout(function(){ redirectOTP()}, 2000);
                      return false;
                  }
                  else if(resultData[0] == 'blocked'){ 
                      var message = 'Your Account Is Blocked,Plesae Contact Administrator.'; 
                      alertMessageModelPopup(message,'Warning');
                      setTimeout(function(){ redirecthome()}, 2000);
                    } 
                  else if(resultData[0] == 'noaccount'){
                      var message = "There Is No Account With This Number Please Register.";
                      alertMessageModelPopup(message,'Warning');
                      return false;
                  }
                   else if(resultData[0] == 'redirect'){
                      setTimeout(function(){ redirectURL(resultData[1])}, 1000);
                  }
                }
            });
          }
       });
  });
function redirectuserdashboard(){
window.location.href = BASEURL+'my-profile';
}
function redirecthome(){
window.location.href = BASEURL;
}
function redirectURL(url=''){
window.location.href = url;
}
function redirectOTP(){
window.location.href = BASEURL+'candidate/otp-verification';
}
</script>