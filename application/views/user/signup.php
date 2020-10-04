<!-- Sign up form -->
<section class="signup">
    <div class="container">
        <div class="signup-content">
            <div class="signup-form">
                <h2 class="form-title">Sign up</h2>
                <form name="registrationForm" id="currentPageForm" class="dez-form registrationForm" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input required autocomplete="off" type="text" name="full_name" id="full_name" class="form-control full_name" value="<?php if(set_value('full_name')): echo set_value('full_name');endif;?>" placeholder="Full Name"/>
            						<?php if(form_error('full_name')):?>
            							<p for="full_name" class="error"><?php echo form_error('full_name');?></p>
            						<?php endif;?>
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-email"></i></label>
                        <input required autocomplete="off" type="email" name="user_email" id="user_email" class="form-control user_email" value="<?php if(set_value('user_email')): echo set_value('user_email');endif;?>" placeholder="Email"/>
            						<?php if(form_error('user_email')):?>
            							<p for="user_email" class="error"><?php echo form_error('user_email');?></p>
            						<?php endif;?>
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-phone"></i></label>
                        <input required autocomplete="off" type="number" name="mobile_number" id="mobile_number" class="form-control mobile_number" value="<?php if(set_value('mobile_number')): echo set_value('mobile_number');endif;?>" placeholder="Enter Your Mobile Number"/>
            						<?php if(form_error('mobile_number')):?>
            							<p for="mobile_number" class="error"><?php echo form_error('mobile_number');?></p>
            						<?php endif;?>
                    </div>
                    <div class="form-group">
                        <label for="pass"><i class="zmdi zmdi-lock"></i></label>
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
                    <div class="form-group">
                        <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                        <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="saveChanges" id="saveChanges" class="form-submit" value="Register"/>
                    </div>
                </form>
            </div>
            <div class="signup-image">
                <figure><img src="{ASSET_INCLUDE_URL}images/signup-image.jpg" alt="sing up image"></figure>
                <a href="{BASE_URL}login" class="signup-image-link">I am already member</a>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
	$(document).ready(function(){
        $('#currentPageForm').validate({
           rules:{
           	full_name:{minlength:3,maxlength:30},
           	user_name:{minlength:3,maxlength:30},
          	mobile_number : {minlength: 10 , maxlength: 12},
          	password : {minlength: 6 , maxlength: 20},
          	confirm_password : {minlength: 6 , maxlength: 20 ,equalTo:"#password"}
          },
          messages:{
            full_name 		 : {required:"Please Enter Your Full Name."},
            user_name 		 : {required:"Please Enter Your User Name."},
            user_email 		 : {required:"Please Enter Valid Email Id."},
            mobile_number    : {required:"Please Enter Your Mobile Number."},
            password 		 : {required:"Please Enter Your Password."},
            confirm_password : {required:"Confirm Password Must Match Your Password."},
            aggreecheck 			 : {required:"Please Accept Terms & Conditions."},
          },	
          submitHandler: function(form){
          	var full_name 			= $('#full_name').val();
          	var user_name 			= $('#user_name').val();
          	var user_email 			= $('#user_email').val();
          	var mobile_number    	= $('#mobile_number').val();
          	var password 			= $('#password').val();
          	var confirm_password 	= $('#confirm_password').val();
          	var FormType 			= 'registrationForm';
          	$.ajax({
	          type: 'post',
	          url:BASEURL+"sign-up",
	          data: {full_name:full_name,user_name:user_name,user_email:user_email,mobile_number:mobile_number,password:password,confirm_password:confirm_password,FormType:FormType}, 
	          success: function(result){ 
	          	result 	=	result.trim();
	          	if(result == 'success'){ 
	              var message = 'Thank You For Registering With VBloggers.Please Verify Your Mobile Number.'; 
	              alertMessageModelPopup(message,'Success');
	              setTimeout(function(){ redirectOTP()}, 3000);
	            } 
	            else if(result == 'invalidemail'){
	              var message = 'Email Already Exists, Try Another Or Login.'; 
	              alertMessageModelPopup(message,'Warning');
	            }
	            else if(result == 'invalidphone'){
	              var message = 'Phone Already Exists, Try Another Or Login.'; 
	              alertMessageModelPopup(message,'Warning');
	            } 
	             else if(result == 'wentWrong'){
	              var message = 'Something Went Wrong Please Try Again In Sometime.'; 
	              alertMessageModelPopup(message,'Warning');
	            } 
              }
        });
			return false;
          }
        });
	});

function redirectOTP(){
window.location.href = BASEURL+'otp-verification';
}
</script>