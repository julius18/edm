<?php 
session_start();
header("Cache-Control: no-cache");
header("Pragma: no-cache"); 
// echo 'test';
// echo $_SESSION['id'];
// if (!isset($_SESSION['id'])){
// 	header("Location: ". get_site_url() ."/member-login/"  );
// }

// print_r( $_SESSION );
// exit;


/*
** Template Name: Member Activate
*/
	
Pantheon_Sessions();

if (isset($_GET['userID']) && $_GET['userID'] != '') {
	$_SESSION['id'] = $_GET['userID'];
	ehader("Location: ". get_site_url() ."/my-account/"  );
} else {
	if (!isset($_SESSION['id'])){
		header("Location: ". get_site_url() ."/member-login/"  );
	}
}




get_header(); ?>

	<?php
		$thumb_id = get_post_thumbnail_id();
		$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
		$thumb_url = $thumb_url_array[0];
	?>


<?php 
	error_reporting(0);
	get_header();

	$curl = curl_init('https://karmawarehouse.izenoondemand.com/production/api/sugarapi/getKCUserDetails.php?id='. $_SESSION['id'] );
	// curl_setopt($curl, CURLOPT_HTTPHEADER, array("api_key: " . $api_access[$base_url]['api_key']));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
	curl_setopt($curl, CURLOPT_AUTOREFERER, true); 
	curl_setopt($curl, CURLOPT_VERBOSE, 1);  
	curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
	curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	"content-type: application/json;charset=UTF-8"
	));
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);

	$curl_response = curl_exec($curl);
	$result = explode("\r\n\r\n", $curl_response, 2);
	$curl_response = $result[1];

	$result = json_decode($curl_response, true);	
	$userDetails = $result['records'][0];


	
    $userDetails['homePhoneCode'] = '+'.$userDetails['homePhoneCode'];
	$userDetails['mobile_country_c'] = '+'.$userDetails['mobile_country_c'];
	
	// print_r($result);
	//print_r($userDetails);

	$userDetails['billing_address_country'] = strtoupper($userDetails['billing_address_country']);

	$contact = $userDetails['contact_preference_c'][0];
	$contact_ex = explode(',', $contact);


	// $contact_email = $contact_ex[0];
	$contact_phone2 = $a;
	$contact_sms = $contact_ex[1];
	// print_r($contact_ex);

	// print_r($contact_ex);
	// print_r($contact_phone);
	$homephone = $userDetails['phone_alternate'];
	$homephone_ex = explode(' ', $homephone);

	$homecode = '+'.$homephone_ex[0];
	$homephonenumber = $homephone_ex[1];



	$dob = $userDetails['birthdate_c'];
	$dob_ex = explode('-', $dob);
	
	// print_r($dob_ex);

	$dob_d = $dob_ex[2];
	$dob_m = $dob_ex[1];
	$dob_y = $dob_ex[0];

	// echo 'dateOfBirth: '. $userDetails['dateOfBirth'] ."\n";
	// echo 'dob: '. $dob ."\n";
	// echo 'dob_d: '. $dob_d ."\n";
	// echo 'dob_y: '. $dob_y ."\n";
