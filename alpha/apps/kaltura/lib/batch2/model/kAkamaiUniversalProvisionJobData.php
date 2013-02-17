<?php
class kAkamaiUniversalProvisionJobData extends kProvisionJobData
{
	/**
	 * @var string
	 */
	protected $systemUserName;
	
	/**
	 * @var string
	 */
	protected $systemPassword;
	
	/**
	 * @var string
	 */
	protected $domainName;
	
	/**
	 * @var int
	 */
	protected $dvrEnabled;

	/**
	 * @var int
	 */
	protected $dvrWindow;
	
	/**
	 * @var string
	 */
	protected $primaryContact;
	
	/**
	 * @var string
	 */
	protected $secondaryContact;
	
	/**
	 * @var string
	 */
	protected $streamType;
	
	/**
	 * @var string
	 */
	protected $notificationEmail;

	/**
	 * @return the $notificationEmail
	 */
	public function getNotificationEmail() {
		return $this->notificationEmail;
	}

	/**
	 * @param string $notificationEmail
	 */
	public function setNotificationEmail($notificationEmail) {
		$this->notificationEmail = $notificationEmail;
	}

	/**
	 * @return the $streamType
	 */
	public function getStreamType() {
		return $this->streamType;
	}

	/**
	 * @param string $streamType
	 */
	public function setStreamType($streamType) {
		$this->streamType = $streamType;
	}

	/**
	 * @return the $secondaryContact
	 */
	public function getSecondaryContact() {
		return $this->secondaryContact;
	}

	/**
	 * @param string $secondaryContact
	 */
	public function setSecondaryContact($secondaryContact) {
		$this->secondaryContact = $secondaryContact;
	}

	/**
	 * @return the $primaryContact
	 */
	public function getPrimaryContact() {
		return $this->primaryContact;
	}

	/**
	 * @param string $primaryContact
	 */
	public function setPrimaryContact($primaryContact) {
		$this->primaryContact = $primaryContact;
	}

	/**
	 * @return the $domainName
	 */
	public function getDomainName() {
		return $this->domainName;
	}

	/**
	 * @param string $domainName
	 */
	public function setDomainName($domainName) {
		$this->domainName = $domainName;
	}

	/**
	 * @return the $dvrWindow
	 */
	public function getDvrWindow() {
		return $this->dvrWindow;
	}

	/**
	 * @param int $dvrWindow
	 */
	public function setDvrWindow($dvrWindow) {
		$this->dvrWindow = $dvrWindow;
	}

	/**
	 * @return the $dvrEnabled
	 */
	public function getDvrEnabled() {
		return $this->dvrEnabled;
	}

	/**
	 * @param bool $dvrEnabled
	 */
	public function setDvrEnabled($dvrEnabled) {
		$this->dvrEnabled = $dvrEnabled;
	}

	/**
	 * @return the $systemPassword
	 */
	public function getSystemPassword() {
		return $this->systemPassword;
	}

	/**
	 * @param string $systemPassword
	 */
	public function setSystemPassword($systemPassword) {
		$this->systemPassword = $systemPassword;
	}

	/**
	 * @return the $systemUserName
	 */
	public function getSystemUserName() {
		return $this->systemUserName;
	}

	/**
	 * @param string $systemUserName
	 */
	public function setSystemUserName($systemUserName) {
		$this->systemUserName = $systemUserName;
	}

	/* (non-PHPdoc)
	 * @see kProvisionJobData::populateFromPartner()
	 */
	public function populateFromPartner(Partner $partner)
	{
		$liveParams = $partner->getAkamaiUniversalStreamingLiveParams();
		if ($liveParams)
		{
			$this->systemUserName = $liveParams["systemUserName"];
			$this->systemPassword = $liveParams["systemPassword"];
			$this->dvrEnabled = $liveParams["dvrEnabled"];
			$this->dvrWindow = $liveParams["dvrWindow"];
			$this->domainName = $liveParams["domainName"]; 
			$this->streamType = $liveParams["streamType"];
			$this->primaryContact = $liveParams["primaryContact"];
			$this->secondaryContact = $liveParams["secondaryContact"];
		}
		
	}

	public function populateEntryFromData (entry $entry)
	{
		$entry->setStreamUsername($this->getEncoderUsername());
		$entry->setExternalStreamId($this->getStreamID());
		$entry->setPrimaryBroadcastingUrl($this->getPrimaryBroadcastingUrl());
		$entry->setSecondaryBroadcastingUrl($this->getSecondaryBroadcastingUrl());
		$entry->setStreamName($this->getStreamName());
		$entry->setHlsStreamUrl("http://urtmpkal-f.akamaihd.net/i/".$this->getStreamName()."_1@".$this->getStreamID()."/master.m3u8");
		$configs = $entry->getLiveStreamConfigurations();
		$configs[PlaybackProtocol::AKAMAI_HDS] = "http://urtmpkal-f.akamaihd.net/z/".$this->getStreamName()."_1@".$this->getStreamID()."/manifest.f4m";
		$entry->setLiveStreamConfigurations($configs);
	}
	/* (non-PHPdoc)
	 * @see kProvisionJobData::populateFromEntry()
	 */
	public function populateFromEntry(entry $entry) 
	{
		$this->setEncoderIP($entry->getEncodingIP1());
 		$this->setBackupEncoderIP($entry->getEncodingIP2());
 		$this->setEncoderPassword($entry->getStreamPassword());
 		$this->setEncoderUsername($entry->getStreamUsername());
 		$this->setDvrEnabled($entry->getDvrStatus());
 		$this->setDvrWindow($entry->getDvrWindow());
 		$this->setStreamType(AkamaiUniversalStreamType::UNIVERSAL_STREAMING_LIVE);
 		$this->setStreamName($entry->getName());
		
	}

	
}