<div class="cd-user-modal">
	<!-- this is the entire modal form, including the background -->
	<div class="cd-user-modal-container">
		<!-- this is the container wrapper -->
		<ul class="cd-switcher">
			<li><a href="#0" onclick="makeClearSignIn()">Sign in</a></li>
			<li><a href="#0" onclick="makeClearAccount()">New account</a></li>
		</ul>

		<div id="cd-login">
			<!-- log in form -->
			<form class="cd-form">
				<p class="fieldset">
					<label class="image-replace cd-phone" for="login_phone">Phone</label>
					<input class="full-width has-padding has-border" id="login_phone"
						name="login_phone" type="text" placeholder="Phone" maxlength="10" />
					<span id="err_login_phone"></span>
				</p>

				<p class="fieldset">
					<label class="image-replace cd-password" for="login_password">Password</label>
					<input class="full-width has-padding has-border"
						id="login_password" name="login_password" type="text"
						placeholder="Password" maxlength="6" /> <a href="#0"
						class="hide-password">Hide</a> <span id="err_login_password"></span>
				</p>
				<p class="fieldset">
					<input class="full-width" type="button" name="do_login"
						id="do_login" value="Login" onclick="doLogin()" />
				</p>
			</form>

			<p class="cd-form-bottom-message">
				<a href="#0" onclick="makeActive()">Forgot your password?</a>
			</p>
			<!-- <a href="#0" class="cd-close-form">Close</a> -->
		</div>
		<!-- cd-login -->

		<div id="cd-signup">
			<div id="account_success"></div>
			<!-- sign up form -->
			<form class="cd-form">
				<p class="fieldset">
					<label class="image-replace cd-username" for="fullname">Fullname</label>
					<input class="full-width has-padding has-border" id="fullname"
						name="fullname" type="text" placeholder="Fullname" maxlength="100"
						autocomplete="off" /> <span id="err_fullname"></span>
				</p>

				<p class="fieldset">
					<label class="image-replace cd-email" for="email">Email</label> <input
						class="full-width has-padding has-border" type="text" id="email"
						name="email" placeholder="E-mail" maxlength="40"
						autocomplete="off" /> <span id="err_email"></span>
				</p>
				<p class="fieldset">
					<label class="image-replace cd-phone" for="phone">Phone</label> <input
						class="full-width has-padding has-border" id="phone" name="phone"
						type="text" placeholder="Phone" maxlength="10" autocomplete="off" />
					<span id="err_phone"></span>
				</p>
				<p class="fieldset">
					<label class="image-replace cd-password" for="password">Password</label>
					<input class="full-width has-padding has-border" id="password"
						name="password" type="text" placeholder="Password" maxlength="6"
						autocomplete="off" /> <a href="#0" class="hide-password">Hide</a>
					<span id="err_password"></span>
				</p>

				<p class="fieldset">
					<input type="checkbox" id="agree" name="agree" /> <label
						for="accept-terms">I agree to the <a
						href="<?php echo Yii::getAlias('@fweb').'/terms-n-conditions'; ?>"
						target="_blank">terms and condition</a>
					</label> <span id="err_agree"></span>
				</p>

				<p class="fieldset">
					<input class="full-width has-padding" type="button"
						name="create_account" id="create_account" value="Register"
						onclick="createAccount()" />
				</p>
			</form>

			<!-- <a href="#0" class="cd-close-form">Close</a> -->
		</div>
		<!-- cd-signup -->

		<div id="cd-reset-password">
			<!-- reset password form -->
			<p class="cd-form-message">Lost your password? Please enter your
				email address. You will receive a link to create a new password.</p>

			<form class="cd-form">
				<div id="fp_message"></div>
				<p class="fieldset">
					<label class="image-replace cd-phone" for="fp_phone">Phone</label>
					<input class="full-width has-padding has-border" id="fp_phone"
						name="fp_phone" type="text" placeholder="Phone" maxlength="10"
						autocomplete="off" /> <span id="err_fp_phone"></span>
				</p>
				<input type="hidden" name="fp_customer_id" id="fp_customer_id"
					value="" />
				<p class="fieldset">
					<label class="image-replace cd-phone" for="fp_otp">OTP</label> <input
						class="full-width has-padding has-border" id="fp_otp"
						name="fp_otp" type="text" placeholder="OTP" maxlength="6" /> <span
						id="err_fp_otp"></span>
				</p>
				<p class="fieldset">
					<label class="image-replace cd-phone" for="fp_new_password">New
						Password</label> <input class="full-width has-padding has-border"
						id="fp_new_password" name="fp_new_password" type="password"
						placeholder="New Password" maxlength="6" /> <span
						id="err_fp_new_password"></span>
				</p>
				<p class="fieldset">
					<label class="image-replace cd-phone" for="fp_confirm_password">Confirm
						Password</label> <input class="full-width has-padding has-border"
						id="fp_confirm_password" name="fp_confirm_password"
						type="password" placeholder="Confirm Password" maxlength="6" /> <span
						id="err_fp_confirm_password"></span>
				</p>
				<p class="fieldset">
					<input class="full-width has-padding" type="button" name="get_otp"
						id="get_otp" value="Get OTP" onclick="generateOTP()" /> <input
						class="full-width has-padding" type="button"
						name="change_password" id="change_password"
						value="Change Password" onclick="changePassword()" />
				</p>
			</form>

			<p class="cd-form-bottom-message">
				<a href="#0">Back to log-in</a>
			</p>
		</div>
		<!-- cd-reset-password -->
		<a href="#0" class="cd-close-form">Close</a>
	</div>
	<!-- cd-user-modal-container -->
