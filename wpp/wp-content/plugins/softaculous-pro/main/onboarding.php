<?php

if(!defined('ABSPATH')){
	die('HACKING ATTEMPT!');
}

add_action('admin_print_styles', 'softaculous_pro_admin_print_styles');
function softaculous_pro_admin_print_styles() {
	
	$act = softaculous_pro_optGET('act');
	$page = softaculous_pro_optGET('page');
	
	// Check if the current page is the onboarding wizard
	if($page == 'assistant' && $act == 'onboarding'){
		echo '<style>
			#adminmenuback, #adminmenuwrap, #wpadminbar  { display: none !important; }
		</style>';
	}
}

add_action('admin_menu', 'softaculous_pro_onboarding_admin_menu', 6);
function softaculous_pro_onboarding_admin_menu() {

	$capability = 'activate_plugins';
	
	// Onboarding
	//add_submenu_page('assistant', __('Onboarding', 'softaculous-pro'), __('Onboarding', 'softaculous-pro'), $capability, 'softaculous_pro_onboarding', 'softaculous_pro_page_handler');
	
	$act = softaculous_pro_optGET('act');
	$page = softaculous_pro_optGET('page');
	
	// Check if the current page is the onboarding wizard
	if($page == 'assistant' && $act == 'onboarding'){
		// Remove admin menu
		remove_menu_page('index.php'); // Dashboard
		remove_menu_page('edit.php'); // Posts
		remove_menu_page('upload.php'); // Media
		remove_menu_page('edit.php?post_type=page'); // Pages
		remove_menu_page('edit-comments.php'); // Comments
		remove_menu_page('themes.php'); // Appearance
		remove_menu_page('plugins.php'); // Plugins
		remove_menu_page('users.php'); // Users
		remove_menu_page('tools.php'); // Tools
		remove_menu_page('options-general.php'); // Settings
		add_filter('show_admin_bar', '__return_false');
		remove_filter('update_footer', 'core_update_footer');
		add_filter('screen_options_show_screen', '__return_false');
		add_filter('admin_footer_text', '__return_empty_string');
		remove_all_actions( 'admin_notices' );
		remove_all_actions( 'all_admin_notices');
	}

}

// Add the action to load the plugin 
add_action('plugins_loaded', 'softaculous_pro_onboarding_load_plugin');

// The function that will be called when the plugin is loaded
function softaculous_pro_onboarding_load_plugin(){

	global $pagelayer, $softaculous_pro;
	
	add_action('admin_enqueue_scripts', 'softaculous_pro_onboarding_enqueue_scripts');

	/* // Load the freemium widgets
	if(!defined('PAGELAYER_PREMIUM')){
		add_action('pagelayer_load_custom_widgets', 'spro_freemium_shortcodes');
	} */
	
	// Are we to setup a template ?
	$slug = get_option('softaculous_pro_setup_template');
	if(!empty($slug)){
		add_action('after_setup_theme', 'spro_setup_template_import');
	}

}

function softaculous_pro_onboarding_enqueue_scripts(){	
			
	$softwp_onboarding_lang = array(
		'conf_data_loss' => __( 'Please confirm that you accept data loss since you have already run the onboarding process previously', 'softaculous-pro' ),
		'select_atleast_one' => __( 'Please select atleast one page to import', 'softaculous-pro' ),
		'downloading_installing_plugins' => __( "Downloading and installing required plugins", 'softaculous-pro' ),
		'wordpress_require_ftp' => __( "WordPress requires FTP details, without them you won't be able to install a plugin/theme", 'softaculous-pro' ),		
		'downloading_template' => __( "Downloading the template", 'softaculous-pro' ),
		'buildWebsite' => __( 'Building your website...', 'softaculous-pro' ),
		'checkRequirements' => __( 'Checking the requirements ...', 'softaculous-pro' ),
		'importTemplate' => __( 'Importing the template', 'softaculous-pro' ),
		'setupCompleted' => __( 'Your website setup is completed', 'softaculous-pro' ),
		'congratulations' => __( 'Congratulations', 'softaculous-pro'),
	);

	if(!empty($_GET['act']) && $_GET['act'] === 'onboarding') {
		
		wp_enqueue_script('softaculous-pro-script-onboarding', SOFTACULOUS_PRO_PLUGIN_URL . '/assets/js/onboarding.js', array('jquery'), SOFTACULOUS_PRO_VERSION, false);
		wp_localize_script('softaculous-pro-script-onboarding', 'softwp_onboarding_lang', $softwp_onboarding_lang);
		wp_enqueue_media();
		wp_enqueue_style( 'softaculous-pro-style-onboarding', SOFTACULOUS_PRO_PLUGIN_URL . '/assets/css/onboarding.css', [], SOFTACULOUS_PRO_VERSION, 'all' );
		
		wp_enqueue_style( 'softaculous-pro-style-font-awesome', SOFTACULOUS_PRO_PLUGIN_URL . '/assets/font-awesome/css/all.min.css', [], SOFTACULOUS_PRO_VERSION, 'all' );
	}
}

