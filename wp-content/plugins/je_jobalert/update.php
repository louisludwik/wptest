<?php 

require_once dirname(__FILE__) . '/inc/inc.update.php';

class JE_Jobalert_Update extends ET_Plugin_Updater{
	const VERSION = '2.2';

	// setting up updater
	public function __construct(){
		$this->product_slug 	= plugin_basename( dirname(__FILE__) . '/je_alert.php' );
		$this->slug 			= 'je_alert';
		$this->license_key 		= get_option('et_license_key', '');
		$this->current_version 	= self::VERSION;
		$this->update_path 		= 'http://www.enginethemes.com/forums/?do=product-update&product=je_alert&type=plugin';

		parent::__construct();
	}
}

new JE_Jobalert_Update();

?>