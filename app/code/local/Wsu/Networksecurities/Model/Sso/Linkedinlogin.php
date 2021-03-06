<?php
class Wsu_Networksecurities_Model_Sso_Linkedinlogin extends Zend_Oauth_Consumer{
	protected $_options = null;
	
	var $_providerName = 'linkedin';		
	public function getConsumerKey() {
		return trim(Mage::getStoreConfig('wsu_networksecurities/linkedin_login/app_id'));
	}
	public function getConsumerSecret() {
		return trim(Mage::getStoreConfig('wsu_networksecurities/linkedin_login/secret_key'));
	}
	
	public function __construct() {
		$this->_config = new Zend_Oauth_Config;		
		$this->_options = array(
			'consumerKey'       => $this->getConsumerKey(),
			'consumerSecret'    => $this->getConsumerSecret(),
			'version'           => '1.0',
			'requestTokenUrl'   => 'https://api.linkedin.com/uas/oauth/requestToken?scope=r_emailaddress',
			'accessTokenUrl'    => 'https://api.linkedin.com/uas/oauth/accessToken',
			'authorizeUrl'      => 'https://www.linkedin.com/uas/oauth/authenticate'
		);
		$this->_config->setOptions($this->_options);
	}
	public function setCallbackUrl($url) {
		$this->_config->setCallbackUrl($url);
	}
	public function getOptions() {
		return $this->_options ;
	}
	public function getLaunchUrl($account=null) {
		$queries = array();
		if(isset($account)){
			$queries['account']=$account;
		}
		return Mage::getUrl("sociallogin/linkedinlogin/login",$queries);
	}
	
	public function getUser(){}
	public function getLoginUrl($name="") {}
    public function setIdlogin($openid) {}
	
}