function spro_get_features_list(){
	
	$features_list = array(
		
		"seo" => array(
		"name" => __('Increase Website Traffic (SEO)', 'softaculous-pro'),
		"info" => __("Improve your site's ranking on search engines","softaculous-pro"),
		"icon" => 'dashicons dashicons-chart-bar',
		"plugin"=> array(
			"siteseo" => array(
				"plugin_name" => __("SiteSEO – One Click SEO for WordPress","softaculous-pro"),
				"plugin_url"=> "https://siteseo.io/",
				'plugin_init' => 'siteseo/siteseo.php',
				'plugin_download_url' => softaculous_pro_api_url(0, 'siteseo').'files/versions/latest-stable-free.zip',
				'plugin_init_pro' => 'siteseo-pro/siteseo-pro.php',
				'plugin_download_url_pro' => softaculous_pro_api_url(0, 'siteseo').'download.php',
				'plugin_desc' => __('Boost your website\'s search rankings today with the most powerful WordPress SEO plugin. Its lightweight, optimized, and delivers exceptional performance.', 'softaculous-pro'),
				'pro' => 1,
				'featured' => 1,
				'requires_php' => 7.2,
				),
			)
		),
		
		"speedycache" => array(
			"name" => __("Improve Page Speed","softaculous-pro"),
			"info" => __("Improve speed by cache, minify, compress", 'softaculous-pro'),
			"icon" => "fa-solid fa-gauge-high",
			"plugin"=> array(
				"speedycache" => array(
					"plugin_name" => __("SpeedyCache – Cache, Optimization, Performance","softaculous-pro"),
					"plugin_url"=> "https://wordpress.org/plugins/speedycache/",
					'plugin_init' => 'speedycache/speedycache.php',
					'plugin_init_pro' => 'speedycache-pro/speedycache-pro.php',
					'plugin_download_url_pro' => softaculous_pro_api_url(0, 'speedycache').'download.php',
					'plugin_desc' => __('SpeedyCache is an easy to use and powerful WordPress Cache Plugin, it helps you reduce page load time improving User Experience and boosting your Google PageSpeed.', 'softaculous-pro'),
					'pro' => 1,
					'featured' => 1,
					'requires_php' => 7.3,
				),
			)
		),
		
		"backuply" => array(
			"name" => __("Schedule Backups","softaculous-pro"),
			"info" => __("Backup your site on local or remote servers","softaculous-pro"),
			"icon" => "fa-regular fa-file-zipper",
			"plugin"=> array(
				"backuply" => array(
					"plugin_name" => __("Backuply – Backup, Restore, Migrate and Clone","softaculous-pro"),
					"plugin_url"=> "https://wordpress.org/plugins/backuply/",
					'plugin_init' => 'backuply/backuply.php',
					'plugin_init_pro' => 'backuply-pro/backuply-pro.php',
					'plugin_download_url_pro' => softaculous_pro_api_url(0, 'backuply').'download.php',
					'plugin_desc' => __('Backuply is a WordPress backup plugin that helps you backup your WordPress website, saving you from loss of data because of server crashes, hacks, dodgy updates, or bad plugins.', 'softaculous-pro'),
					'pro' => 1,
					'featured' => 1,
					'requires_php' => 5.5,
				),
			)
		),
		
		"sell_products" => array(
			"name" => __("Sell Products","softaculous-pro"),
			"info" => __("Sell physical or digital products","softaculous-pro"),
			"icon" => "fa-solid fa-tag",
			"plugin"=> array(
				"woocommerce" => array(
					"plugin_name" => __("WooCommerce","softaculous-pro"),
					"plugin_url"=> "https://wordpress.org/plugins/woocommerce/",
					'plugin_init' => 'woocommerce/woocommerce.php',
				),
			)
		),
		
		"loginizer" => array(
			"name" => __("Limit Login Attempts","softaculous-pro"),
			"info" => __("Brute force protection, 2FA, login captcha", 'softaculous-pro'),
			"icon" => "fa-solid fa-user-lock",
			"plugin"=> array(
				"loginizer" => array(
					"plugin_name" => __("Loginizer","softaculous-pro"),
					"plugin_url"=> "https://wordpress.org/plugins/loginizer/",
					'plugin_init' => 'loginizer/loginizer.php',
					'plugin_init_pro' => 'loginizer-security/loginizer-security.php',
					'plugin_download_url_pro' => softaculous_pro_api_url(0, 'loginizer').'download.php',
					'plugin_desc' => __('Loginizer is a simple and effortless solution that takes care of all your security problems. It comes with default optimal configuration to protect your site from Brute Force attacks.', 'softaculous-pro'),
					'pro' => 1,
					'featured' => 1,
					'requires_php' => 5.5,
				),
			)
		),
		
		"pagelayer" => array(
			"name" => __("Page Builder","softaculous-pro"),
			"info" => __("Page Builder, Drag and Drop website builder", 'softaculous-pro'),
			"icon" => "fa-solid fa-paintbrush",
			"plugin"=> array(
				"pagelayer" => array(
					"plugin_name" => __("Pagelayer","softaculous-pro"),
					"plugin_url"=> "https://wordpress.org/plugins/pagelayer/",
					'plugin_init' => 'pagelayer/pagelayer.php',
					'plugin_init_pro' => 'pagelayer-pro/pagelayer-pro.php',
					'plugin_download_url_pro' => softaculous_pro_api_url(0, 'pagelayer').'download.php',
					'plugin_desc' => __('Pagelayer is an awesome page builder that allows you to create and design your website instantly in the simplest way possible. Take control over your page content with the most advanced page builder plugin available.', 'softaculous-pro'),
					'pro' => 1,
					'featured' => 1,
					'selected' => 1,
					'requires_php' => 5.5,
				),
			)
		),
		
		"gosmtp" => array(
			"name" => __("Send Email with SMTP","softaculous-pro"),
			"info" => __("Providers: Gmail, Outlook, AWS SES & more", 'softaculous-pro'),
			"icon" => "fa-solid fa-envelope-circle-check",
			"plugin"=> array(
				"gosmtp" => array(
					"plugin_name" => __("GoSMTP – SMTP for WordPress","softaculous-pro"),
					"plugin_url"=> "https://wordpress.org/plugins/gosmtp/",
					'plugin_init' => 'gosmtp/gosmtp.php',
					'plugin_init_pro' => 'gosmtp-pro/gosmtp-pro.php',
					'plugin_download_url_pro' => softaculous_pro_api_url(0, 'gosmtp').'download.php',
					'plugin_desc' => __('GoSMTP allows you to send emails from your WordPress over SMTP or many popular outgoing email service providers. Using these improves your email deliverability.', 'softaculous-pro'),
					'pro' => 1,
					'featured' => 1,
					'requires_php' => 5.5,
				),
			)
		),
		
		"cookieadmin" => array(
			"name" => __("CookieAdmin","softaculous-pro"),
			"info" => __("Cookie Consent Banner for visitors", 'softaculous-pro'),
			"icon" => "fa-solid fa-cookie-bite",
			"plugin"=> array(
				"cookieadmin" => array(
					"plugin_name" => __("CookieAdmin – Cookie Consent Banner","softaculous-pro"),
					"plugin_url"=> "https://wordpress.org/plugins/cookieadmin/",
					'plugin_init' => 'cookieadmin/cookieadmin.php',
					'plugin_init_pro' => 'cookieadmin-pro/cookieadmin-pro.php',
					'plugin_download_url_pro' => softaculous_pro_api_url(0, 'cookieadmin').'download.php',
					'plugin_desc' => __('CookieAdmin is an easy to use Cookie consent banner plugin which allows you to display a banner on the frontend for your visitors to choose which cookies they would like to use. ', 'softaculous-pro'),
					'pro' => 1,
					'featured' => 1,
					'requires_php' => 7.0,
				),
			)
		),
		
		"fileorganizer" => array(
			"name" => __("File Manager","softaculous-pro"),
			"info" => __("Manage files with drag & drop editor", 'softaculous-pro'),
			"icon" => "fa-regular fa-folder-open",
			"plugin"=> array(
				"fileorganizer" => array(
					"plugin_name" => __("FileOrganizer – Manage WordPress and Website Files","softaculous-pro"),
					"plugin_url"=> "https://wordpress.org/plugins/fileorganizer/",
					'plugin_init' => 'fileorganizer/fileorganizer.php',
					'plugin_init_pro' => 'fileorganizer-pro/fileorganizer-pro.php',
					'plugin_download_url_pro' => softaculous_pro_api_url(0, 'fileorganizer').'download.php',
					'plugin_desc' => __('FileOrganizer is a lightweight and easy-to-use file management plugin for WordPress. Organize and manage your WordPress files with FileOrganizer without any control panel or FTP access. ', 'softaculous-pro'),
					'pro' => 1,
					'featured' => 1,
					'requires_php' => 5.5,
				),
			)
		),
	);
	
	$features_list = apply_filters('softaculous_pro_features_list', $features_list);
	
	return $features_list;
}


function softaculous_pro_ajax_output($data){
	
	echo json_encode($data);
	
	wp_die();
	
}

function softaculous_pro_ajax_output_xmlwrap($data){
	
	echo '<softaculous-pro-xmlwrap>'.json_encode($data).'</softaculous-pro-xmlwrap>';
	
	wp_die();
}

function softaculous_pro_import_template($slug, $items = array()){
	global $pl_error, $softaculous_pro;

	$data = [];
	
	$destination = popularfx_templates_dir(false).'/'.$slug;
	
	include_once(PAGELAYER_DIR.'/main/import.php');
	$setup_info = softaculous_pro_get_option_setup_info();

	if(!empty($setup_info['mode']) && $setup_info['mode'] == 'ai'){
	
		// Is AI Import		
		if(empty($softaculous_pro['ai_pages_to_import']) && !empty($setup_info['theme_pid']) ) {
			
			$md5 = $setup_info['theme_pid'];
			$attempts = 3;

			for($i = 0; $i < $attempts; $i++){
				$response = softaculous_pro_load_ai_generated_pages($slug, $md5);
				
				if(is_wp_error($response)){
					continue;
				}
				
				$body = wp_remote_retrieve_body($response);
				$pages = json_decode($body, true);
				
				if(!empty($pages['pages'])){
					$softaculous_pro['ai_pages_to_import'] = $pages['pages'];
					break;
				}
			}
			
			if(empty($softaculous_pro['ai_pages_to_import'])){
				$data['error']['ai_content'] = __('Failed to load AI generated pages, Please try again!', 'softaculous-pro');
				if(is_array($pl_error) && !empty($pl_error)){
					$data['error'] = array_merge($data['error'], $pl_error);
				}
				// TODO: For Debug remove if not needed
				$data['response'] = $response;
				return $data;
			}
		}
	}
	
	// Our function needs to efficiently replace the variables
	$GLOBALS['softaculous_pro_template_import_slug'] = $slug;	
	add_filter('pagelayer_start_insert_content', 'softaculous_pro_pagelayer_start_insert_content', 10);
	
	// Now import the template
	if(!pagelayer_import_theme($slug, $destination, $items)){
		$data['error']['import_err'] = __('Could not import the template !', 'softaculous-pro');
		
		if(is_array($pl_error) && !empty($pl_error)){
			$data['error'] = array_merge($data['error'], $pl_error);
		}
		
		return $data;
	}
	
	// Save the name of the slug
	set_theme_mod('popularfx_template', $slug);
	
	// onboarding done
	update_option('softaculous_pro_onboarding_done', time());
	
	// Set default left menu folded
	//set_user_setting('mfold', 'f');
	
	$data['done'] = 1;
	
	return $data;
	
}

// Load AI generated pages
function softaculous_pro_load_ai_generated_pages($slug, $md5){
	global $softaculous_pro;
				
	$api_url = trailingslashit(SOFTACULOUS_PRO_AI_DEMO) . 'wp-json/softwpai/v1/get/pages';
	$license = ( isset($softaculous_pro['license']) && isset($softaculous_pro['license']['license'] )
			? $softaculous_pro['license']['license'] : ''
		);
	
	$args = [
		'method'  => 'POST',
		'body' => [
			'template' => $slug, 
			'pid' => $md5,
			'license' => $license,
			'url' => site_url()
		],
	];

	return wp_remote_post($api_url, $args);
}

