<?php
class Wsu_Networksecurities_Model_Customer_Source_Ssooptions extends Mage_Eav_Model_Entity_Attribute_Source_Abstract {
    
    public function getAllOptions() {
		$helper = Mage::helper('wsu_networksecurities');
        if (is_null($this->_options)) {
            $this->_options = array(
				array('value'=>'aol', 'label'=> $helper->__('Aol')),
				array('value'=>'facebook', 'label'=> $helper->__('Facebook')),
				array('value'=>'twitter', 'label'=> $helper->__('Twitter')),
				array('value'=>'google', 'label'=> $helper->__('Google')),
				array('value'=>'linkedin', 'label'=> $helper->__('LinkedIn')),
				array('value'=>'yahoo', 'label'=> $helper->__('Yahoo')),
				array('value'=>'wordpress', 'label'=> $helper->__('WordPress')),
				array('value'=>'myopenid', 'label'=> $helper->__('MyOpenId')),
				array('value'=>'livejournal', 'label'=> $helper->__('Livejournal')),
				array('value'=>'clavid', 'label'=> $helper->__('Clavid')),
				array('value'=>'orange', 'label'=> $helper->__('Orange')),
				array('value'=>'foursquare', 'label'=> $helper->__('Foursquare')),
				array('value'=>'live', 'label'=> $helper->__('Windows Live')),
				array('value'=>'myspace', 'label'=> $helper->__('MySpace')),
				array('value'=>'persona', 'label'=> $helper->__('Persona')),
				array('value'=>'stackexchange', 'label'=> $helper->__('Stack Exchange')),
            );
        }
        return $this->_options;
    }
    public function toOptionArray() {
        return $this->getAllOptions();
    }
    public function addValueSortToCollection($collection, $dir = 'asc') {
        $adminStore  = Mage_Core_Model_App::ADMIN_STORE_ID;
        $valueTable1 = $this->getAttribute()->getAttributeCode() . '_t1';
        $valueTable2 = $this->getAttribute()->getAttributeCode() . '_t2';
        $collection->getSelect()->joinLeft(
            array($valueTable1 => $this->getAttribute()->getBackend()->getTable()),
            "`e`.`entity_id`=`{$valueTable1}`.`entity_id`"
            . " AND `{$valueTable1}`.`attribute_id`='{$this->getAttribute()->getId()}'"
            . " AND `{$valueTable1}`.`store_id`='{$adminStore}'",
            array()
        );
        if ($collection->getStoreId() != $adminStore) {
            $collection->getSelect()->joinLeft(
                array($valueTable2 => $this->getAttribute()->getBackend()->getTable()),
                "`e`.`entity_id`=`{$valueTable2}`.`entity_id`"
                . " AND `{$valueTable2}`.`attribute_id`='{$this->getAttribute()->getId()}'"
                . " AND `{$valueTable2}`.`store_id`='{$collection->getStoreId()}'",
                array()
            );
            $valueExpr = new Zend_Db_Expr("IF(`{$valueTable2}`.`value_id`>0, `{$valueTable2}`.`value`, `{$valueTable1}`.`value`)");
        } else {
            $valueExpr = new Zend_Db_Expr("`{$valueTable1}`.`value`");
        }
        $collection->getSelect()
            ->order($valueExpr, $dir);
        return $this;
    }
    public function getFlatColums() {
        $columns = array(
            $this->getAttribute()->getAttributeCode() => array(
                'type'      => 'varchar',
                'unsigned'  => false,
                'is_null'   => true,
                'default'   => null,
                'extra'     => null
            )
        );
        return $columns;
    }
    public function getFlatUpdateSelect($store)  {
        return Mage::getResourceModel('eav/entity_attribute')
            ->getFlatUpdateSelect($this->getAttribute(), $store);
    }
}
