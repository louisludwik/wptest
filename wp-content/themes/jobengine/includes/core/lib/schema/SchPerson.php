<?php
class SchPerson extends SchThing{
	protected $additionalName	=	'Text';
	protected $address	=	'PostalAddress';
	protected $affiliation	=	'Organization';
	protected $alumniOf	=	'EducationalOrganization';
	protected $award	=	'Text';
	protected $birthDate	=	'Date';
	protected $brand	=	'Organization,Brand';
	protected $children	=	'Person';
	protected $colleague	=	'Person';
	protected $contactPoint	=	'ContactPoint';
	protected $deathDate	=	'Date';
	protected $duns	=	'Text';
	protected $email	=	'Text';
	protected $familyName	=	'Text';
	protected $faxNumber	=	'Text';
	protected $follows	=	'Person';
	protected $gender	=	'Text';
	protected $givenName	=	'Text';
	protected $globalLocationNumber	=	'Text';
	protected $hasPOS	=	'Place';
	protected $homeLocation	=	'ContactPoint,Place';
	protected $honorificPrefix	=	'Text';
	protected $honorificSuffix	=	'Text';
	protected $interactionCount	=	'Text';
	protected $isicV4	=	'Text';
	protected $jobTitle	=	'Text';
	protected $knows	=	'Person';
	protected $makesOffer	=	'Offer';
	protected $memberOf	=	'ProgramMembership,Organization';
	protected $naics	=	'Text';
	protected $nationality	=	'Country';
	protected $owns	=	'Product,OwnershipInfo';
	protected $parent	=	'Person';
	protected $performerIn	=	'Event';
	protected $relatedTo	=	'Person';
	protected $seeks	=	'Demand';
	protected $sibling	=	'Person';
	protected $spouse	=	'Person';
	protected $taxID	=	'Text';
	protected $telephone	=	'Text';
	protected $vatID	=	'Text';
	protected $workLocation	=	'ContactPoint,Place';
	protected $worksFor	=	'Organization';
	function __construct(){$this->namespace = "Person";}
}