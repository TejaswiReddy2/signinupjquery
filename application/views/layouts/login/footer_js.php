<script src="{ASSET_INCLUDE_URL}vendor/jquery/jquery.min.js"></script>
<script src="{ASSET_INCLUDE_URL}js/main.js"></script>
<script src="{ASSET_INCLUDE_URL}js/teju.js"></script>
<script src="{ASSET_INCLUDE_URL}js/jquery.validate.js"></script>
<div class="alert-icon shadow-inner alertbox">
    <div class="alert alert-warning alert-success-style3 alert-st-bg2">
        <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
            <span class="icon-sc-cl" aria-hidden="true">×</span>
        </button>
        <i class="fa fa-exclamation-triangle edu-warning-danger admin-check-pro admin-check-pro-clr2" aria-hidden="true"></i>
        <p>Loading...</p>
    </div>
    <div class="alert alert-danger alert-mg-b alert-success-style4 alert-st-bg3">
        <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
            <span class="icon-sc-cl" aria-hidden="true">×</span>
        </button>
        <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-clr3" aria-hidden="true"></i>
        <p>Loading...</p>
    </div>
    <div class="alert alert-success alert-success-style1 alert-st-bg">
        <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
            <span class="icon-sc-cl" aria-hidden="true">×</span>
        </button>
        <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-clr" aria-hidden="true"></i>
        <p>Loading...</p>
    </div>
    <div class="alert alert-info alert-success-style2 alert-st-bg1">
        <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
            <span class="icon-sc-cl" aria-hidden="true">×</span>
        </button>
        <i class="fa fa-info-circle edu-inform admin-check-pro admin-check-pro-clr1" aria-hidden="true"></i>
        <p>Loading...</p>
    </div>
</div>
<script type="text/javascript">
    <?php if($this->session->flashdata('alert_warning')):?>
      alertMessageModelPopup('<?php echo $this->session->flashdata('alert_warning'); ?>','Warning');
    <?php elseif($this->session->flashdata('alert_error')): ?>
      alertMessageModelPopup('<?php echo $this->session->flashdata('alert_error'); ?>','Error');
    <?php elseif($this->session->flashdata('alert_success')): ?>
      alertMessageModelPopup('<?php echo $this->session->flashdata('alert_success'); ?>','Success');
    <?php elseif($this->session->flashdata('alert_info')): ?>
      alertMessageModelPopup('<?php echo $this->session->flashdata('alert_success'); ?>','Info');
    <?php endif; ?>
    ///////////     ALERT MESSAGE MODEL     ///////////////////
    function alertMessageModelPopup(message,type){  
      $(".alert-icon.alertbox").addClass("active"); 
      $(".alert-icon.alertbox").children('.alert').css("display","none");
      if(type == 'Warning'){
        $(".alert-icon.alertbox").children('.alert-warning').css("display","block");
      $(".alert-icon.alertbox").children('.alert-warning').children('p').html(message);
      } else if(type == 'Error') {
        $(".alert-icon.alertbox").children('.alert-danger').css("display","block");
      $(".alert-icon.alertbox").children('.alert-danger').children('p').html(message);
      } else if(type == 'Success') {
        $(".alert-icon.alertbox").children('.alert-success').css("display","block");
      $(".alert-icon.alertbox").children('.alert-success').children('p').html(message);
      } else if(type == 'Info') {
        $(".alert-icon.alertbox").children('.alert-info').css("display","block");
      $(".alert-icon.alertbox").children('.alert-info').children('p').html(message);
      }
      setTimeout(AlertMessageModelPopupTimedOut, 5000);
    }
    function AlertMessageModelPopupTimedOut() { 
      $(".alert-icon.alertbox").removeClass("active");
    }
</script>
<script type="text/javascript">
  $(function(){
    <?php if($error): ?>
      alertMessageModelPopup('<?php echo $error; ?>','Warning');
    <?php endif; ?>
  });
</script>
<script>
// Snackbar for user status switcher
$('#snackbar-user-status label').click(function() { 
  Snackbar.show({
    text: 'Your status has been changed!',
    pos: 'bottom-center',
    showAction: false,
    actionText: "Dismiss",
    duration: 3000,
    textColor: '#fff',
    backgroundColor: '#383838'
  }); 
}); 
</script>


<!-- Google Autocomplete -->
<script>
  function initAutocomplete() {
     var options = {
      types: ['(cities)'],
      // componentRestrictions: {country: "us"}
     };

     var input = document.getElementById('autocomplete-input');
     var autocomplete = new google.maps.places.Autocomplete(input, options);
  }

  // Autocomplete adjustment for homepage
  if ($('.intro-banner-search-form')[0]) {
      setTimeout(function(){ 
          $(".pac-container").prependTo(".intro-search-field.with-autocomplete");
      }, 300);
  }

</script>
<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places&callback=initAutocomplete"></script>