// Download the template
function softaculous_pro_download_template($slug){
	
	global $softaculous_pro, $pl_error;	

	set_time_limit(300);
	
	$data = [];

	// Now lets download the templates
	if(!function_exists( 'download_url' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}

	$spro_setup_info = softaculous_pro_get_option_setup_info();

	
	$url = softaculous_pro_pfx_api_url().'/givetemplate.php?slug='.$spro_setup_info['theme_slug'].'&license='.@$softaculous_pro['license']['license'].'&url='.rawurlencode(site_url());
	
	$popular_fx_dir = popularfx_templates_dir(false);
	$destination = $popular_fx_dir.'/'.$slug;

	// Check if FTP is required
	ob_start();
	$credentials = request_filesystem_credentials('');
	ob_end_clean();

	if(false === $credentials || !WP_Filesystem($credentials)){
		$data['error']['download'] = __('Theme template can only be uploaded using FTP !', 'softaculous-pro');
		return $data;
	}
	
	global $wp_filesystem;
	
	// For FTP have to use relative paths
	if(is_array($credentials)){
		$abspath_relative = $wp_filesystem->find_folder(ABSPATH);
		$replacer = str_replace($abspath_relative, '', ABSPATH);
		if($replacer !== ABSPATH){
			$popular_fx_dir = str_replace($replacer, '', $popular_fx_dir);
			$destination = str_replace($replacer, '', $destination);
		}
	}

	$tmp_file = download_url($url);
	//echo filesize($tmp_file);
	//var_dump($tmp_file);
	
	// Error downloading
	if(is_wp_error($tmp_file) || filesize($tmp_file) < 1){
		if(!empty($tmp_file->errors)){			
			$data['error']['download_err'] = __('Could not download the theme !', 'softaculous-pro').var_export($tmp_file->errors, true);
			return $data;
		}
	}
	
	$wp_filesystem->mkdir($popular_fx_dir);
	$wp_filesystem->mkdir($destination);
	//echo $destination;

	$ret = unzip_file($tmp_file, $destination);
	//r_print($ret);
	
	// Try to delete
	@unlink($tmp_file);
	
	// Error downloading
	if(is_wp_error($ret) || !file_exists($destination.'/style.css')){
		if(!empty($ret->errors)){
			$data['error']['download'] = __('Could not extract the template !', 'softaculous-pro').var_export($ret->errors, true);
			return $data;
		}
	}

	return $data;

}

// Get list of templates
function softaculous_pro_get_templates_list(){
	
	$data = get_transient('softaculous_pro_templates');

	// Get any existing copy of our transient data
	if(false === $data || empty($data['ai_list'])){
	
		// Start checking for an update
		$send_for_check = array(
			'timeout' => 90,
			'user-agent' => 'WordPress'		
		);
		
		$raw_response = wp_remote_post( softaculous_pro_pfx_api_url().'templates.json', $send_for_check );
		//pagelayer_print($raw_response);die();
	
		// Is the response valid ?
		if ( !is_wp_error( $raw_response ) && ( $raw_response['response']['code'] == 200 ) ){		
			$data = json_decode($raw_response['body'], true);
		}
		//pagelayer_print($data);die();
	
		// Feed the updated data into the transient
		if(!empty($data['list']) && count($data['list']) > 10){
			// Filter arrays that have the 'ai' key
			$aiThemeList = array_filter($data['list'], function($item) {
				return isset($item['ai']) && $item['ai'] == 1;
			});
			
			$data['ai_list'] = is_array($aiThemeList) ? softaculous_pro_shuffle_assoc($aiThemeList) : [];
			
			set_transient('softaculous_pro_templates', $data, 2 * HOUR_IN_SECONDS);
		}
		
	}
	
	return $data;
	
}

// Get the template info from our servers
function softaculous_pro_onboarding_dismiss(){

	// Some AJAX security
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');
	
	if(isset($_REQUEST['dismiss'])){
		update_option('softaculous_pro_onboarding_dismiss', time());
	}
	
	$data['done'] = 1;
	
	softaculous_pro_ajax_output($data);
	
}

// Get the template info from our servers
function softaculous_pro_ajax_template_info(){

	// Some AJAX security
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');
	
	$data = [];

	if(isset($_REQUEST['slug'])){		
		$resp = wp_remote_get(softaculous_pro_pfx_api_url().'template-info.php?slug='.$_REQUEST['slug'], array('timeout' => 90));
	
		// Is the response valid ?
		if ( !is_wp_error( $resp ) && ( $resp['response']['code'] == 200 ) ){		
			$data = json_decode($resp['body'], true);
		}
	}
	
	$setup_info = softaculous_pro_get_option_setup_info();
	$setup_info = !empty($setup_info) ? $setup_info : array();
	$setup_info['theme_slug'] = $_REQUEST['slug'];

	update_option('softaculous_pro_setup_info',$setup_info);
	
	softaculous_pro_ajax_output($data);
	
}

// Start the installation of the template
function softaculous_pro_ajax_start_install_template(){
	
	global $softaculous_pro;
	
	// Some AJAX security
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');

	set_time_limit(300);
	
	// Handling Access through FTP
	ob_start();
	// Check if FTP is required
	$have_credentials = request_filesystem_credentials('');

	if(false === $have_credentials){
		$form_html = ob_get_clean();
		$ftp_modal = '<div id="request-filesystem-credentials-dialog" class="notification-dialog-wrap request-filesystem-credentials-dialog">
		<div class="notification-dialog-background"></div>
		<div class="notification-dialog" role="dialog" aria-labelledby="request-filesystem-credentials-title" tabindex="0">
		<div class="request-filesystem-credentials-dialog-content">'. $form_html . '</div></div></div>';

		wp_send_json_error(['form' => $ftp_modal]);
	}

	ob_end_clean(); // Just in case there was any output till now it will be cleaned.

	$data = [];
	
	//pagelayer_print($_POST);die();
	$license = softaculous_pro_optPOST('softaculous_pro_license');
	
	// Check if its a valid license
	if(!empty($license)){
	
		$resp = wp_remote_get(softaculous_pro_api_url(1).'license.php?license='.$license.'&url='.rawurlencode(site_url()), array('timeout' => 30));
	
		if(is_array($resp)){
			$json = json_decode($resp['body'], true);
			//print_r($json);
		}else{
		
			$data['error']['resp_invalid'] = __('The response from the server was malformed. Please try again in sometime !', 'softaculous-pro').var_export($resp, true);
			softaculous_pro_ajax_output($data);
			
		}
	
		// Save the License
		if(empty($json['license'])){
		
			$data['error']['lic_invalid'] = __('The license key is invalid', 'softaculous-pro');
			softaculous_pro_ajax_output($data);
			
		}else{
			
			update_option('softaculous_pro_license', $json);
	
			// Load license
			spro_load_license();
			
		}
		
	}
	
	// Load templates
	$softaculous_pro['templates'] = softaculous_pro_get_templates_list();
	
	$slug = softaculous_pro_optPOST('theme');
	
	if(!defined('PAGELAYER_VERSION')){
		
		$res = spro_install_required_plugin('pagelayer', array('plugin_init' => 'pagelayer/pagelayer.php'));
		
		if(empty($res['success'])){
			$data['error']['pl_req'] = __('Pagelayer is required to use the templates !', 'softaculous-pro');
			softaculous_pro_ajax_output($data);
		}
	}
	
	if(!defined('PFX_VERSION')){
		
		$res = spro_install_required_plugin('popularfx-templates', array('plugin_init' => 'popularfx-templates/popularfx-templates.php', 'plugin_download_url' => softaculous_pro_api_url(0, 'popularfx').'update2.php?give=1'));
		
		if(empty($res['success'])){
			$data['error']['pl_req'] = __('PopularFX plugin is required to use the templates !', 'softaculous-pro');
			softaculous_pro_ajax_output($data);
		}
	}
	
	if(!function_exists('popularfx_templates_dir')){

		$res = spro_install_required_theme('popularfx');
		
		if(empty($res['success'])){
			$data['error']['pfx_req'] = __('PopularFX theme is required to use the templates !', 'softaculous-pro');
			softaculous_pro_ajax_output($data);
		}
		
	}
	
	if(empty($softaculous_pro['templates']['list'][$slug])){
		$data['error']['template_invalid'] = __('The template you submitted is invalid !', 'softaculous-pro');
		softaculous_pro_ajax_output($data);
	}
	
	$template = $softaculous_pro['templates']['list'][$slug];
	
	// Do we have the req PL version ?
	if(!empty($template['pl_ver']) && version_compare(PAGELAYER_VERSION, $template['pl_ver'], '<')){
		$data['error']['pl_ver'] = sprintf(__('Your Pagelayer version is %1$s while the template requires Pagelayer version higher than or equal to %2$s ', 'softaculous-pro'), PAGELAYER_VERSION, $template['pl_ver']);
		softaculous_pro_ajax_output($data);
	}
	
	// Do we have the req PL version ?
	if(version_compare(PAGELAYER_VERSION, '1.8.9', '<')){
		$data['error']['pl_ver'] = sprintf(__('Your Pagelayer version is %1$s while the onboarding requires Pagelayer version higher than or equal to 1.8.9', 'softaculous-pro'), PAGELAYER_VERSION);
		softaculous_pro_ajax_output($data);
	}
	
	// Do we have the req PFX Plugin version ?
	if(!empty($template['pfx_ver']) && version_compare(PFX_VERSION, $template['pfx_ver'], '<')){
		$data['error']['pfx_ver'] = sprintf(__('Your PopularFX Plugin version is %1$s while the template requires PopularFX version higher than or equal to %2$s', 'softaculous-pro'), PFX_VERSION, $template['pfx_ver']);
		softaculous_pro_ajax_output($data);
	}
	
	// Is it a pro template ?
	if($template['type'] > 1 && empty($softaculous_pro['license']['active'])){
		$data['error']['template_pro'] = sprintf(__('The selected template is a Pro template and you have a free or expired license. Please enter your license key %1$shere%2$s.', 'softaculous-pro'), 
			'<a href="'.admin_url('admin.php?page=assistant&act=license').'" target="_blank" style="color:blue;">',
			'</a>'
			);
		softaculous_pro_ajax_output($data);
	}
	
	$do_we_have_pro = defined('PAGELAYER_PREMIUM');
	
	// Do we need to install Pagelayer or Pagelayer PRO ?
	if(!function_exists('pagelayer_theme_import_notices') || (empty($do_we_have_pro) && $template['type'] > 1)){
		if($template['type'] > 1){
			$download_url = SOFTACULOUS_PRO_PAGELAYER_API.'download.php?version=latest&license='.$softaculous_pro['license']['license'].'&url='.rawurlencode(site_url());
			$installed = spro_install_required_plugin('pagelayer-pro', array('plugin_init' => 'pagelayer-pro/pagelayer-pro.php', 'plugin_download_url' => $download_url));
		}else{
			$installed = spro_install_required_plugin('pagelayer', array('plugin_init' => 'pagelayer/pagelayer.php'));
		}
		
		// Did we fail to install ?
		if(is_wp_error($installed) || empty($installed)){
			$install_url = admin_url('admin.php?page=softaculous_pro_install_pagelayer&license=').@$softaculous_pro['license']['license'];
			$data['error']['pagelayer'] = sprintf(__('There was an error in installing Pagelayer which is required by this template. Please install Pagelayer manually by clicking %1$shere%2$s and then install the template !', 'softaculous-pro'), '<a href="%1$s" target="_blank">'.$install_url, '</a>');
			if(!empty($installed->errors)){
				$data['error']['pagelayer_logs'] = var_export($installed->errors, true);
			}
			softaculous_pro_ajax_output_xmlwrap($data);
		}
		
	}
	
	// Lets notify to download
	// $data['download'] = 1;
	$data['sel_plugin'] = 1;
	
	softaculous_pro_ajax_output_xmlwrap($data);
	
}

function softaculous_pro_set_progress($text, $percent, $data = []){
	update_option('softaculous_pro_onboarding_progress', ['text' => $text, 'percent' => $percent, 'data' => $data]);
}

function softaculous_pro_ajax_selected_plugin(){
	
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');
	
	if ( ! current_user_can( 'edit_posts' ) ) {	
		wp_send_json_error();
	}
	
	$results = array();
	$options = softaculous_pro_get_option_setup_info();
	
	$sel_features = $options['features'];
	if(!empty($sel_features)){
		$feature_list = spro_get_features_list();
		foreach($feature_list as $slug => $features){
			if (in_array($slug, $sel_features)) {
				
				// Set the progress
				softaculous_pro_set_progress(_('Enabling Feature').' : '.$features['name'], 45);
				
				foreach($features['plugin'] as $plugin_slug => $plugin_data){
					
					$res = spro_install_required_plugin($plugin_slug, $plugin_data);
					$results[] = array(
						'plugin_slug' => $plugin_slug,
						'status' => $res,
					);
				}
			}
		}
		foreach ($results as $item) {
			if (isset($item['status']['error'])) {
				$data['failed_plugin'][$item['plugin_slug']] = $item['status']['error'];
			}
		}
		$data['download'] = 1;
		softaculous_pro_ajax_output($data);
	}
}

// Download template
function softaculous_pro_ajax_download_template(){
	
	global $softaculous_pro;
	
	// Some AJAX security
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');
	
	$slug = softaculous_pro_optPOST('theme');
	
	// Do the download
	$data = softaculous_pro_download_template($slug);
	
	// Any error ?
	if(!empty($data['error'])){
		softaculous_pro_ajax_output($data);
	}
	
	// Lets import then
	$data['import'] = 1;
	
	softaculous_pro_ajax_output($data);
	
}

// Import template
function softaculous_pro_ajax_import_template(){ 
	
	global $softaculous_pro, $pl_error;

	// Some AJAX security
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');
	
	$slug = softaculous_pro_optPOST('theme');
	$to_import = softaculous_pro_optPOST('to_import');
	$_POST['set_home_page'] = 1;
	
	if(!empty($to_import)){
		$to_import[] = 'blog';
		$items = ['page' => $to_import];
	}else{
		$items = [];
	}
	
	// Import the template
	$data = softaculous_pro_import_template($slug, $items);
	
	softaculous_pro_ajax_output($data);
	
}

// Category Autocomplete
function softaculous_pro_ai_autocomplete(){
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');

	$string = !empty($_REQUEST['val']) ? sanitize_text_field($_REQUEST['val']) : '';

	$data = [
		'request_type' => 'builder_autocomplete',
		'string' => $string,
	];

	$res = softaculous_pro_generate_ai_content($data);
	echo json_encode($res);
	wp_die();
}

// For generate description
function softaculous_pro_ai_description(){

	// Some AJAX security
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');
	
	$data = isset($_REQUEST['data']) && is_array($_REQUEST['data']) ? $_REQUEST['data'] : [];
	$title = !empty($data['site_name']) ? sanitize_text_field($data['site_name']) : '';
	$category = !empty($data['site_category']) ? sanitize_text_field($data['site_category']) : '';
	$language = !empty($data['site_language']) ? sanitize_text_field($data['site_language']) : 'English';
	$description = !empty($data['description']) ? sanitize_textarea_field($data['description']) : $title;
	
	$ai_data = [
		'request_type' => 'builder_desc',
		'business_language' => $language,
		'user_desc' => $description,
		'business_category' => $category,
		'business_title' => $title,
	];

	$res = softaculous_pro_generate_ai_content($ai_data);
	
	echo json_encode($res);
	wp_die();
}

// Generate a blog post using AI and create a new WordPress post
function softaculous_pro_ajax_generate_post() {

	// Validate AJAX request
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');
	
	if(!current_user_can( 'edit_posts' )){
		wp_send_json_error(__('Permission denied.'));
	}
	
	// Get and sanitize input
	$data = isset($_REQUEST['data']) && is_array($_REQUEST['data']) ? $_REQUEST['data'] : [];
	$site_name = isset($data['site_name']) ? sanitize_text_field($data['site_name']) : '';
	$user_context = isset($data['description']) ? sanitize_textarea_field($data['description']) : $site_name;

	// Fallback if no context
	if (empty($site_name)) {
		wp_send_json_error(__('Site name is required to generate content.'));
	}

	$ai_data = [
		'request_type' => 'builder_create_post',
		'user_desc' => $user_context,
		'business_title' => $site_name
	];

	$res = softaculous_pro_generate_ai_content($ai_data);

	// Handle empty or invalid response
	if (empty($res) || !is_array($res)) {
		wp_send_json_error(__('Unable to generate post. Please try again later.'));
	}

	if (!empty($res['error'])) {
		wp_send_json_error($res['error']);
	}

	if (empty($res['title']) || empty($res['content'])) {
		wp_send_json_error(__('Generated content is incomplete. No title or content found.'));
	}

	// Prepare post array
	$post = [
		'post_title'   => wp_strip_all_tags($res['title']),
		'post_content' => wp_kses_post($res['content']),
		'post_status'  => 'publish'
	];

	$post_id = wp_insert_post($post);

	if (is_wp_error($post_id)) {
		wp_send_json_error(__('Failed to insert post into database.'));
	}

	wp_send_json_success(__('Post successfully created!'));
}

// For ai onboarding
function softaculous_pro_search_images(){
	global $softaculous_pro;
	
	// Some AJAX security
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');
	
	$api_url = SOFTACULOUS_PRO_AI_DEMO . 'wp-json/softwpai/v1/get/images';
	$license = ( isset($softaculous_pro['license']) && isset($softaculous_pro['license']['license'] )
			? $softaculous_pro['license']['license'] : ''
		);
	
	$query       = isset( $_REQUEST['query'] ) ? sanitize_text_field( $_REQUEST['query'] ) : '';
	$per_page    = isset( $_REQUEST['per_page'] ) ? absint( $_REQUEST['per_page'] ) : 15;
	$page        = isset( $_REQUEST['page'] ) ? absint( $_REQUEST['page'] ) : 1;
	
	$args = [
		'body' => [
			'query' => $query, 
			'per_page' => $per_page,
			'page' => $page,
			'license' => $license,
			'url' => site_url()
		],
		'method'  => 'POST',
	];

	$response = wp_remote_post($api_url, $args);			

	if (is_wp_error($response)) {
		echo json_encode(['error' => 'Unable to get images for some reason']); // TODO give acutual error form response
		wp_die();
	}
	
	$body = wp_remote_retrieve_body($response);
	$images = json_decode($body, true);
	
	if (isset($images['code'])) {
		echo json_encode([
			'error' => isset($images['message']) ? $images['message'] : 'Unknown error occurred',
			'code' => $images['code'],
			'status' => isset($images['data']) ? $images['data'] : 500
		]);
		wp_die();
	}
	
	echo json_encode([
		'success' => 'done',
		'images' => $images
	]);
		
	wp_die();
}

// For ai onboarding
function softaculous_pro_save_setup_info(){
	// Some AJAX security
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');
	
	if(current_user_can('activate_theme')){
		echo json_encode(['error' => 'You are not allowed here!']);
		wp_die();
	}
	
	//$step = $_POST['step'];
	$post_data = wp_unslash($_POST['data']);
	$setup_info = softaculous_pro_get_option_setup_info();
	$load_templates = false;
	$cacheTemplates = false;
	
	$setup_info = !empty($setup_info) ? $setup_info : array();

	if(empty($post_data)){
		echo json_encode(['error' => 'Post data not found!']);
		wp_die();
	}
	
	// wp_send_json($post_data);
	if(isset($post_data['business_title'])){
		$business_title = sanitize_text_field($post_data['business_lang']);
		update_option('blogname', $post_data['business_title']);
	}

	// Choose the lang
	if(isset($post_data['business_lang'])){
		$business_lang = sanitize_text_field($post_data['business_lang']);
		// update_option('WPLANG', 'en');
		$setup_info['business_lang'] = $business_lang;
	}

	if(!empty($post_data['business_type'])){
		$setup_info['business_type'] = sanitize_text_field($post_data['business_type']);
	}

	if(isset($post_data['mode'])){
		if(in_array($post_data['mode'], ['ai', 'manual'])){
			$setup_info['mode'] = $post_data['mode'];
		}else{
			$setup_info['mode'] = 'manual';
		}
	}

	if (isset($setup_info['mode']) && $setup_info['mode'] == 'ai' && !empty($post_data['business_description'])) { 
		$business_description = $post_data['business_description']; // todo: senitize Array
		$load_templates = true;
		$cacheTemplates = ($setup_info['mode'] == 'ai' ? true : false);
		
		if(!is_array($business_description)) {
			echo json_encode(['error' => 'Description required.']);
			wp_die();
		}else{
			$setup_info['business_description'] = $business_description;
		
			// This will make sure that new added will be set to newly added index;
			$setup_info['active_desc'] = isset($post_data['active_desc']) ? $post_data['active_desc'] : count($setup_info['business_description']) - 1;
			
			// TODO check if provious description is same then not change the tags
			$images_suggestions = softaculous_pro_ai_image_tags_suggestions($business_description[$setup_info['active_desc']]);
		
			if(!empty($images_suggestions)){
				$setup_info['image_suggestions'] = $images_suggestions;
			}
		}
		
		if (strlen($setup_info['business_description'][$setup_info['active_desc']]) < 200) {
			echo json_encode(['error' => __('It seems that the description is insufficient. Please provide a brief overview of your site before proceeding further. You can write your own description, or let AI generate one for you.')]);
			wp_die();
		}
		
	}

	if(isset($post_data['business_email'])){
		update_option('pagelayer_cf_from_email', sanitize_email($post_data['business_email']));
	}
	if(isset($post_data['business_phone'])){
		update_option('pagelayer-phone', sanitize_text_field($post_data['business_phone']));
	}
	if(isset($post_data['business_address'])){
		update_option('pagelayer-address', sanitize_text_field($post_data['business_address']));
	}

	if(!empty($post_data['features'])){
		$setup_info['features'] = $post_data['features'];
	}
	
	// Pagelayer plugin is compulsory for import
	if(!empty($post_data['step']) && $post_data['step'] == 'features' && (empty($post_data['features']) || !in_array('pagelayer', $post_data['features']))){
		echo json_encode(['error' => 'The Page Builder plugin is required to import themes and content !']);
		wp_die();
	}

	if (isset($post_data['selected_images'])) {
		$load_templates = true;
		
		$setup_info['selected_images'] = is_array($post_data['selected_images']) ? $post_data['selected_images'] : array($post_data['selected_images']);
		
		if(count($setup_info['selected_images']) < 10){
			echo json_encode(['error' => 'Please select at least 10 images to help us design a better website.']);
			wp_die();
		}
		
	}
	
	if($load_templates){
		$active_desc_id = $setup_info['active_desc'];
		$selected_desc = $setup_info['business_description'][$active_desc_id];
		
		// If an image is already selected we skip the images while caching templates
		$images =  $cacheTemplates ? [] : $setup_info['selected_images'];
		
		$generate_theme_pid = softaculous_pro_ai_fetch_templates_data($selected_desc, $images);

		if(!empty($generate_theme_pid['pid']) && !is_wp_error($generate_theme_pid)){
			$setup_info['theme_pid'] = $generate_theme_pid['pid'];
		}else{
			echo json_encode(['error' => 'Unable to get preview Id!', 'response' => $generate_theme_pid]);
			wp_die();
		}
	}
	
	update_option('softaculous_pro_setup_info', $setup_info);
	
	// load first 12 Templates
	if($cacheTemplates && !empty($setup_info['theme_pid'])){
		$urls = softaculous_pro_cache_templates($setup_info['theme_pid'], 12);
		$setup_info['preview_urls'] = $urls;
	}
	
	echo json_encode([
		'success' => 'done',
		'setup_info' => $setup_info,
	]);
	
	wp_die();

}

function softaculous_pro_ai_demo_url($slug, $pid = '', $page = 'home'){
	global $softaculous_pro;
	
	if(empty($pid)){
		$setup_info = softaculous_pro_get_option_setup_info();
		$pid = !empty($setup_info['theme_pid']) ? $setup_info['theme_pid'] : '';
	}
	
	$preview_url = SOFTACULOUS_PRO_AI_DEMO .'?template_preview=';
	$license = (isset($softaculous_pro['license']) && isset($softaculous_pro['license']['license'] ) ? $softaculous_pro['license']['license'] : '');
	
	return $preview_url. $slug .'&pid='. $pid .'&tpage='.$page.'&license='. $license .'&url='. rawurlencode(site_url());
}

// Cache templates
function softaculous_pro_cache_templates($pid, $num = 10, $start = 0){
	
	$templates = softaculous_pro_get_templates_list();
	
	$i = 0;
	$theme_counter = 0;
	$end = $start + $num;
	$urls = array();
	
	foreach($templates['ai_list'] as $slug => $theme) {

		if ($i >= $start && $i < $end) {
			$urls[$slug] = softaculous_pro_ai_demo_url($slug);
		}

		$i++;
	}

	return $urls;
}

function softaculous_pro_cache_iframe_urls(){
	// Some AJAX security
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');
	
	if(current_user_can('activate_theme')){
		echo json_encode(['error' => 'You are not allowed here!']);
		wp_die();
	}
	
	/* Example, also support for pages
		$urls = array{
			'template_name/page' => 'template_name/URL'
		}
	*/
	$urls = isset($_REQUEST['urls']) && is_array($_REQUEST['urls']) ? $_REQUEST['urls'] : [];
	if(empty($urls)) {
		echo json_encode(['error' => 'No URLs provided']);
		wp_die();
	}
	
	$setup_info = softaculous_pro_get_option_setup_info();
	
	if(empty($setup_info['mode']) || $setup_info['mode'] !== 'ai'){
		echo json_encode(['error' => 'AI Mode is not enabled !']);
		wp_die();
	}

	ignore_user_abort(true);

	$timeout = 30;
	
	$multi = curl_multi_init();
	$channels = [];

	foreach ($urls as $i => $url) {
		
		// If URL not provided
		// Also support for pages
		if(!wp_http_validate_url($url)){
			$page = ($url != $i) ? $i : 'home';
			$url = softaculous_pro_ai_demo_url($url, '', $page);
		}
		
		$url .= (strpos($url, '?') === false ? '?' : '&') . 'ignore_user_abort=1';
		
		$clean_url = esc_url_raw($url);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_multi_add_handle($multi, $ch);
		$channels[$i] = $ch;
	}

	$running = null;
	do {
		curl_multi_exec($multi, $running);
		curl_multi_select($multi);
	} while ($running > 0);

	// Optional: Collect results
	$responses = [];
	foreach ($channels as $i => $ch) {
		$responses[$i] = curl_multi_getcontent($ch);
		curl_multi_remove_handle($multi, $ch);
		curl_close($ch);
	}

	curl_multi_close($multi);
	
	echo json_encode($responses);
	wp_die();
}

// load demo blobs
function softaculous_pro_stream_iframes() {
	
	$setup_info = softaculous_pro_get_option_setup_info();
	
	if(empty($setup_info['mode']) || $setup_info['mode'] !== 'ai'){
		echo json_encode(['error' => 'AI Mode is not enabled !']);
		wp_die();
	}
	
	set_time_limit(0);
	
	// Disable all output buffering that might break chunked streaming
	while (ob_get_level() > 0) {
		ob_end_clean();
	}
	ob_implicit_flush(true);

	// Security checks
	if (!isset($_POST['softaculous_pro_nonce']) || !wp_verify_nonce($_POST['softaculous_pro_nonce'], 'softaculous_pro_ajax')) {
		echo "DATA::" . json_encode(['error' => 'Invalid nonce']) . "\n";
		exit;
	}

	if (!current_user_can('activate_plugins')) {
		echo "DATA::" . json_encode(['error' => 'You are not allowed here!']) . "\n";
		exit;
	}
	
	/* Example
		$urls = array{
			'template_name/page' => 'template_name/URL'
		}
	*/
	// Parse and validate URLs
	$urls = isset($_POST['urls']) ? json_decode(stripslashes($_POST['urls']), true) : [];

	if (!is_array($urls) || empty($urls)) {
		echo "DATA::" . json_encode(['error' => 'No URLs provided']) . "\n";
		exit;
	}

	$timeout = 300;
	$multi = curl_multi_init();
	$handles = [];

	foreach ($urls as $index => $url) {
		
		// If URL not provided
		// Also support for page
		if(!wp_http_validate_url($url)){
			$page = ($url != $index) ? $index : 'home';
			$url = softaculous_pro_ai_demo_url($url, '', $page);
		}
		
		$clean_url = esc_url_raw($url);
		$ch = curl_init($clean_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_multi_add_handle($multi, $ch);
		$handles[$index] = $ch;
		$urls[$index] = $clean_url;
	}

	$running = null;

	do {
		curl_multi_exec($multi, $running);
		while ($info = curl_multi_info_read($multi)) {
			$handle = $info['handle'];
			$index = array_search($handle, $handles);
			$content = curl_multi_getcontent($handle);
			$error = curl_error($handle);
		
			$parts = parse_url($urls[$index]);
			parse_str($parts['query'], $query);
			$tpage = !empty($query['tpage']) ? $query['tpage'] : 'home';
			$slug = !empty($query['template_preview']) ? $query['template_preview'] : $index ;

			$result = [
				'index' => $index,
				'url' => $urls[$index],
				'page' => $tpage,
				'slug' => $slug,
				'success' => $error === '',
				'html' => $error ? "<h1>Failed to load iframe: $error</h1>" : $content
			];

			echo "DATA::" . json_encode($result) . "\n";
			flush();
			ob_flush();

			curl_multi_remove_handle($multi, $handle);
			curl_close($handle);
		}
		usleep(100000);
	} while ($running > 0);

	curl_multi_close($multi);
	exit;
}

// Get all generated templates templates
function softaculous_pro_ai_fetch_templates_data($desc = '', $images = []) {
	global $softaculous_pro;
	
	$api_url = SOFTACULOUS_PRO_AI_DEMO . 'wp-json/softwpai/v1/get/templates';
	$license = ( isset($softaculous_pro['license']) && isset($softaculous_pro['license']['license'])
			? $softaculous_pro['license']['license'] : ''
		);
	
	$args = [
		'headers' => ['Content-Type' => 'application/json'],
		'body' => json_encode([
			'description' => $desc, 
			'images' => $images, 
			'site_title' => get_bloginfo('name'),
			'license' => $license,
			'url' => site_url()
		]),
		'method'  => 'POST',
	];

	$response = wp_remote_post($api_url, $args);

	if (is_wp_error($response)) {
		error_log('API Request Error: ' . $response->get_error_message());
		return $response;
	}
	
	$body = wp_remote_retrieve_body($response);
	$data = json_decode($body, true);
	
	if(isset($data['code'])) { 
		return $response;
	}
	
	return $data;
}

// Get suggestions for image tags
function softaculous_pro_ai_image_tags_suggestions($desc = ''){
	
	$data = [
		'request_type' => 'builder_tags',
		'business_desc' => $desc,
	];

	$suggestions = softaculous_pro_generate_ai_content($data);
	
	if(is_array($suggestions)){
		return $suggestions;
	}

	return [];
}

function softaculous_pro_get_options(){
	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');
	$options = softaculous_pro_get_option_setup_info();
	wp_send_json($options);
}

function softaculous_pro_get_setup_info(){

	check_ajax_referer('softaculous_pro_ajax', 'softaculous_pro_nonce');

	$slug = isset($_POST['slug']) ? sanitize_text_field($_POST['slug']) : '';
	$setup_info = softaculous_pro_get_option_setup_info();

	if(isset($setup_info) && !empty($setup_info[$slug])){
		wp_send_json_success($setup_info[$slug]);
	} else {
		wp_send_json_error(__('Setup information not found.', 'softaculous-pro'));
	}
}

function spro_install_required_plugin($slug, $plugin, $pro = 0){
	
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	require_once ABSPATH . 'wp-admin/includes/update.php';	
	include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	$res = array();
	
	try{
		if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin['plugin_init'] ) && is_plugin_inactive( $plugin['plugin_init'] ) ) {
			activate_plugin($plugin['plugin_init']);
			$res['success'] = __("Plugin activated successfully.", 'softaculous-pro');
		}
		elseif ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin['plugin_init'] ) ){
			
			if (!empty($plugin['requires_php']) && version_compare(PHP_VERSION, $plugin['requires_php'], '<')) {
				throw new Exception(sprintf(__('Plugin installation failed. %1$s requires PHP version %2$s or higher. Your PHP version is %3$s.', 'softaculous-pro'),
					$plugin['plugin_name'],
					$plugin['requires_php'],
					PHP_VERSION
				));
			}
			
			if(!empty($plugin['plugin_download_url'])){
				$download_url = $plugin['plugin_download_url'];
			}else{
				$api = plugins_api(
					'plugin_information',
					array(
							'slug'   => sanitize_key( wp_unslash( $slug ) ),
							'fields' => array(
								'sections' => false,
							),
						)
					);
				$download_url = $api->download_link;
			}
			
			$skin = new WP_Ajax_Upgrader_Skin();
			$upgrader = new Plugin_Upgrader( $skin );
			$result   = $upgrader->install($download_url);
				
			if ( is_wp_error($result) ) {
				throw new Exception(sprintf(__('%1$s Plugin installation failed. %2$s', 'softaculous-pro'), $plugin['plugin_name'], $result->get_error_message()));
			}
			elseif ( is_wp_error( $skin->result ) ) {
				throw new Exception(sprintf(__('%1$s Plugin installation failed. %2$s', 'softaculous-pro'), $plugin['plugin_name'], $skin->result->get_error_message()));
			} 
			elseif ( $skin->get_errors()->has_errors() ) {
				throw new Exception(sprintf(__('%1$s Plugin installation failed. %2$s', 'softaculous-pro'), $plugin['plugin_name'], implode(', ', $skin->get_error_messages())));
			} else {
				activate_plugin($plugin['plugin_init']);
				$res['success'] = __('Plugin installed and activated successfully.', 'softaculous-pro');
			}
		}else{
			$res['success'] = __("Plugin already installed.", 'softaculous-pro');
		}
	}
	catch( Exception $e){
		$res['error']  = $e->getMessage();
	}
	
	// Do we need to install the pro plugin as well ?
	if(empty($pro)){
		if(!empty($plugin['pro']) && !empty($plugin['plugin_download_url_pro'])){
			$plugin['plugin_download_url'] = softaculous_pro_add_params($plugin['plugin_download_url_pro']);
			$plugin['plugin_init'] = $plugin['plugin_init_pro'];
			$res['pro'] = spro_install_required_plugin($slug, $plugin, 1);
		}
	}
	
	return $res;
}

