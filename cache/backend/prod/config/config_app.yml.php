<?php
// auto-generated by sfDefineEnvironmentConfigHandler
// date: 2010/11/15 13:28:57
sfConfig::add(array(
  'app_sfImageTransformPlugin_default_adapter' => 'ImageMagick',
  'app_sfImageTransformPlugin_default_image' => array (
  'mime_type' => 'image/png',
  'filename' => 'Untitled.png',
  'width' => 100,
  'height' => 100,
  'color' => '#FFFFFF',
),
  'app_sfImageTransformPlugin_font_dir' => '/usr/share/fonts/truetype/msttcorefonts',
  'app_sfImageTransformPlugin_mime_type' => array (
  'auto_detect' => true,
  'library' => 'gd_mime_type',
),
  'app_sfInvoiceGenerationPlugin_invoice_dir' => 'sfInvoiceGenerationPlugin/html_invoices/',
  'app_sf_captchagd_image_width' => 120,
  'app_sf_captchagd_image_height' => 35,
  'app_sf_captchagd_chars' => '1234567890',
  'app_sf_captchagd_length' => 4,
  'app_sf_captchagd_font_size' => 18,
  'app_sf_captchagd_force_new_captcha' => false,
  'app_sf_captchagd_font_color' => array (
  0 => 'FFFFFF',
),
  'app_sf_captchagd_fonts' => array (
  0 => 'whoobub/WHOOBUB_.TTF',
),
  'app_sf_captchagd_background_color' => '5D5D5D',
  'app_sf_captchagd_border_color' => 0,
  'app_facebook_api_key' => 'xxx',
  'app_facebook_api_secret' => 'xxx',
  'app_facebook_api_id' => 'xxx',
  'app_facebook_redirect_after_connect' => false,
  'app_facebook_redirect_after_connect_url' => '',
  'app_facebook_connect_signin_url' => 'sfFacebookConnectAuth/signin',
  'app_facebook_app_url' => '/my-app',
  'app_facebook_guard_adapter' => NULL,
  'app_facebook_js_framework' => 'none',
  'app_sf_guard_plugin_profile_class' => 'sfGuardUserProfile',
  'app_sf_guard_plugin_profile_field_name' => 'user_id',
  'app_sf_guard_plugin_profile_facebook_uid_name' => 'facebook_uid',
  'app_sf_guard_plugin_profile_email_name' => 'email',
  'app_sf_guard_plugin_profile_email_hash_name' => 'email_hash',
  'app_sf_guard_plugin_routes_register' => false,
  'app_facebook_connect_load_routing' => true,
  'app_facebook_connect_user_permissions' => array (
),
));
