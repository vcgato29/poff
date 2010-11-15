<?php

/**
 * BannerFlash
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class BannerFlash extends BaseBannerFlash
{
	public function getEditForm(){
		return new BannerFlashForm( $this );
	}	
	
	public function renderForEditForm(){
		$cont =<<<EOD
			<embed {$this->getFlashVarsString()} width="{$this->width}" align="center" height="{$this->height}" type="application/x-shockwave-flash" swliveconnect="true" salign="center" allowscriptaccess="sameDomain" allowfullscreen="false" menu="false" name="7996" bgcolor="" devicefont="false" wmode="transparent" scale="" loop="true" play="true" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="/uploads/{$this->getFile()}">	
EOD;
		return $cont;
	}
	
	
	public function getFlashVarsString(){
		return "flashvars=\"clickTAG={$this->link}&{$this->flash_vars}\"";	
	}
	
	
	public function getPictureImg(){
		return '-';
	}
	
	
}