function spro_install_required_theme($slug, $theme = array()){
	
	$res = [];
	
	try {

		// Check if user is an admin and has appropriate permissions
		if(!current_user_can('install_themes')){
			throw new Exception(__("You do not have enough permissions to install theme", 'softaculous-pro'));
			return [];
		}

		if(!empty($theme['theme_download_url'])){
			$download_url = $theme['theme_download_url'];
		}else{
			$api = themes_api(
				'theme_information',
				array(
						'slug'   => sanitize_key( wp_unslash( $slug ) ),
						'fields' => array(
							'sections' => false,
							'downloadlink' => true,
						),
					)
				);
			$download_url = $api->download_link;
		}

		$theme_name = $slug;

		if(wp_get_theme($theme_name)->exists()){
			
			// Activate the theme
			switch_theme($theme_name);
			$res['success'] = __("Theme activated successfully.", 'softaculous-pro');
			
			return $res;
		}

		// Use WP Filesystem API to manage theme installation
		if(!function_exists('WP_Filesystem')){
			require_once(ABSPATH . 'wp-admin/includes/file.php');
		}

		// Check if FTP is required
		ob_start();
		$credentials = request_filesystem_credentials('');
		ob_end_clean();

		if(false === $credentials || !WP_Filesystem($credentials)){
			$res['error'] = __('The filesystem could not write files to the server!', 'softaculous-pro');
			return $res;
		}

		global $wp_filesystem;

		// The directory where themes are installed
		$theme_dir = $wp_filesystem->wp_themes_dir();

		// Download the theme zip file
		$theme_zip = download_url($download_url);

		// Check for errors during download
		if(is_wp_error($theme_zip)){
			throw new Exception(sprintf(__('Error downloading theme: %1$s', 'softaculous-pro'), $theme_zip->get_error_message()));
		}

		// Unzip the downloaded theme file
		$unzip_result = unzip_file($theme_zip, $theme_dir);

		// Check for errors during unzip
		if(is_wp_error($unzip_result)){
			throw new Exception(sprintf(__('Error unzipping theme: ', 'softaculous-pro'), $unzip_result->get_error_message()));
		}

		// Delete the temporary zip file
		unlink($theme_zip);

		// Activate the theme after installation
		switch_theme($theme_name);
	}catch(\Exception $e){
		$res['error'] = __('Theme installation failed ', 'softaculous-pro') . $e->getMessage();
		return $res;
	}

	$res['success'] = __("Theme installed and activated successfully.", 'softaculous-pro');

	return $res;
}

