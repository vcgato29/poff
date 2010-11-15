<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfImageTransformPlugin');
    

    
    $this->enablePlugins('sfDoctrineGuardPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
    
    $this->enablePlugins('sfInvoiceGenerationPlugin');
    $this->enablePlugins('sfFirePHPPlugin');
    $this->enablePlugins('sfCaptchaGDPlugin');
    
    $this->enablePlugins('sfFacebookConnectPlugin');
  }
  
  	public function configureDoctrine(Doctrine_Manager $manager)
	{
  		$options = array('baseClassName' => 'BaseDoctrineRecord');
  		sfConfig::set('doctrine_model_builder_options', $options);
		$manager->setCollate('utf8_unicode_ci');
  		$manager->setCharset('utf8');
	}
	

  ## ZEND
  static protected $zendLoaded = false;
 
  static public function registerZend()
  {
  	
    if (self::$zendLoaded)
    {
      return;
    }
 
    set_include_path(sfConfig::get('sf_lib_dir').'/vendor'.PATH_SEPARATOR.get_include_path());
    require_once sfConfig::get('sf_lib_dir').'/vendor/Zend/Loader/Autoloader.php';
    Zend_Loader_Autoloader::getInstance();
    self::$zendLoaded = true;


		Zend_Search_Lucene_Analysis_Analyzer::setDefault(
  new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive ()); 
  }
  
  ## DOMPDF
  static protected $dompdfLoaded = false;
  
  static public function registerDompdf()
  {
  	
  	if( self::$dompdfLoaded )
  		return;

    require_once sfConfig::get('sf_lib_dir').'/vendor/dompdf/dompdf_config.inc.php';
    self::$dompdfLoaded = true;
  	
  }
  
  
  
  
  ## HTML2PDF
  static protected $html2pdfLoaded = false;
  
  static public function registerHtml2pdf(){
  	
//  		if( self::$html2pdfLoaded )
//  			return;
//
//  		@require_once sfConfig::get('sf_lib_dir').'/vendor/html2pdf/config.inc.php';
//  		@require_once sfConfig::get('sf_lib_dir').'/vendor/html2pdf/pipeline.factory.class.php';
//  		@require_once sfConfig::get('sf_lib_dir').'/vendor/html2pdf/samples/sample.simplest.from.memory.php';
//		@parse_config_file( sfConfig::get('sf_lib_dir').'/vendor/html2pdf/html2ps.config');
		
  }
  
  





	
  
}
