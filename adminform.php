<?php

// Variables
$showAlert="none";
$check=get_option('cats_file_url_status');
$status="codice ".$check;
$message="";
$csvText="";

$code=get_option('cats_file_url');

function validateURL($urlString) {
	if (filter_var($urlString, FILTER_VALIDATE_URL) === FALSE) {
		return FALSE;
	}
	else return TRUE;
}

// Check if query post
if (isset($_POST['cats_file_url'])) {
			$code=$_POST['cats_file_url'];
			$check=$_POST['cats_file_url_status'];
			update_option( 'cats_file_url', $code, true );
			update_option( 'cats_file_url_status', $check, true );
			$code=get_option('cats_file_url');
			$check=get_option('cats_file_url_status');
			$status="codice ".$check;
			$message="Codice inserito e valido formalmente";
			$googleFile='https://docs.google.com/spreadsheets/d/'.$code.'/pub?gid=0&single=true&output=tsv';
			$csvText=file_get_contents($googleFile);
			$tsLocalFilePath=get_option('cats_local_path')."/".get_option('cats_local_filename');
			file_put_contents($tsLocalFilePath, $csvText);
}else{
		$code=get_option('cats_file_url');
		if ($check=="validato"){
			$message='Nel db è presente un codice valido';
			$status="codice ".get_option('cats_file_url_status');
			$tsLocalFilePath=get_option('cats_local_path')."/".get_option('cats_local_filename');
			$csvText=file_get_contents($tsLocalFilePath);
		}
		else {
			$message='Non è presente nessun codice nel db';
			$status="codice ".get_option('cats_file_url_status');
		}
}
?>
<!-- FORM -->
		<div class="wrap">
        <div class="icon32" id="icon-options-general"><br /></div>
        <h2>Configurazione Google Table Sheet</h2>
        <p>&nbsp;</p>
        <form id="form" method="post" action="">
            <?php settings_fields('cats_options_group'); ?>
            <table style='width:100%'>
                <tbody>
                    <tr valign='middle' style='width:100%;'>
                        <td>
                            <input type='text' id='cats_box_file_url' value='<?php echo $code; ?>' name='cats_file_url' style='width:100%;' />
														<input type='hidden' id='cats_box_file_url_status' value='<?php echo $check; ?>' name='cats_file_url_status' style='width:100%;' />
                        </td>
                    </tr>
                    <tr valign='middle' style='width:100%;'>

                            <td>
                                <div id='cats_message' class='alert alert-danger' name='cats_message' style='width:100%;'><?php echo $message; ?></div>
                            </td>
                    </tr>
										<tr valign='middle' style='width:100%;'>

														<td>
																<div id='cats_status' class='alert alert-danger' name='cats_status' style='width:100%;'><?php echo $status; ?></div>
														</td>
										</tr>
										<tr valign='middle' style='width:100%;'>

													 <td>
															 <textarea id='cats_csv_textarea' name='cats_csv_textarea' style='width:100%; height:200px'><?php echo $csvText; ?></textarea>
															 <span class='description'></span>
													 </td>
									 </tr>
                    <tr valign='middle'>

                            <td>
                                <p>
                                    <div type='submit' class='button-primary' id='submit' name='submit' onClick='checkFile();'>Memorizza</div>
                                </p>
                            </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<!-- Fine FORM -->

		<script>
		// Init DOM
		jQuery( document ).ready(function() {
			//checkButton();
		});

		function validateURL(str) {
			var message;
			var myRegExp =/^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;
			var urlToValidate = str;
			if (!myRegExp.test(urlToValidate)){
				return false;
			}else{
				return true;
			}
		}

		function checkFile(){
			var codeInput = jQuery('#cats_box_file_url').val();
			var url = "https://spreadsheets.google.com/feeds/list/"+codeInput+"/od6/public/values?alt=json-in-script";
			jQuery.ajax(url,
					{
						type:'jsonp',
						method:'get',
						 statusCode: {
						 400: function() {
							 jQuery('#cats_message').text("Impossibile validare il codice, forse il codice non è corretto o la risorsa non esiste");
							 jQuery('#cats_status').text("codice non validato");
							 jQuery('#cats_box_file_url_status').val('non validato');
							 jQuery('#cats_csv_textarea').text("");
						 },
						 200: function(objResponse) {
							 jQuery('#cats_message').text("Il file esiste, codice validato");
							 jQuery('#cats_status').text("validato");
							 jQuery('#cats_box_file_url_status').val('validato');
							 jQuery('#cats_csv_textarea').text("OK !!! \n"+JSON.stringify(objResponse));
							 jQuery('#form').submit();
						 }

					}
			 		});

			}

			// When the url input is changing
			function onCodeInputChange(){
					// Check if url is really changed
					checkButton();
					var currentUrl='<?php echo get_option('cats_file_url'); ?>';
					var submitButton = document.getElementById('submit');
					var urlOnInput = jQuery('#cats_box_file_url').val();
					if (urlOnInput===currentUrl)submitButton.disabled=true;
					else submitButton.disabled=false;
			}

	</script>