?>


	<!-- main page content -->

		<!-- page top background wrapper -->
	<section id="PBebgWrap" class="page-top-bg-banner bg-fixed section rltive" style="background-image: url('<?php echo $thumb_url; ?>" data-stellar-background-ratio="0.1">
		<div class="page-bg-entry flex-full-centered">
		
			<h1 class="fh1"><?php the_title(); ?></h1>
			<h2><?php echo $_POST['id']; ?></h2>
			
		</div>
		<div class="overlay"></div>
	</section>
	<!-- page top background wrapper -->
	
	<link rel="stylesheet" href="https://intl-tel-input.com/node_modules/intl-tel-input/build/css/intlTelInput.css?1501227254404">
	<section class="section contact-headline">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 contact-entry">
					<?php
						while ( have_posts() ) : the_post();
							the_content();
						endwhile;
					?>
				</div>
			</div>
		</div>
	</section>

		
	    <!--BEGIN MESSAGE BOX-->
		<style type="text/css">
		
		#memberShip{
			padding: 7px;
			font-size: 18px;
			color: #8a6f47;
			float: left;
			border: 1px solid #8a6f47;
			margin-bottom: 25px;
			margin-left: 6px;
		}

		#logout{
			float: right;
		}

	    /**
	    * Popups
	    * --------------------------------------------------
		*/
	    .popup-container {
	    position: fixed;
	    top: 0;
	    left: 0;
	    bottom: 0;
	    right: 0;
	    background: rgba(0,0,0,.5);
	    display: -webkit-box;
	    display: -webkit-flex;
	    display: -moz-box;
	    display: -moz-flex;
	    display: -ms-flexbox;
	    display: flex;
	    -webkit-box-pack: center;
	    -ms-flex-pack: center;
	    -webkit-justify-content: center;
	    -moz-justify-content: center;
	    justify-content: center;
	    -webkit-box-align: center;
	    -ms-flex-align: center;
	    -webkit-align-items: center;
	    -moz-align-items: center;
	    align-items: center;
	    z-index: 12;
	    visibility: hidden; }
	    .popup-container.popup-showing {
	    visibility: visible; }
	    .popup-container.popup-hidden .popup {
	    -webkit-animation-name: scaleOut;
	    animation-name: scaleOut;
	    -webkit-animation-duration: 0.1s;
	    animation-duration: 0.1s;
	    -webkit-animation-timing-function: ease-in-out;
	    animation-timing-function: ease-in-out;
	    -webkit-animation-fill-mode: both;
	    animation-fill-mode: both; }
	    .popup-container.active .popup {
	    -webkit-animation-name: superScaleIn;
	    animation-name: superScaleIn;
	    -webkit-animation-duration: 0.2s;
	    animation-duration: 0.2s;
	    -webkit-animation-timing-function: ease-in-out;
	    animation-timing-function: ease-in-out;
	    -webkit-animation-fill-mode: both;
	    animation-fill-mode: both; }
	    .popup-container .popup {
	    width: 250px;
	    max-width: 100%;
	    max-height: 90%;
	    border-radius: 0px;
	    background-color: rgba(255, 255, 255, 0.9);
	    display: -webkit-box;
	    display: -webkit-flex;
	    display: -moz-box;
	    display: -moz-flex;
	    display: -ms-flexbox;
	    display: flex;
	    -webkit-box-direction: normal;
	    -webkit-box-orient: vertical;
	    -webkit-flex-direction: column;
	    -moz-flex-direction: column;
	    -ms-flex-direction: column;
	    flex-direction: column; }
	    .popup-container input,
	    .popup-container textarea {
	    width: 100%; }
	    
	    .popup-head {
	    display: none;
	    padding: 15px 10px;
	    border-bottom: 1px solid #eee;
	    text-align: center; }
	    
	    /*.popup-title {
	    margin: 0;
	    padding: 0;
	    font-size: 12px; }*/
	    
	    .popup-sub-title {
	    margin: 5px 0 0 0;
	    padding: 0;
	    font-weight: normal;
	    font-size: 11px; }
	    
	    .popup-body {
	    padding: 10px;
	    padding-top: 30px;
	    text-align: center;
	    overflow: auto;
	    text-align: center;
	    }
	    
	    .popup-buttons {
	    display: -webkit-box;
	    display: -webkit-flex;
	    display: -moz-box;
	    display: -moz-flex;
	    display: -ms-flexbox;
	    display: flex;
	    -webkit-box-direction: normal;
	    -webkit-box-orient: horizontal;
	    -webkit-flex-direction: row;
	    -moz-flex-direction: row;
	    -ms-flex-direction: row;
	    flex-direction: row;
	    padding: 10px;
	    min-height: 65px; }
	    .popup-buttons .button {
	    -webkit-box-flex: 1;
	    -webkit-flex: 1;
	    -moz-box-flex: 1;
	    -moz-flex: 1;
	    -ms-flex: 1;
	    flex: 1;
	    display: block;
	    min-height: 45px;
	    border-radius: 2px;
	    line-height: 20px;
	    margin-right: 5px; }
	    .popup-buttons .button:last-child {
	    margin-right: 0px; }
	    
	    .popup-open {
	    pointer-events: none; }
	    .popup-open.modal-open .modal {
	    pointer-events: none; }
	    .popup-open .popup-backdrop, .popup-open .popup {
	    pointer-events: auto; }
	    
	    .button:after {
	    position: absolute;
	    top: -6px;
	    right: -6px;
	    bottom: -6px;
	    left: -6px;
	    content: ' ';
	    }
	    
	    .button.button-positive {
	    border-color: transparent;
	    background-color: #b3985b;
	    color: #fff;
	    height: 38px;
	    max-width: 150px;
	    border-radius: 20px;
	    margin: auto!important;
	    }			    
	    </style>
	    
	    <div class="popup-container">
	    <div class="popup">
	    <div class="popup-head">
	    <h5 class="popup-title">{{title}}</h5>
	    <!-- ngIf: subTitle -->
	    </div>
	    <div class="popup-body"><span>{{body}}</span></div>
	    <div class="popup-buttons">
	    <!-- ngRepeat: button in buttons -->
	    <button class="button {{btnClass}}">OK</button>
	    <!-- end ngRepeat: button in buttons -->
	    </div>
	    </div>
	    </div>		
	    <!--END MESSAGE BOX-->
	    
	<!-- contact form -->
	<section class="section join-block activate-block">
	<div class="container container-inner">
	
	<?php if ($userDetails['active_c'] == 'No' ) {
		echo '';   							 
	}if ($userDetails['active_c'] == 'Yes') {  ?> 
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-sm-offset-1">
				<div id="memberShip">
					Membership Number: TYR<?php echo $userDetails['membership_id_remap_c'];?>
				</div>
			</div>
		</div>
	<?php } ?> 


	<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-sm-pull-1">
				<div id="logout">
					<a  class="btn bg-gold" href="<?php echo get_template_directory_uri()?>/logout.php" >Logout</a>
				</div>
			</div>
	</div>
	
	
	</div>
		<div class="container container-inner">
			<div class="row">
				<div class="col-xs-12 col-sm-10 col-sm-offset-1 form-join">
					<form id="activateForm" class="form-response" action="<?php echo home_url(); ?>/congratulations/" method="post">
						<div class="row">
							<div class="col-xs-6 col-sm-2">
								<div class="form-group">
									<select id="title" name="title" style="width: 100%;" required>
										<option value="">-Title-</option>
										<option value="Dr"<?php if($userDetails['title_c'] == 'Dr'){ echo ' selected="selected"';} ?>>Dr</option>
										<option value="Mr"<?php if($userDetails['title_c'] == 'Mr'){ echo ' selected="selected"';} ?>>Mr</option>
										<option value="Mrs"<?php if($userDetails['title_c'] == 'Mrs'){ echo ' selected="selected"';} ?>>Mrs</option>
										<option value="Ms"<?php if($userDetails['title_c'] == 'Ms'){ echo ' selected="selected"';} ?>>Ms</option>
										<option value="Miss"<?php if($userDetails['title_c'] == 'Miss'){ echo ' selected="selected"';} ?>>Miss</option>
										<option value="Prof"<?php if($userDetails['title_c'] == 'Prof'){ echo ' selected="selected"';} ?>>Prof</option>
									</select>
								</div>
							</div>						
							<div class="col-xs-12 col-sm-4">
								<div class="form-group">
									<input type="text" class="form-control" id="firstName" placeholder="First Name" name="firstName" value="<?php if ( isset( $userDetails['first_name_kc_c'] ) ) echo $userDetails['first_name_kc_c'];  ?>" required>
									<input type="hidden" class="form-control" id="userID2" name="userID2" value="<?php echo $userDetails['KCId'];?>">
									<input type="hidden" class="form-control" id="userID" name="userID" value="<?php echo $userDetails['id'];?>">
									<input type="hidden" class="form-control" id="active" name="active" value="<?php echo $userDetails['active_c'];?>">									
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="surName" placeholder="Last Name" name="surName" value="<?php if ( isset( $userDetails['last_name_kc_c'] ) ) echo $userDetails['last_name_kc_c'];  ?>" required>
								</div>
							</div>
						</div>

						    <style type="text/css">
						    .intl-tel-input{
						    float: right;
						    width: 100%;
						    }
						    .intl-tel-input li{
						    margin: 0!important;
						    }
						    .intl-tel-input .country-list .divider{
						    min-height: 1px;
						    }
						    *:focus{
						    outline: none;                                            
						    }
						    .phonewrapper,
						    .promoCodeWrapper {
						    position: relative;
						    display: table;
						    width: 100%;
						    }
						    .phoneMsg,
						    .promoCodeMsg {
						    color: red;
						    right: 0;
						    position: absolute;
						    font-size: 11px;
						    border: 0px;
						    bottom: 8px;
						    }
						    </style>	
						    
						    <div class="row">
						    <div class="col-xs-12 col-sm-6">
						    <div class="form-group">
						    <input type="email" class="form-control" id="emailID" placeholder="Email" name="emailID" value="<?php if ( isset( $userDetails['email1'] ) ) echo $userDetails['email1'];  ?>" required>
						    </div>
						    </div>
						    <div class="col-xs-12 col-sm-6">
						    <div class="form-group">
						    
						    <div class="phonewrapper">
						    <div class="phoneMsg"></div>
						    <input type="text" class="form-control phonenumber" id="mobileNumber" name="mobileNumber" placeholder="Mobile Number" value="<?php if ( isset( $userDetails['mobile_c'] ) ) echo $userDetails['mobile_c'];  ?>" required>
						    
						    <input type="hidden" class="code" id="mobileCode" name="mobileCode" value="<?php if ( isset( $userDetails['mobile_country_c'] ) ) echo $userDetails['mobile_country_c'];  ?>">
						    <input type="hidden" class="complete" id="mobileNumber_complete" name="mobileNumber_complete" value="<?php if ( isset( $userDetails['mobile_country_c'] ) ) echo $userDetails['mobile_country_c'];  ?><?php if ( isset( $userDetails['mobile_c'] ) ) echo $userDetails['mobile_c'];  ?>">
						    </div>
						    
						    </div>
						    </div>
						    </div>
						    
						<div class="row">
						    <div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<div class="promoCodeWrapper">
									<div class="promoCodeMsg"></div>							
										<input class="form-control" id="promoCode" type="text" placeholder="Promo Code" name="promoCode" value="<?php if (isset($userDetails['promoCode'])) {
											echo $userDetails['promoCode'];    
										}if ($userDetails['promoCode'] == '') {  
											echo 'TYRRELLS ';
										} ?>" >
									</div>
								</div>
						    </div>
						    
						    <div class="col-xs-12 col-sm-6">
								<div class="form-group">
								
									<div class="phonewrapper">
										<div class="phoneMsg">
										</div>
										<input type="text" class="form-control phonenumber" id="homePhoneNumber" name="homePhoneNumber" placeholder="Home Number" value="<?php if ( isset( $homephonenumber) ) echo $homephonenumber; ?>">
										
										<input type="hidden" class="code" id="homePhoneCode" name="homePhoneCode" value="<?php if ( isset( $homecode ) ) echo $homecode; ?>">

										<input type="hidden" class="complete" id="homePhoneNumber_complete" name="phone_alternate" value="<?php if ( isset( $homecode ) ) echo $homecode; ?><?php if ( isset( $homephonenumber ) ) echo $homephonenumber ?>">
									</div>									
								</div>
							</div>							
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="streetLine1" name="streetLine1" placeholder="Street Line 1" value="<?php if ( isset( $userDetails['billing_address_street'] ) ) echo $userDetails['billing_address_street'];  ?>" required>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="streetLine2" name="streetLine2" placeholder="Street Line 2" value="<?php if ( isset( $userDetails['billing_street_address2_c'] ) ) echo $userDetails['billing_street_address2_c'];  ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="city" name="city" placeholder="City" required value="<?php if ( isset( $userDetails['billing_address_city'] ) ) echo $userDetails['billing_address_city'];  ?>">
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="state" name="state" placeholder="State" required value="<?php if ( isset( $userDetails['billing_address_state'] ) ) echo $userDetails['billing_address_state'];  ?>">
								</div>
							</div>
						</div>
						
						<div class="row">
							
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<select class="form-control" id="country" name="country" required>
									 
									
									<?php getCountryList($userDetails['billing_address_country']); ?>
									</select>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="postCode" name="postCode" placeholder="Post Code" required value="<?php if ( isset( $userDetails['billing_address_postalcode'] ) ) echo $userDetails['billing_address_postalcode'];  ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<div class="form-group">
								<label>Marital Status</label>
									<div class="col-xs-12 col-sm-4">
										<div class="form-group">
											<select id="marital" class="form-control" name="maritalStatus" required>
												<option value="<?php if (isset($userDetails['marital_status_c'])) {
													echo $userDetails['marital_status_c'];    
												}if ($userDetails['marital_status_c'] == '') {  
													echo '-- Select --';
												} ?>" selected>
												<?php if (isset($userDetails['marital_status_c'])) {
													echo $userDetails['marital_status_c'];    
												}if ($userDetails['marital_status_c'] == '') {  
													echo '-- Select --';
												} ?> 
											   </option>
												<option value="Defacto">Defacto</option>
												<option value="Single">Single</option>
												<option value="Married">Married</option>
												<option value="Divorced">Divorced</option>
												<option value="Widowed">Widowed</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<div class="form-group">
									<label>Date of Birth</label>
									<div class="col-xs-12 col-sm-4">
										<div class="form-group">
											<select class="form-control" id="birthOfDate" name="birthOfDate" required>
												<option value="">- Day -</option>
												<?php getDayList($dob_d); ?>
											</select>
										</div>
									</div>
									<div class="col-xs-12 col-sm-4">
										<div class="form-group">
											<select class="form-control" id="birthOfMonth" name="birthOfMonth" required>
												<option value="">- Month -</option>
												<option value="01"<?php if($dob_m == '01'){ echo ' selected="selected"';} ?>>January</option>
												<option value="02"<?php if($dob_m == '02'){ echo ' selected="selected"';} ?>>February</option>
												<option value="03"<?php if($dob_m == '03'){ echo ' selected="selected"';} ?>>March</option>
												<option value="04"<?php if($dob_m == '04'){ echo ' selected="selected"';} ?>>April</option>
												<option value="05"<?php if($dob_m == '05'){ echo ' selected="selected"';} ?>>May</option>
												<option value="06"<?php if($dob_m == '06'){ echo ' selected="selected"';} ?>>June</option>
												<option value="07"<?php if($dob_m == '07'){ echo ' selected="selected"';} ?>>July</option>
												<option value="08"<?php if($dob_m == '08'){ echo ' selected="selected"';} ?>>August</option>
												<option value="09"<?php if($dob_m == '09'){ echo ' selected="selected"';} ?>>September</option>
												<option value="10"<?php if($dob_m == '10'){ echo ' selected="selected"';} ?>>October</option>
												<option value="11"<?php if($dob_m == '11'){ echo ' selected="selected"';} ?>>November</option>
												<option value="12"<?php if($dob_m == '12'){ echo ' selected="selected"';} ?>>December</option>
											</select>
										</div>
									</div>
									<div class="col-xs-12 col-sm-4">
										<div class="form-group"><?php //echo 'dob_y: '. $dob_y; ?>
											<select class="form-control" id="birthOfYear" name="birthOfYear" required>
												<option value="">- Year -</option>
									 			<?php getYearList($dob_y); ?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="dateOfBirth" id="dateOfBirth" value="<?php if ( isset( $userDetails['birthdate_c'] ) ) echo $userDetails['birthdate_c']; ?>" />
						
						<div class="row">
						    <div class="col-xs-12">
						   		 <div class="form-group flex">
									<div class="checkbox">
											<span style="font-size:12px;">*Please omit the leading 0 (zero) digit when entering your number.</span><br><br>
											<?php if ($userDetails['active_c'] == 'No' ) {
												echo "<label><input id='agreetyrrells' type='checkbox' name='iagree' value='iagreetyrrellskc' checked='' >I agree to the Tyrrells Karma Club <a href='/tyrrells/terms-conditions/' target='_blank'>Terms & Conditions.</a></label>";    
											}if ($userDetails['active_c'] == 'Yes') {  
												echo '';
												echo "<input style='height:0;width:0;overflow:hidden;visibility: hidden;' id='agreetyrrells' type='checkbox' name='iagree' value='iagree' checked='' >"; 
											} ?> 
										
									</div>
						   		 </div>
						    </div>
						</div> 

						<?php if ($userDetails['active_c'] == 'Yes' ) { ?>

						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<label>Communication Preferences</label>
								</div>
								<div class="form-group flex">



									<div class="checkbox">
										<?php 
											if (in_array("Email", $contact_ex)){
													echo "<label><input type='checkbox' name='comEmail' value='Email' checked>Email</label>";
											} else {
													echo "<label><input type='checkbox' name='comEmail' value='Email'>Email</label>";
											}																
										?>										
									</div>
									<div class="checkbox">
										<?php 
											if (in_array("Phone", $contact_ex)){
													echo "<label><input type='checkbox' name='comCall' value='Phone' checked>Phone</label>";
											} else {
													echo "<label><input type='checkbox' name='comCall' value='Phone'>Phone</label>";
											}																
										?>											
									</div>
									<div class="checkbox">
										<?php 
											if (in_array("Post", $contact_ex)){
												echo "<label><input type='checkbox' name='comPost' value='Post' checked>Post</label>";
											} else {
													echo "<label><input type='checkbox' name='comPost' value='Post'>Post</label>";
											}																
										?>
										
									</div>
									
								</div>
							</div>
						</div>

						<?php }  if ($userDetails['active_c'] == 'No') { ?>

						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<label style="margin-left: 12px;">Tick here if you would like to hear about other products and services from Karma Group:</label>
								</div>
								<div class="form-group flex">

									<div class="checkbox">
										<?php 
											if (in_array("EmailKG", $contact_ex)){
													echo "<label><input type='checkbox' name='comEmailKG' value='EmailKG' checked>Email</label>";
											} else {
													echo "<label><input type='checkbox' name='comEmailKG' value='EmailKG'>Email</label>";
											}																
										?>										
									</div>
									<div class="checkbox">
										<?php 
											if (in_array("PhoneKG", $contact_ex)){
													echo "<label><input type='checkbox' name='comCallKG' value='PhoneKG' checked>Phone</label>";
											} else {
													echo "<label><input type='checkbox' name='comCallKG' value='PhoneKG'>Phone</label>";
											}																
										?>											
									</div>
									<div class="checkbox">
										<?php 
											if (in_array("PostKG", $contact_ex)){
												echo "<label><input type='checkbox' name='comPostKG' value='PostKG' checked>Post</label>";
											} else {
													echo "<label><input type='checkbox' name='comPostKG' value='PostKG'>Post</label>";
											}																
										?>
										
									</div>
									
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<label style="margin-left: 12px;">Tick here if you are happy to hear from Karma Group’s carefully selected 3rd parties:</label>
								</div>
								<div class="form-group flex">



									<div class="checkbox">
										<?php 
											if (in_array("Email3rd", $contact_ex)){
													echo "<label><input type='checkbox' name='comEmail3rd' value='Email3rd' checked>Email</label>";
											} else {
													echo "<label><input type='checkbox' name='comEmail3rd' value='Email3rd'>Email</label>";
											}																
										?>										
									</div>
									<div class="checkbox">
										<?php 
											if (in_array("Phone3rd", $contact_ex)){
													echo "<label><input type='checkbox' name='comCall3rd' value='Phone3rd' checked>Phone</label>";
											} else {
													echo "<label><input type='checkbox' name='comCall3rd' value='Phone3rd'>Phone</label>";
											}																
										?>											
									</div>
									<div class="checkbox">
										<?php 
											if (in_array("Post3rd", $contact_ex)){
												echo "<label><input type='checkbox' name='comPost' value='Post3rd' checked>Post</label>";
											} else {
													echo "<label><input type='checkbox' name='comPost' value='Post3rd'>Post</label>";
											}																
										?>
										
									</div>
									
								</div>
							</div>
						</div>

						<?php } ?>

						<div class="row">
							<div class="form-group button-wrap">
								<button type="submit" id="activateFormSubmit" class="btn bg-gold">
								<?php if ($userDetails['active_c'] == 'No' ) {
									echo 'Activate';    
								}if ($userDetails['active_c'] == 'Yes') {  
									echo 'Update';
								} ?> 
								</button>	&nbsp; <span id="loading" style="display: none;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ajax-loader.gif" /></span>
							</div>
						</div>	
					</form>



