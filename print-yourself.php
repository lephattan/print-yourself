<?php
/**
 * Plugin Name: Print yourself
 * Plugin URI: #
 * Description: Woocommerce personalized products solition
 * Version: 1.0.0
 * Author: Tan Le
 * Author URI: #
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define('PRY_VERSION', '1.0.0');

 /**
 * Remote Update Section
 */

$pry_json = 'https://lephattan-ec35d.firebaseio.com/remote-update/print-yourself.json';

add_filter('plugins_api', 'pry_plugin_info', 20, 3);
/*
 * $res empty at this step 
 * $action 'plugin_information'
 * $args stdClass Object ( [slug] => woocommerce [is_ssl] => [fields] => Array ( [banners] => 1 [reviews] => 1 [downloaded] => [active_installs] => 1 ) [per_page] => 24 [locale] => en_US )
 */	
function pry_plugin_info( $res, $action, $args ){
	global $pry_json;
 
	// do nothing if this is not about getting plugin information
	if( $action !== 'plugin_information' )
		return false;
 
	// do nothing if it is not our plugin	
	if( 'print-yourself' !== $args->slug )
		return false;
 
	// trying to get from cache first
	if( false == $remote = get_transient( 'upgrade_print-yourself' ) ) {
 
		// info.json is the file with the actual plugin information on your server
		$remote = wp_remote_get( $pry_json, array(
			'timeout' => 10,
			'headers' => array(
				'Accept' => 'application/json'
			) )
		);
 
		if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
			set_transient( 'upgrade_print-yourself', $remote, 60*60*0.5); // 0.5h cache 
		}
 
	}
 
	if( $remote ) { 
		$remote = json_decode( $remote['body'] );
		$res = new stdClass();
		$res->name = $remote->name;
		$res->slug = $remote->resource;
		$res->version = $remote->version;
		$res->tested = $remote->tested;
		$res->requires = $remote->requires;
		$res->author = '<a href="'.$remote->author_url.'">'.$remote->name.'</a>';
		$res->author_profile = $remote->author_url;
		$res->download_link = str_replace("{version}", $remote->version, $remote->download_url);
		$res->trunk = $remote->download_url;
		$res->last_updated = $remote->last_updated;
		$res->sections = array(
			//'description' => $remote->sections->description,
			//'installation' => $remote->sections->installation,
			'changelog' => $remote->sections->changelog
			// you can add your custom sections (tabs) here 
		);
		if( !empty( $remote->sections->screenshots ) ) {
			$res->sections['screenshots'] = $remote->sections->screenshots;
		}
 
		//$res->banners = array(
		//	'low' => 'https://YOUR_WEBSITE/banner-772x250.jpg',
        //  'high' => 'https://YOUR_WEBSITE/banner-1544x500.jpg'
		//);
           	return $res;
 
	}
 
	return false;
 
}
add_filter('site_transient_update_plugins', 'pry_push_update' );
 
function pry_push_update( $transient ){
	global $pry_json;
 
	if ( empty($transient->checked ) ) {
            return $transient;
        }
 
	// trying to get from cache first
	if( false == $remote = get_transient( 'upgrade_print-yourself' ) ) {
 
		// info.json is the file with the actual plugin information on your server
		$remote = wp_remote_get( $pry_json, array(
			'timeout' => 10,
			'headers' => array(
				'Accept' => 'application/json'
			) )
		);
 
		if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
			set_transient( 'upgrade_print-yourself', $remote, 60*60*0.5 ); // 0.5h cache
		}
 
	}
 
	if( $remote ) {
 
		$remote = json_decode( $remote['body'] );
		if( $remote && version_compare( PRY_VERSION, $remote->version, '<' )
			&& version_compare($remote->requires, get_bloginfo('version'), '<' ) ) {
				$res = new stdClass();
				$res->slug = 'print-yourself';
				$res->plugin = 'print-yourself/print-yourself.php';
				$res->new_version = $remote->version;
				$res->tested = $remote->tested;
				$res->package = str_replace("{version}", $remote->version, $remote->download_url);
				$res->url = $remote->homepage;
				$res->compatibility = new stdClass();
           		$transient->response[$res->plugin] = $res;
           		//$transient->checked[$res->plugin] = $remote->version;
           	}
 
	}
        return $transient;
}

add_action( 'upgrader_process_complete', 'pry_after_update', 10, 2 );
 
function pry_after_update( $upgrader_object, $options ) {
	if ( $options['action'] == 'update' && $options['type'] === 'plugin' )  {
		delete_transient( 'upgrade_print-yourself' );
	}
}

include 'admin/option-page.php';
include 'includes/pry-main.php';