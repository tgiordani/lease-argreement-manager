<?php

/**
 * @package LeaseAgreementManagerPlugin
 */

/*
Plugin Name: Lease Agreement Manager for Essential Real Estate
Plugin URI: http://www.the-computer-guy.com
Description: This is a plugin to enable managing, creating and logging lease agreements while assigning them to users of a specified type
Version: 1.0.0
Author: Aperture Indigo
Author URI: http://www.the-computer-guy.com
License: GPLv2 or later
Text Domain: lease-agreement-manager
 */

defined( 'ABSPATH' ) or die('You do not have permission to view this file.');

class LeaseAgreementPlugin
{
  // Public - Can be accessed everywhere

  // Protected - Can be accessed only within the class itself or extentions of that class

  // Private- Can be accessed only within the class itself

  function __construct() {
    //$this->print_stuff();
  }

  function register() {

  }

  protected function create_post_type() {
    add_action( 'init', array( $this, 'lease_agreements'));
  }

  function lease_agreements() {
    // Code to be run when LeaseAgreementPlugin is created
    register_post_type( 'lease_agreement', ['public' => true,
                                            'label' => 'Lease Agreements',
                                            'menu_icon' => 'dashicons-id-alt'], 10 );

  }

  function enqueue(){
    // Enqueue all our scripts and styles
    // My Styles - CSS
    wp_enqueue_style( 'mypluginstyle', plugins_url( '/assets/mystyle.css', __FILE__ ) );
    // Bootstrap - CSS
    wp_enqueue_style( 'mypluginbootstrapcss', plugins_url( '/assets/bootstrap.min.css', __FILE__ ) );
    // My Scripts - Javascript
    wp_enqueue_script( 'mypluginscript', plugins_url( '/assets/myscript.js', __FILE__ ) );
    // Bootstrap - Javascript
    wp_enqueue_script( 'mypluginbootstrapjs', plugins_url( '/assets/bootstrap.min.js', __FILE__ ) );
  }

  private function print_stuff() {
    echo 'Test.';
  }

  function activate() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/lease-agreement-plugin-activate.php';
    LeaseAgreementManagerPluginActivate::activate();
  }
}

class SecondClass extends LeaseAgreementPlugin
{
  function register_post_type() {
    $this->create_post_type();
  }

  // private function print_more_stuff() {
  //   echo 'Test.';
  // }
  //
  // function print_it_all() {
  //   $this->print_more_stuff();
  // }

}

if( class_exists('LeaseAgreementPlugin')) {
  $leaseAgreementPlugin = new LeaseAgreementPlugin();
  $leaseAgreementPlugin->register();
}

$secondClass = new SecondClass();
$secondClass->register_post_type();
//$secondClass->print_it_all();

// activation

// -- Call the activation function from within the initialized class LeaseAgreementPlugin
register_activation_hook( __FILE__, array($leaseAgreementPlugin, 'activate'));
// -- Call the activation function statically from /includes/lease-agreement-plugin-activate.php
//register_activation_hook( __FILE__, array( 'LeaseAgreementManagerPluginActivate', 'activate'));

// deactivation
require_once plugin_dir_path( __FILE__ ) . 'includes/lease-agreement-plugin-deactivate.php';
// register_deactivation_hook( __FILE__, array($leaseAgreementPlugin, 'deactivate'));
register_deactivation_hook( __FILE__, array( 'LeaseAgreementManagerPluginDeactivate', 'deactivate'));

// Include the includes file which has includes for all files in the plugin
include ( plugin_dir_path( __FILE__ ) . 'includes.php');