// This is to replace the image variables for the template URL
function softaculous_pro_pagelayer_start_insert_content($post){
	
	$url = popularfx_templates_dir_url().'/'.$GLOBALS['softaculous_pro_template_import_slug'].'/';
	
	$replacers['{{theme_url}}/images/'] = $url.'images/';
	$replacers['{{theme_url}}'] = $url;
	$replacers['{{theme_images}}'] = $url.'images/';
	$replacers['{{themes_dir}}'] = dirname(get_stylesheet_directory_uri());
	
	foreach($replacers as $key => $val){
		$post['post_content'] = str_replace($key, $val, $post['post_content']);
	}
		
	return $post;
	
}

add_filter( 'pagelayer_pre_get_import_contents', 'softaculous_pro_pre_get_import_contents', 10, 2);
function softaculous_pro_pre_get_import_contents($return, $path ){
	global $softaculous_pro;

	// Get file name without extention
	$file = preg_replace('/\.pgl$/i', '', basename($path));
	
	if(empty($softaculous_pro['ai_pages_to_import']) || empty($softaculous_pro['ai_pages_to_import'][$file])){
		return $return;
	}
	
	$updated_content = softaculous_pro_download_external_images($softaculous_pro['ai_pages_to_import'][$file]);
	return $updated_content;
}

