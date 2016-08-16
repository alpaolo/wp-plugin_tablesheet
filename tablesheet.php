<?php
/*
Plugin Name: Table Sheet
Version: 1.1
Description: Il plugin permette di importare da Google Sheet una tabella responsive inserendo il codice di pubblicazione di un foglio elettronico pubblicato in Google Docs

Author: Paolo Alberti
Author URI: http://www.clipart.it/
*/


if (!defined('ABSPATH')) die("Accesso diretto al file non permesso");
require("ExcelReader.php");
error_reporting(E_ALL);

function cats_renderTable () {
	$file='prove_corrente_colonna_codici.xls';
	$sheet_uri = ABSPATH . 'wp-content/plugins/tablesheet/'."aa_prove.xls";
	$excelReader = new ExcelReader(); // Call Service

	$excelReader->printSheet($sheet_uri);

}


function cats_showTable () {
wp_register_style( 'tablestyle', plugins_url( '/tablesorter/themes/custom/style.css', __FILE__ ) );
wp_enqueue_style( 'tablestyle' );
wp_enqueue_script('tablesorter', plugins_url( '/tablesorter/js/tableselector.js', __FILE__ ), array('jquery'));
//wp_enqueue_script('tablesorter', plugins_url( '/tablesorter/js/jquery.tablesorter.js', __FILE__ ), array('jquery'));

//wp_register_style( 'tableresponsivestyle', plugins_url( '/responsive-table/css/style.css', __FILE__ ) );
//wp_enqueue_style( 'tableresponsivestyle' );
$tablesorterScriptInit='<script type="text/javascript">jQuery(function($) {$("#tablesorter-demo").tablesorter({ widgets: ["zebra"]});});</script>';
$tablesorterScriptSortOnSelect='<script type="text/javascript">var sort = function (sort_method){jQuery(function($) {$("#tablesorter-demo").tablesorter({ sortList:[sort_method], widgets: ["zebra"]});});};</script>';

/*
$tsLocalFilePath=get_option('cats_local_path')."/".get_option('cats_local_filename');
if (file_exists($tsLocalFilePath)){

}
else echo "Nessun file memorizzato: <br/>1) E' stato rimosso <BR/> 2) Inserire un codice valido nei settings";
*/
cats_renderTable();
}
add_shortcode('tablesheet', 'cats_showTable');
// *** ADMIN PAGE ***
function cats_tablesheet_update_options_form(){
		include ('adminform.php');
}
function cats_tablesheet_settings_page(){
		add_menu_page('Table Sheet', 'Table Sheet', 'administrator', 'tablesheet-options-page', 'cats_tablesheet_update_options_form');
}
add_action('admin_menu', 'cats_tablesheet_settings_page');

function cats_register_options_group(){
    register_setting('cats_options_group', 'cats_file_url');
		register_setting('cats_options_group', 'cats_local_filename');
		register_setting('cats_options_group', 'cats_local_path');
		register_setting('cats_options_group', 'cats_file_url_status');
}
add_action ('admin_init', 'cats_register_options_group');

function cats_plugin_activation()
{
		/*
		$tsLocalFileName="tablesheet.csv";
		$tsLocalPath=wp_upload_dir()['basedir']."/tsfolder";
		mkdir($tsLocalPath, 0700);
		*/
		add_option('cats_file_url', 'Inserisci un codice valido');
		add_option('cats_local_filename',$tsLocalFileName);
		add_option('cats_local_path',$tsLocalPath);
		add_option('cats_file_url_status', 'non validato');
}
register_activation_hook( __FILE__, 'cats_plugin_activation');

function cats_plugin_deactivation()
{
		/*
		$localFilePath=get_option('cats_local_path')."/".get_option('cats_local_filename');
		if(file_exists($localFilePath)){
			unlink($localFilePath);
		}
		if (file_exists(get_option('cats_local_path'))) {
			rmdir(get_option('cats_local_path'));
		}
		*/
		delete_option('cats_file_url');
		delete_option('cats_local_path');
		delete_option('cats_local_filename');
		delete_option('cats_file_url_status');
}
register_deactivation_hook( __FILE__, 'cats_plugin_deactivation' );

?>
