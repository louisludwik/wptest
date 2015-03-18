<?php
class SchOrganization extends SchThing{
	protected $address	=	'PostalAddress';
	protected $aggregateRating	=	'AggregateRating';
	protected $brand	=	'Organization,Brand';
	protected $contactPoint	=	'ContactPoint';
	protected $department	=	'Organization';
	protected $dissolutionDate	=	'Date';
	protected $duns	=	'Text';
	protected $email	=	'Text';
	protected $employee	=	'Person';
	protected $event	=	'Event';
	protected $faxNumber	=	'Text';
	protected $founder	=	'Person';
	protected $foundingDate	=	'Date';
	protected $globalLocationNumber	=	'Text';
	protected $hasPOS	=	'Place';
	protected $interactionCount	=	'Text';
	protected $isicV4	=	'Text';
	protected $legalName	=	'Text';
	protected $location	=	'PostalAddress,Place';
	protected $logo	=	'URL,ImageObject';
	protected $makesOffer	=	'Offer';
	protected $member	=	'Person,Organization';
	protected $memberOf	=	'ProgramMembership,Organization';
	protected $naics	=	'Text';
	protected $owns	=	'Product,OwnershipInfo';
	protected $review	=	'Review';
	protected $seeks	=	'Demand';
	protected $subOrganization	=	'Organization';
	protected $taxID	=	'Text';
	protected $telephone	=	'Text';
	protected $vatID	=	'Text';
	function __construct(){$this->namespace = "Organization";}
}