// Add tmp attribute to block code
function softaculous_pro_extract_img_atts($content){
	
	$blocks = parse_blocks( $content );
	
	$el_atts = array();
	foreach( $blocks as $block ){
		$block_name = $block['blockName'];
		
		// Is pagelayer block
		if( is_string( $block_name ) && 0 === strpos( $block_name, 'pagelayer/' ) ){
			softaculous_pro_parse_img_atts($block, $el_atts);
		}
	}
		
	return array_filter($el_atts);
}

function softaculous_pro_parse_img_atts($block, &$el_atts){
	global $pagelayer;
	
	// Load shortcode
	pagelayer_load_shortcodes();
	
	// TODO: if empty then assign id and updated content
	if(empty($block['attrs']['pagelayer-id'])){
		return;
	}
	
	// If block saved by Pagelayer Editor
	if(in_array( $block['blockName'], ['pagelayer/pl_inner_col', 'pagelayer/pl_inner_row'])){
		$block['blockName'] = str_replace('inner_', '', $block['blockName']);
	}
	
	$tag = substr( $block['blockName'], 10 );
	$pl_tag = str_replace('-', '_', $tag);
	
	if(isset($pagelayer->shortcodes[$pl_tag])){
	
		// Create attribute Object
		$pl_props = $pagelayer->shortcodes[$pl_tag];
		$pl_id = $block['attrs']['pagelayer-id'];
		$el_atts[$pl_id] = array();
		
		foreach($pagelayer->tabs as $tab){
			
			if(empty($pl_props[$tab])){
				continue;
			}
			
			foreach($pl_props[$tab] as $section => $_props){
				
				$props = !empty($pl_props[$section]) ? $pl_props[$section] : $pagelayer->styles[$section];
				
				if(empty($props)){
					continue;
				}
				
				// Reset / Create the cache
				foreach($props as $prop => $param){
					
					// No value set
					if(empty($block['attrs'][$prop]) || (isset($param['ai']) && $param['ai'] === false) || (is_string($block['attrs'][$prop]) && strlen(trim($block['attrs'][$prop])) < 1)){
						continue;
					}
					
					// Is image?
					if(!empty($param['type']) && $param['type'] == 'image'){
						$el_atts[] = $block['attrs'][$prop];
					}
					
					// Is multi_image?
					if(!empty($param['type']) && $param['type'] == 'multi_image'){
						$el_atts[] = $block['attrs'][$prop];
					}
					
				}
			}
		}
		
	}
		
	// This have innerBlocks
	if(!empty($block['innerBlocks'])){
		foreach($block['innerBlocks'] as $key => $inner_block){
			softaculous_pro_parse_img_atts($inner_block, $el_atts);
		}
	}
	
}