</div>
<!-- cd-user-modal -->

<script type="text/javascript">
 function createAccount(){
	var objAccount = {};
	objAccount = {
       fullname : $("#fullname").val(),
       email : $("#email").val(),
       phone : $("#phone").val(),
       password : $("#password").val(),
       agree : $('#agree').is(":checked"),
       status : 'active',
			};
	$.post('<?php echo Yii::getAlias('@fweb').'/customer/customer/create-account';?>',objAccount,function(response){
		makeEmpty();
		var response = $.parseJSON(response);
        if(response.hasOwnProperty('errors')){
            //Fullname
      	  if(undefined != response.errors.fullname && response.errors.fullname.length > 0){
      		   $("#err_fullname").html(response.errors.fullname[0]);
      		   }
      	//Email
      	  if(undefined != response.errors.email && response.errors.email.length > 0){
          	  
      		   $("#err_email").html(response.errors.email[0]);
      		   }
      	//Phone
      	  if(undefined != response.errors.phone && response.errors.phone.length > 0){
      		   $("#err_phone").html(response.errors.phone[0]);
      		   }
      	 //Password
      	  if(undefined != response.errors.password && response.errors.password.length > 0){
      		   $("#err_password").html(response.errors.password[0]);
      		   }
      	//Agree
      	  if(undefined != response.errors.agree && response.errors.agree.length > 0){
      		   $("#err_agree").html(response.errors.agree[0]);
      		   }
      	
      	
 		   return false;
            }else{
	            makeFieldsEmpty();
              $("#account_success").html(response.message);
              return true;         
                }
		}); 
 }

 function makeEmpty(){
	 $("#err_fullname").html("");
	 $("#err_email").html("");
	 $("#err_phone").html("");
	 $("#err_password").html("");
	 $("#err_agree").html("");
	 $("#account_success").html("");
	 $("#err_login_phone").html("");
	 $("#err_login_password").html("");
	 $("#err_fp_phone").html("");
	 $("#fp_message").html("");
	 $("#err_fp_otp").html("");
	 $("#err_fp_new_password").html("");
	 $("#err_fp_confirm_password").html("");
	 return true;
	 }
 
 function makeFieldsEmpty(){
	 $("#fullname").val("");
	 $("#email").val("");
	 $("#phone").val("");
	 $("#password").val("");
	 $('#agree').prop('checked', false);
	 $("#login_phone").val("");
	 $("#login_password").val("");
	 $("#fp_phone").val("");
	 $("#fp_otp").val("");
	 $("#fp_new_password").val("");
	 $("#fp_confirm_password").val("");
	 return true;
	 }

 function doLogin(){
	 var objLogin = {};
	 objLogin = {
           phone : $("#login_phone").val(),
           password : $("#login_password").val() 
			 };
	 $.post('<?php echo Yii::getAlias('@fweb').'/customer/customer/do-login'; ?>',objLogin,function(response){
		 makeEmpty();
		 var response = $.parseJSON(response);
	        if(response.hasOwnProperty('errors')){
	      	//Phone
	      	  if(undefined != response.errors.phone && response.errors.phone.length > 0){
	      		   $("#err_login_phone").html(response.errors.phone[0]);
	      		   }
	      	 //Password
	      	  if(undefined != response.errors.password && response.errors.password.length > 0){
	      		   $("#err_login_password").html(response.errors.password[0]);
	      		   }
     		   return false;
	            }else{
	            	makeFieldsEmpty();
	            	window.location.href="<?php echo Yii::getAlias('@fweb').'/home'; ?>";
	              return true;         
	                }
		 });
 }

 function makeClearSignIn(){
	 makeEmpty();
	 makeFieldsEmpty();
return true;
	 }

 function makeClearAccount(){
	 makeEmpty();
	 makeFieldsEmpty();
       return true;
	 }

 function makeActive(){
	 $("#fp_otp").hide();
	 $("#fp_new_password").hide();
	 $("#fp_confirm_password").hide();
	 $("#change_password").hide();
	 return true;
 }

 function generateOTP(){
	 var objOTP = {};
	 objOTP = {
           phone : $("#fp_phone").val(),
			 };
	 $.post('<?php echo Yii::getAlias('@fweb').'/customer/customer/generate-otp'; ?>',objOTP,function(response){
		 makeEmpty();
		 var response = $.parseJSON(response);
	        if(response.hasOwnProperty('errors')){
	      	//Phone
	      	  if(undefined != response.errors.phone && response.errors.phone.length > 0){
	      		   $("#err_fp_phone").html(response.errors.phone[0]);
	      		   }
     		   return false;
	            }else{
	            	makeFieldsEmpty();
	            	$("#fp_message").html(response.message);
	            	$("#fp_customer_id").val(response.customer_id);
	            	setTimeout(makeIt,3000);
	              return true;         
	                }
		 });
 }

 function makeIt(){
	 $("#fp_phone").hide();
	 $("#get_otp").hide();
	 $("#fp_message").html("");
	 $("#fp_otp").show();
	 $("#fp_new_password").show();
	 $("#fp_confirm_password").show();
	 $("#change_password").show();
  return true;
	 }

 function changePassword(){
	   var objPassword = {};
	   objPassword = {
			   id : $("#fp_customer_id").val(),
			   new_password : $("#fp_new_password").val(),
			   confirm_password : $("#fp_confirm_password").val(),
			   otp : $("#fp_otp").val()
			   };
	   $.post('<?php echo Yii::getAlias('@fweb').'/customer/customer/change-password'; ?>',objPassword,function(response){
		   makeEmpty();
		   var response = $.parseJSON(response);
	        if(response.hasOwnProperty('errors')){
	      	//OTP
	      	  if(undefined != response.errors.otp && response.errors.otp.length > 0){
	      		   $("#err_fp_otp").html(response.errors.otp[0]);
	      		   }
	      	//New Password
	      	  if(undefined != response.errors.new_password && response.errors.new_password.length > 0){
	      		   $("#err_fp_new_password").html(response.errors.new_password[0]);
	      		   }
	      	//Confirm Password
	      	  if(undefined != response.errors.confirm_password && response.errors.confirm_password.length > 0){
	      		   $("#err_fp_confirm_password").html(response.errors.confirm_password[0]);
	      		   }
    		   return false;
	            }else{
	            	makeFieldsEmpty();
	            	$("#fp_message").html(response.message);
	              return true;         
	                }
		   });
       return true;
	 }
</script>