<?php
class Wsu_Networksecurities_Block_Sso_Ljlogin extends Mage_Core_Block_Template
{
	public function getLoginUrl() {
		return $this->getUrl('sociallogin/ljlogin/login');
		//return Mage::getModel('wsu_networksecurities/sso_mylogin')->getMyLoginUrl();
	}
    
    public function getSetBlock() {
        return $this->getUrl('sociallogin/ljlogin/setBlock');        
    }
	
	public function setBackUrl() {
		$currentUrl = Mage::helper('core/url')->getCurrentUrl();
		Mage::getSingleton('core/session')->setBackUrl($currentUrl);
		return $currentUrl;
	}
	
		
}