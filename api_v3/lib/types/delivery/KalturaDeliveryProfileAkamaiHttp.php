<?php
/**
 * @package api
 * @subpackage objects
 */
class KalturaDeliveryProfileAkamaiHttp extends KalturaDeliveryProfile {
	
	/**
	 * Should we use intelliseek
	 * 
	 * @var bool
	 * @filter eq,in
	 */
	public $useIntelliseek;
	
	private static $map_between_objects = array
	(
			"useIntelliseek",
	);
	
	public function getMapBetweenObjects ( )
	{
		return array_merge ( parent::getMapBetweenObjects() , self::$map_between_objects );
	}
	
	public function toObject($dbObject = null, $skip = array())
	{
		$this->type = KalturaDeliveryProfileType::AKAMAI_HTTP;
		return parent::toObject($dbObject, $skip);
	}
	
	public function fromObject($sourceObject) {
		parent::fromObject($sourceObject);
	}
}