<form id="form-287" action="" method="post" style="display: none;">
	<input type="hidden" name="key" value="287">
	<input type="hidden" name="uid" value="0">
	<input type="hidden" name="sid" value="0">
	<input type="hidden" name="hosted" value="0">

		<div id="field-1456121973"><label id="field-1456121973-label">Title</label><label id="field-1456121973-description"></label>
		    <input name="field-1456121973" type="text" value="" />
		</div>
		<div id="field-1427865019"><label id="field-1427865019-label">Your Name</label><div><input name="field-1427865019-1" id="field-1427865019-1-text"  type="text" style="width: 160px;"><br><label id="field-1427865019-first-label">Firstname</label></div><div><input name="field-1427865019-2" id="field-1427865019-2-text"  type="text" style="width: 160px;"><br><label id="field-1427865019-last-label">Lastname</label></div></div>
		<div id="field-1458803292"><label id="field-1458803292-label">First name for print</label><label id="field-1458803292-description"></label><input id="field-1458803292-text" type="text" name="field-1458803292" style="width: 169px;"></div>
		<div id="field-1458803320"><label id="field-1458803320-label">Last name for print</label><label id="field-1458803320-description"></label><input id="field-1458803320-text" type="text" name="field-1458803320" style="width: 169px;"></div>
		<div id="field-1456130004"><label id="field-1456130004-label">Email Address<span class="required">*</span></label><label id="field-1456130004-description"></label><input id="field-1456130004-text" type="email" name="field-1456130004" style="width: 169px;" required=""></div>
		<div id="field-1450771166"><label id="field-1450771166-label">Address</label><label id="field-1450771166-description"></label><textarea id="field-1450771166-contents" name="field-1450771166" style="width: 350px;"></textarea></div>
		<div id="field-1456135584"><label id="field-1456135584-label">Address 2</label><label id="field-1456135584-description"></label><textarea id="field-1456135584-contents" name="field-1456135584" style="width: 350px;"></textarea></div>
		<div id="field-1450846616"><label id="field-1450846616-label">City</label><label id="field-1450846616-description"></label><input id="field-1450846616-text" type="text" name="field-1450846616" style="width: 169px;"></div>
		<div id="field-1450771328"><label id="field-1450771328-label">Post Code</label><label id="field-1450771328-description"></label><input id="field-1450771328-text" type="text" name="field-1450771328" style="width: 169px;"></div>
		<div id="field-1450846691"><label id="field-1450846691-label">State</label><label id="field-1450846691-description"></label><input id="field-1450846691-text" type="text" name="field-1450846691" style="width: 169px;"></div>
		

		<input name="field-1450770516" id="field-1450770516-country" value="">
		
		<input name="field-1509527987" id="field-1509527987-choices" value="">
		
		<input id="field-1508485850-text" type="hidden" class="bill-text" name="field-1508485850" placeholder="" value="<?php echo($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']); ?>">
		
		
		<div id="field-1450846557"><label id="field-1450846557-label">Home Phone Number</label><label id="field-1450846557-description"></label><input id="field-1450846557-text" type="text" name="field-1450846557" style="width: 169px;"></div>
		<div id="field-1450771290"><label id="field-1450771290-label">Mobile Phone</label><label id="field-1450771290-description"></label><input id="field-1450771290-text" type="text" name="field-1450771290" style="width: 169px;"></div>
		<div id="field-1427865032"><label id="field-1427865032-label">Email Address<span class="required">*</span></label><label id="field-1427865032-description"></label><input id="field-1427865032-text" type="email" name="field-1427865032" style="width: 162px;" required=""></div>
		<div id="field-1450771524"><label id="field-1450771524-label">Date of Birth</label><label id="field-1450771524-description"></label><input id="field-1450771524-text" type="text" name="field-1450771524" class=" datepicker" style="width: 169px;"></div>
		<div id="field-1451441259"><label id="field-1451441259-label">Promo code</label><label id="field-1451441259-description"></label><input id="field-1451441259-text" type="text" name="field-1451441259" style="width: 169px;"></div>
		<div id="field-1449560763"><label id="field-1449560763-label">Agree</label><label id="field-1449560763-description"></label><div id="field-1449560763-choices"><div><input name="field-1449560763[]" type="checkbox" value="I agree to receive email communications &amp; information from the Karma Club team"><label>I agree to receive email communications &amp; information from the Tyrrell’s Karma Club team</label><br></div></div></div>
		<div id="field-1460429398"><label id="field-1460429398-label">Are you odyssey member?</label><label id="field-1460429398-description"></label><div id="field-1460429398-choices"><div><input name="field-1460429398[]" type="checkbox" value="Yes I am a member"><label>Yes I am a member</label><br></div></div></div>
		<div id="field-1460429713"><label id="field-1460429713-label">Odyssey Number</label><label id="field-1460429713-description"></label><input id="field-1460429713-text" type="text" name="field-1460429713" style="width: 169px;"></div>
		<div id="field-1485246379"><input id="field-1485246379-text" type="hidden" name="field-1485246379" value="Website form"></div>
		<div id="field-1471328255"><input id="field-1471328255-text" type="hidden" name="field-1471328255" value=""></div>
		<div id="field-1427866079"><input id="field-1427866079-text" type="hidden" name="field-1427866079" value="Tyrrell"></div>
		<div id="field-1427866111"><input id="field-1427866111-text" type="hidden" name="field-1427866111" value="Digital"></div>
		<div id="field-1427866217"><input id="field-1427866217-text" type="hidden" name="field-1427866217" value="Web"></div>
		<div id="field-1427866260"><input id="field-1427866260-text" type="hidden" name="field-1427866260" value="All"></div>
		<div id="field-1428569141"><input id="field-1428569141-text" type="hidden" name="field-1428569141" value="Tyrrell"></div>
		<div id="field-1450837999"><input id="field-1450837999-text" type="hidden" name="field-1450837999" value="cfb005bf-ac11-698b-7475-55f90545dadf"></div>
		    <button>Submit</button>

</form>





				</div>
			</div>
		</div>
	</section>
	<!-- contact form -->
	



<script type="text/javascript">
jQuery(document).ready(function($) {  



$('#promoCode').bind('input keyup', function(){
var $this = $(this);
var delay = 500; // 1 seconds delay
var pcode = '';
clearTimeout($this.data('timer'));
$this.data('timer', setTimeout(function(){
$this.removeData('timer');
pcode = $('#promoCode').val().toUpperCase(); 
if (pcode.length !== 0) { //if not empty check:

var requestcheck = $.ajax({
type: "POST",
url: 'https://karmagroup.com/karmaclubmerge/public.php',
data:  {'field-1452846611': pcode},
});
requestcheck.done(function(msghtml) {
if (msghtml == '1') {
$('.promoCodeMsg').html("valid");
$('.promoCodeMsg').css("color", "green");   
}
else if (msghtml == '0') {
$('.promoCodeMsg').html("Invalid");
$('.promoCodeMsg').css("color", "red");  
}
});
requestcheck.fail(function(jqXHR, textStatus) {
alert( "Connection Failed, unable to load database: " + textStatus );
});   
}
}, delay));
});
});
</script>

<?php get_footer(); ?>