// Download external images like pexels
function softaculous_pro_download_external_images($content) {
	global $pagelayer;
	
	if (empty($content)){ 
		return $content;
	}

	if (defined('PAGELAYER_BLOCK_PREFIX') && PAGELAYER_BLOCK_PREFIX == 'wp') {
		$content = str_replace('<!-- sp:pagelayer', '<!-- wp:pagelayer', $content);
		$content = str_replace('<!-- /sp:pagelayer', '<!-- /wp:pagelayer', $content);
	}

	if(!pagelayer_has_blocks($content)) return $content;
			
	$img_data = softaculous_pro_extract_img_atts($content);
	
	if(empty($img_data) || !is_array($img_data)){
		return $content;
	}
	 
	foreach($img_data as $image_url) {
		$imgUrls = is_string($image_url) ? explode(',', $image_url) : (is_array($image_url) ? $image_url : []);
		foreach($imgUrls as $url){
			if(!is_string($url)){
				continue;
			}
			
			$url = trim($url);
			
			// Caching the image
			if(strpos($url, 'https://images.pexels.com/photos/') === false || isset($pagelayer->import_media[$url])){
				continue;
			}

			// Get ilename
			$filename = basename(strtok($url, '?'));
			
			// We are going to create a loop to find the image
			for($i = 1; $i <= 3; $i++){
				// Upload the image
				$ret = pagelayer_upload_media($filename, file_get_contents($url));
				
				// Lets check the file exists ?
				if(!empty($ret)){
					
					// Lets check if the file exists
					$tmp_image_path = pagelayer_cleanpath(get_attached_file($ret));
					
					// If the file does not exist, simply delete the old upload as well
					if(!file_exists($tmp_image_path)){
						wp_delete_attachment($ret, true);
						$ret = false;
					
					// The image does exist and we can continue
					}else{
						break;
					}
					
				}
			}
			
			if(empty($ret)){
				continue;
			}
			
			// This replaces images when inserting content
			$pagelayer->import_media[$url] = $ret;
			
			$imgs_json = array('sitepad_img_source' => 'pexels.com', 'sitepad_download_url' => $url, 'sitepad_img_lic' => '');
			$fields = array('sitepad_img_source', 'sitepad_download_url', 'sitepad_img_lic');
			
			foreach($fields as $field){
				if(!empty($imgs_json[$field])){
					update_post_meta($ret, $field, $imgs_json[$field]);
				}
			}
		}
	}

	return $content;
}

add_filter( 'pagelayer_prepare_template_import_data', 'softaculous_pro_template_import_data', 10, 2);
function softaculous_pro_template_import_data($data, $name ){
	global $softaculous_pro;
	
	if(empty($softaculous_pro['ai_pages_to_import'])){
		return $data;
	}
	
	if(isset($data['post'])){
		unset($data['post']);
	}
	
	return $data;
}

