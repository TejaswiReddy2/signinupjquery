<section class="sign-in">
    <div class="container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src="{ASSET_INCLUDE_URL}images/signin-image.jpg" alt="sing up image"></figure>
                <a href="{BASE_URL}sign-up" class="signup-image-link">Create an account</a>
            </div>

            <div class="signin-form">
                <h2 class="form-title">Forgot Password</h2>
                <h4 class="form-title">Enter Your Mobile Number To Get Security Code</h4>
                <form name="loginForm" id="currentPageForm" class="loginForm dez-form p-b30" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                      <input required autocomplete="off" type="number" name="mobile_number" id="mobile_number" class="form-control mobile_number" value="<?php if(set_value('mobile_number')): echo set_value('mobile_number');endif;?>" placeholder="Enter Your Mobile Number"/>
                      <?php if(form_error('mobile_number')):?>
                        <p for="mobile_number" class="error"><?php echo form_error('mobile_number');?></p>
                      <?php endif;?>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="saveChanges" id="saveChanges" class="form-submit" value="Get OTP"/>
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
            mobile_number:{minlength:10 , maxlength:12}
          },
          messages:{
            mobile_number:{required:"Mobile Number Is Required"}
          },
          submitHandler:function(form){
            var mobile_number   = $('#mobile_number').val();
            $.ajax({
                url:BASEURL+"forgot-password",
                type:'post',
                data:{mobile_number:mobile_number},
                success:function(result){
           		  result 	= result.trim();
                  if(result == 'success'){
                    var message = "OTP Sent To You Registered Mobile Number";
                    alertMessageModelPopup(message,'Success');
                    setTimeout(function(){ redirectforgot()}, 1000);
                  }
                   else if(result == 'noaccount'){
	                  var message = "There Is No Account With This Number Please Register.";
	                  alertMessageModelPopup(message,'Warning');
	                  return false;
                  }
                  else if(result == 'blocked'){ 
                      var message = 'Your Account Is Blocked,Plesae Contact Administrator.'; 
                      alertMessageModelPopup(message,'Warning');
                      setTimeout(function(){ redirecthome()}, 2000);
                  } 
                }
            });
          }
       });
  });

function redirectforgot(){window.location.href=BASEURL+'reset-password';}

function redirecthome(){window.location.href = BASEURL;}

</script>