<?php
class SchDrug extends SchMedicalTherapy{
	protected $activeIngredient	=	'Text';
	protected $administrationRoute	=	'Text';
	protected $alcoholWarning	=	'Text';
	protected $availableStrength	=	'DrugStrength';
	protected $breastfeedingWarning	=	'Text';
	protected $clincalPharmacology	=	'Text';
	protected $cost	=	'DrugCost';
	protected $dosageForm	=	'Text';
	protected $doseSchedule	=	'DoseSchedule';
	protected $drugClass	=	'DrugClass';
	protected $foodWarning	=	'Text';
	protected $interactingDrug	=	'Drug';
	protected $isAvailableGenerically	=	'Boolean';
	protected $isProprietary	=	'Boolean';
	protected $labelDetails	=	'URL';
	protected $legalStatus	=	'DrugLegalStatus';
	protected $manufacturer	=	'Organization';
	protected $mechanismOfAction	=	'Text';
	protected $nonProprietaryName	=	'Text';
	protected $overdosage	=	'Text';
	protected $pregnancyCategory	=	'DrugPregnancyCategory';
	protected $pregnancyWarning	=	'Text';
	protected $prescribingInfo	=	'URL';
	protected $prescriptionStatus	=	'DrugPrescriptionStatus';
	protected $relatedDrug	=	'Drug';
	protected $warning	=	'URL,Text';
	function __construct(){$this->namespace = "Drug";}
}