if(!function_exists('softaculous_pro_templates')){

// The Templates Page
function softaculous_pro_templates($ai = false){

	global $softaculous_pro, $pl_error, $spro_setup_info;
	
	$softaculous_pro['templates'] = softaculous_pro_get_templates_list();

	$spro_setup_info = softaculous_pro_get_option_setup_info();
	
	if(isset($_REQUEST['install'])){
		check_admin_referer('softaculous-pro-template');
	}

	// Is there a license key ?
	if(isset($_POST['install'])){
		
		$done = 1;
		
	}

	softaculous_pro_templates_T();

}

// The License Page - THEME
function softaculous_pro_templates_T(){
	
	global $softaculous_pro, $pagelayer, $pl_error, $spro_setup_info;
	$setup_info = softaculous_pro_get_option_setup_info();

	// Any errors ?
	if(!empty($pl_error)){
		pagelayer_report_error($pl_error);echo '<br />';
	}
	
?>

<div id="softaculous_pro_theme_title" style="display:flex; justify-content:space-between; align-item:center; margin-bottom:40px;">
	<h1 style="text-align:center;"><?php _e('Choose a design', 'softaculous-pro'); ?></h1>
	<div class="softaculous-switch-template-mode" style="display:none">
		<div class="softaculous-template-mode-ai <?php echo ($spro_setup_info['mode'] == 'ai' ? 'active_mode' : ''); ?>" data-mode='ai'>
			<span><?php _e('AI', 'softaculous-pro'); ?></span>
			<div class="softaculous-template-mode-tooltip"><?php _e('AI generated templates', 'softaculous-pro')?></div>
		</div>

		<div class="softaculous-template-mode-manual <?php echo ($spro_setup_info['mode'] == 'manual' ? 'active_mode' : ''); ?>" data-mode='manual'>
			<span><?php _e('Manual', 'softaculous-pro'); ?></span>
			<div class="softaculous-template-mode-tooltip"><?php _e('Pre-designed templates', 'softaculous-pro')?></div>
		</div>

	</div>
</div>
<div id="softaculous_pro_search" class="softaculous-pro-row" style="margin-bottom:40px">
	<div class="softaculous-pro-ai-search <?php echo ($spro_setup_info['mode'] == 'manual' ? 'manual-mode' : '');?>"> 
		<input type="text" class="softaculous-pro-search-field" placeholder="<?php _e('Search for theme', 'softaculous-pro'); ?>" />	
		<div id="softaculous-pro-suggestion" style="<?php echo esc_attr(($spro_setup_info['mode'] == 'manual' ? 'display:block' : 'display:none')); ?>"></div>
	</div>
	<div class="softaculous-pro-dropdown softaculous-pro-categories" style="<?php echo esc_attr($spro_setup_info['mode'] == 'manual' ? 'display:flex' : 'display:none'); ?>">
		<div class="softaculous-pro-current-cat"><?php _e('All', 'softaculous-pro'); ?></div><span class="dashicons dashicons-arrow-down-alt2"></span>
		<div class="softaculous-pro-dropdown-content"><div class="softaculous-pro-cat-holder softaculous-pro-row" style="justify-content:flex-start;"></div></div>
	</div>

</div>
<div class="softaculous-pro-page" id="softaculous-pro-templates-holder" >
	<div id="softaculous-pro-templates" class="softaculous-pro-row" style="justify-content:flex-start" data-type="<?php echo esc_attr($spro_setup_info['mode'] == 'manual' ? 'manual' : 'ai'); ?>">
		<p class="softaculous-pro-theme-loading" style="order: 9999; font-size:19px; width:100%;"><?php _e('More themes will load after the above themes are loaded') ?> ...</p>
	</div>
	<div id="softaculous-pro-single-template">
		<div class="softaculous-pro-single-template-header" style="margin-bottom: 20px; margin-top: 10px;  text-align: left;">
			<h1 style="display: inline-block;margin: 0px;vertical-align: middle;" id="softaculous-pro-template-name"></h1>
			<?php if (empty($softaculous_pro['branding']['rebranded'])): ?>
				<a href="" id="softaculous-pro-demo" class="button softaculous-pro-demo-btn" target="_blank"><?php _e('Demo', 'softaculous-pro'); ?></a>
			<?php endif; ?>
		</div>
		<div style="margin: 0px; vertical-align: top;" class="single-template-div">
			<div class = "softaculous-pro-iframe-container" style="text-align: center;  position:relative; width:80%;">
				<div style="width: 100%; max-height: 750px; overflow: auto; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" class="single-templates-content">
					<div class="softaculous-pro-loader-container">
						<div class="softaculous-pro-loader"></div>
					</div>
					<img id="softaculous_pro_display_image" src="" width="100%" style="position: relative; z-index: 2;" >
					<div class="softaculous-pro-theme-iframe" style="width: 100%; height: 650px; overflow: hidden; position: relative;" style="<?php echo esc_attr(!empty($spro_setup_info['is_manual']) ? 'display:none' : 'display:block'); ?>">
					</div>
				</div>
			</div>
			<div class="softaculous_pro_single_content">
				<h1 style="font-size:16px;"><?php _e('Select pages to import', 'softaculous-pro'); ?></h1><br />
				<div id="softaculous_pro_screenshots"></div>
				<div class="softaculous_pro_import_img_notice">
					<form id="softaculous-pro-import-form" method="post" enctype="multipart/form-data">
						<?php wp_nonce_field('softaculous-pro-template');?>
						<input name="theme" id="softaculous-pro-template-install" value="" type="hidden" />
						<input type="checkbox" name="download_imgs" id="download_imgs" value="1" checked/> <label for="download_imgs" class="spro-tool-tip" style="cursor:pointer;"><?php _e('Import stock images ?', 'softaculous-pro'); ?></label><br />
						<i>
							<?php _e('We try our best to use images that are free to use from legal perspectives. However, we are not liable for any copyright infringement for your site.', 'softaculous-pro'); ?>
						</i>
						<input name="install" value="1" type="hidden" />
					</form>
				</div>
			</div>
		</div>

		<div style="position:fixed; bottom: 15px; right: 20px; z-index: 10;">
			<div class="button button-softaculous-pro softaculous-pro-back"  style="display:none;"><?php _e('Go Back', 'softaculous-pro'); ?></div>&nbsp;
			<input name="import_theme" class="button button-softaculous-pro" id="spro_import_content" value="<?php _e('Import Theme Content', 'softaculous-pro'); ?>" type="button" onclick="softaculous_pro_modal('#SproTemplatesModal', true)" style="display:none;" <?php echo esc_attr(empty($spro_setup_info['is_manual']) ? 'disabled' : ''); ?>/> &nbsp;
		</div>
	</div>
</div>

<!-- The Modal -->
<div id="SproTemplatesModal" class="softaculous-pro-modal">

	<!-- Modal holder -->
	<div class="softaculous-pro-modal-holder">

		<!-- Modal header -->
		<div class="softaculous-pro-modal-header">
			<h1><?php _e('Import Theme Contents', 'softaculous-pro'); ?></h1> 
			<!-- <span class="softaculous-pro-modal-close">&times;</span> -->
		</div>
		<!-- Modal content -->
		<div class="softaculous-pro-modal-content">
			<div class="softaculous-pro-import">
				<div id="softaculous-pro-error-template"></div>
				<div id="softaculous-pro-progress-template">
					<img src="<?php echo esc_attr(SOFTACULOUS_PRO_PLUGIN_URL) .'assets/images/progress.svg';?>" width="20" /> <span id="softaculous-pro-progress-txt"></span>
				</div>
			</div>
			<div class="softaculous-pro-done" style="display: block;">
				<h3 style="margin-top: 0px;"><?php _e('Congratulations, the template was imported successfully !', 'softaculous-pro'); ?></h3>
				<?php _e('You can now customize the website as per your requirements with the help of Pagelayer or the Customizer.', 'softaculous-pro')
				.'<br /><br />
				<b>Note</b> : '.
				_e('We strongly recommend you change all images and media. We try our best to use images which are copyright free or are allowed under their licensing. However, we take no responsibilities for the same and recommend you change all media and images !', 'softaculous-pro'); ?>
			</div>
		</div>
		
		<!-- Modal footer -->
		<div class="softaculous-pro-modal-footer">
			<div class="softaculous-pro-done">
				<a class="button softaculous-pro-demo-btn" href="<?php echo site_url();?>" target="_blank"><?php _e('Visit Website', 'softaculous-pro'); ?></a> &nbsp;&nbsp;
				<a class="button softaculous-pro-demo-btn" href="<?php echo admin_url();?>" target="_blank"><?php _e('WordPress Dashboard', 'softaculous-pro'); ?></a> &nbsp;&nbsp;
				<a class="button softaculous-pro-demo-btn" href="<?php echo admin_url('admin.php?page=assistant');?>" target="_blank"><?php _e('Assistant', 'softaculous-pro'); ?></a>
			</div>
		</div>
	</div>

</div>

<script>

var softaculous_pro_setup_info = <?php echo json_encode(!empty($spro_setup_info) ? $spro_setup_info : array()); ?>;
var softaculous_pro_is_manual = softaculous_pro_setup_info['is_manual'] || false;
var softaculous_pro_ajax_nonce = '<?php echo wp_create_nonce('softaculous_pro_ajax');?>';
var softaculous_pro_ajax_url = '<?php echo admin_url( 'admin-ajax.php' );?>?&';
var softaculous_pro_demo = 'https://demos.popularfx.com/';

softaculous_pro_templates = <?php echo json_encode($softaculous_pro['templates']);?>;
var themes = softaculous_pro_templates['list'];
var categories = softaculous_pro_templates['categories'];
var mirror = '<?php echo softaculous_pro_sp_api_url("-1");?>files/themes/';
var softaculous_pro_pending_iframeCount = 0;
var softaculous_pro_iframe_loadtimeout;
</script>

<?php

}

}
