<?php

namespace PackingSheets\Domain;

class PackingSheetPDF extends \FPDF
{	
	private $header;
	private $ps;
	private $footer;
	private $hscodeStatus;
	private $logo;
	private $consignedCode;
	private $deliveryCode;
	
	public function __construct(){
		parent::__construct('P','mm','A4');
		
	}
	
	// En-tête
	function Header()
	{
		
		$this->SetFont('Arial','B',9);
		
		$this->Cell(45,5,' ','LTR',0,'L',0);
		$this->Image($this->logo,19,12,30);
		$this->Cell(100,5,$this->header->getText(),'LTR',0,'C',0);
		$this->Cell(45,5,'AWB','LTR',0,'C',0);
		
		$this->Ln();
		$this->SetFont('Arial','',9);
		
		$this->Cell(45,5,' ','LR',0,'L',0);
		$this->Cell(100,5,'','LR',0,'C',0);
		$this->Cell(45,5,$this->ps->getAWB(),'LR',0,'C',0);
		
		$this->Ln();
		
		$this->SetFont('Arial','B',8);
		
		$this->Cell(45,5,' ','LR',0,'L',0);
		$this->Cell(100,5,$this->ps->getRef(),'LR',0,'R',0);
		$this->Cell(45,5,' ','LR',0,'L',0);
		
		$this->Ln();
		
		$this->Cell(45,5,' ','BL',0,'L',0);
		$this->Cell(100,5,'PRIORITY : '.$this->ps->getPriorityId()->getLabel(),'BTR',0,'R',0);
		$this->Cell(45,5,'VAT BE : 465 150 137','LTRB',0,'C',0);
		
		$this->Ln();
	}

	// Pied de page
	function Footer()
	{	
		$this->SetY(-50);
		
		$secondaryFooter = 'Page '.$this->PageNo()." - ".'Printed on : '.date('Y-m-d');
		$footerParts = explode("\n", $this->footer->getText(), 2);
		
		$this->SetFont('Arial','B',8);
		$this->Cell(140, 5, $footerParts[0], '', 0, 'L', 0);
		$this->Ln();
		
		$this->SetFont('Arial','',8);
		
		$x=$this->GetX();
		
		$this->MultiCell(140,5,$footerParts[1],'','L',0);
		
		$y=$this->GetY();
		
		$this->SetXY($x+140, $y);
		
		$this->SetFont('Arial','B',8);
		$this->Cell(50, 5, $this->ps->getRef(), '', 0, 'R', 0);
		
		$this->SetXY($x+140, $y+5);
		
		$this->SetFont('Arial','',8);
		$this->Cell(50, 5, $secondaryFooter, '', 0, 'R', 0);
	}
	
	function AddressesContacts(){
		
		//Consigned
		
		$consignedAddress = $this->ps->getConsignedAddressId()->getLabel()."\n\n";
		$consignedContact = ($this->ps->getConsignedContactId() === null) ? "" : $this->ps->getConsignedContactId()->getName()."\n".$this->ps->getConsignedContactId()->getMail()."\nPhone: ".$this->ps->getConsignedContactId()->getPhoneNr();
		$consignedBlock = $consignedAddress.$consignedContact;
		
		$nbrLinesConsigned = substr_count($consignedBlock, "\n");
		
		//var_dump($nbrLinesConsigned);
				
		//Delivery
		
		$deliveryAddress = ($this->ps->getDeliveryAddressId() === null) ? "" : $this->ps->getDeliveryAddressId()->getLabel()."\n\n";
		$deliveryContact = ($this->ps->getDeliveryContactId() === null) ? "" : $this->ps->getDeliveryContactId()->getName()."\n".$this->ps->getDeliveryContactId()->getMail()."\nPhone: ".$this->ps->getDeliveryContactId()->getPhoneNr();;
		$deliveryBlock = $deliveryAddress.$deliveryContact;
		
		$nbrLinesDelivery = substr_count($deliveryBlock, "\n");
		
		$longestLines = ($nbrLinesConsigned > $nbrLinesDelivery) ? $nbrLinesConsigned : $nbrLinesDelivery;
		
		//var_dump($nbrLinesDelivery);exit;
		
		for ($i = 1; $i <= ($longestLines - $nbrLinesDelivery)+1; $i++) {
			$deliveryBlock .= "\n";
		}
		
		for ($i = 1; $i <= ($longestLines - $nbrLinesConsigned)+1; $i++) {
			$consignedBlock .= "\n";
		}
				
		$this->SetFillColor(205, 208, 209);
		$this->SetFont('Arial','B',8);
		
		$this->Cell(95,5,'CONSIGNED TO','BLRT',0,'L',1);
		$this->Cell(95,5,'DELIVERY TO','BTRL',0,'L',1);
		
		$this->Ln();
		
		$this->Cell(95,5,$this->consignedCode,'LT',0,'L',0);
		$this->Cell(95,5,$this->deliveryCode,'LRT',0,'L',0);
		
		$this->Ln();
		
		$this->SetFillColor(205, 208, 209);
		$this->SetFont('Arial','',8);
		
		$x=$this->GetX();
		$y=$this->GetY();
				
		$this->MultiCell(190,5,$consignedBlock,'LR','L',0);
			
		$this->SetXY($x+95,$y);
		
		$this->MultiCell(95,5,$deliveryBlock,'LR', 'L',0);		
	}
	
	function PackingSheetInfos(){
		
		$this->SetFillColor(205, 208, 209);
		$this->SetFont('Arial','B',8);
		
		$this->Cell(45,5,'FROM SERVICE','BLRT',0,'C',1);
		$this->Cell(80,5,'DATE OF ISSUE - AUTHORITY','BTRL',0,'C',1);
		$this->Cell(65,5,'CUSTOM STATUS','BLRT',0,'C',1);
		
		$this->Ln();
		$this->SetFont('Arial','',8);
		
		$this->Cell(45,5,$this->ps->getServiceId()->getLabel(),'LRT',0,'C',0);
		$this->Cell(80,5,$this->ps->getDateIssue(),'TRL',0,'C',0);
		$this->Cell(65,5,$this->ps->getCustomStatusId()->getLabel(),'LRT',0,'C',0);
		
		$this->Ln();
		
		$this->Cell(45,5,'','LR',0,'C',0);
		$this->Cell(80,5,$this->ps->getAutority(),'RL',0,'C',0);
		$this->SetFont('Arial','B',8);
		$this->Cell(65,5,'INCOTERMS','TBLR',0,'C',1);
			
		$this->Ln();
		
		$this->Cell(45,5,'','LRB',0,'C',0);
		$this->Cell(80,5,'','RLB',0,'C',0);
		$this->SetFont('Arial','',8);
		$this->Cell(65,5,($this->ps->getIncTypeId() !== null && $this->ps->getIncLocId() !== null) ? $this->ps->getIncTypeId()->getLabel().' - '.$this->ps->getIncLocId()->getLabel() : '','TBLR',0,'C',0);
		
		$this->Ln();
		$this->SetFont('Arial','B',8);
		
		$this->Cell(23,5,'NR OF PIECES','LRTB',0,'C',1);
		$this->Cell(22,5,'WEIGHT','LRTB',0,'C',1);
		$this->Cell(145,5,'CONTENT','RLTB',0,'C',1);
		
		$this->Ln();
		$this->SetFont('Arial','',8);
		
		$this->Cell(23,5,$this->ps->getNbrPieces(),'LRTB',0,'C',0);
		$this->Cell(22,5,$this->ps->getWeight(),'LRTB',0,'C',0);
		$this->Cell(145,5,$this->ps->getContentId()->getLabel(),'RLTB',0,'C',0);
		
		$this->Ln();
		$this->SetFont('Arial','B',8);
		
		$this->Cell(190,5,'ACCOUNTING INFOS','LRTB',0,'C',1);
		
		$this->Ln();
		$this->SetFont('Arial','B',8);
		
		$this->Cell(45,5,'PREPAID','LRTB',0,'C',1);
		$this->Cell(50,5,'COLLECT','LRTB',0,'C',1);
		$this->Cell(50,5,'REF PACKING SHEET','LRTB',0,'C',1);
		$this->SetFont('Arial','',8);
		$this->Cell(45,5,$this->ps->getRef(),'RLTB',0,'C',0);
		
		$this->Ln();
		
		if($this->ps->getCollect() === 1){
			$this->Cell(45,5,'','LRTB',0,'C',0);
			$this->Cell(50,5,'Yes','LRTB',0,'C',0);
		}
		else{
			$this->Cell(45,5,($this->ps->getImputId() === null) ? '' : $this->ps->getImputId()->getLabel(),'LRTB',0,'C',0);
			$this->Cell(50,5,'No','LRTB',0,'C',0);
		}
				
		$this->SetFont('Arial','B',8);
		$this->Cell(50,5,'CARRIER','LRTB',0,'C',1);
		$this->SetFont('Arial','',8);
		$this->Cell(45,5,$this->ps->getShipperId()->getLabel(),'RLTB',0,'C',0);
		
		$this->Ln();	
	}
	
	function Packings(){
		
		$this->Ln();
		$this->SetFont('Arial','B',8);
		
		$this->Cell(190,5,'PACKINGS','LRTB',0,'L',0);
		
		$this->Ln();
		
		$this->Cell(23,5,'ITEM','LRTB',0,'C',1);
		$this->Cell(22,5,'QUANTITY','LRTB',0,'C',1);
		$this->Cell(50,5,'PACKAGE TYPE','LRTB',0,'C',1);
		$this->Cell(50,5,'WEIGHT (kg)','LRTB',0,'C',1);
		$this->Cell(45,5,'MEASURES (cm)','LRTB',0,'C',1);
		
		$this->Ln();
		
		$this->Cell(95);
		$this->Cell(25,5,'NET','LRTB',0,'C',1);
		$this->Cell(25,5,'GROSS','LRTB',0,'C',1);
		
		$this->Ln();
		$this->SetFont('Arial','',8);
		$cptPackings = 1;
		
		if(!empty($this->ps->getPackings())){
			foreach($this->ps->getPackings() as $pack){
				$this->Cell(23,5,$cptPackings,'LRTB',0,'C',1);
				$this->Cell(22,5,1,'LRTB',0,'C',0);
				$this->Cell(50,5,$pack->getPackTypeid()->getLabel(),'LRTB',0,'C',0);
				$this->Cell(25,5,$pack->getNetWeight(),'LRTB',0,'C',0);
				$this->Cell(25,5,$pack->getGrossWeight(),'LRTB',0,'C',0);
				$this->Cell(45,5,$pack->getM1().'/'.$pack->getM2().'/'.$pack->getM3(),'LRTB',0,'C',0);
				$cptPackings++;
				$this->Ln();
			}
		}
			
	}
	
	function DetailedParts(){
		
		$this->Ln();
		$this->SetFont('Arial','B',8);
		
		$this->Cell(190,5,'DETAILS','LRTB',0,'L',0);
		
		$this->Ln();
		$cptDetails = 1;
		
		if(!empty($this->ps->getPackings())){
			
			foreach($this->ps->getPackings() as $pack){
				
				$this->Cell(190,5,'ITEM '.$cptDetails,'LRTB',0,'L',1);
				$this->Ln();
								
				if($this->hscodeStatus){
					
					$this->Cell(10);
					$this->Cell(20,5,'QUANTITY','LRTB',0,'C',1);
					$this->Cell(20,5,'ORIGIN','LRTB',0,'C',1);
					$this->Cell(30,5,'PART NUMBER','LRTB',0,'C',1);
					$this->Cell(40,5,'PART SERIAL NUMBER','LRTB',0,'C',1);
					$this->Cell(40,5,'NOMENCLATURE','LRTB',0,'C',1);
					$this->Cell(30,5,'PRICE','LRTB',0,'C',1);
				}
				else{
					
					$this->Cell(30);
					$this->Cell(20,5,'QUANTITY','LRTB',0,'C',1);
					$this->Cell(30,5,'ORIGIN','LRTB',0,'C',1);
					$this->Cell(40,5,'PART NUMBER','LRTB',0,'C',1);
					$this->Cell(40,5,'PART SERIAL NUMBER','LRTB',0,'C',1);
					$this->Cell(30,5,'PRICE','LRTB',0,'C',1);
				}
				
				$this->Ln();
				
				if(!empty($pack->getParts())){
					
					foreach($pack->getParts() as $part){
						
						$this->SetFont('Arial','',8);
						
						
												
						if($this->hscodeStatus){
							
							$this->Cell(10);
							$this->Cell(20,5,$part->getQuantity(),'LRTB',0,'C',0);
							$this->Cell(20,5,$part->getOrigin(),'LRTB',0,'C',0);
							$this->Cell(30,5,$part->getPartid()->getPn(),'LRTB',0,'C',0);
							$this->Cell(40,5,$part->getPartid()->getSerial(),'LRTB',0,'C',0);
							$this->Cell(40,5,$part->getPartid()->getHSCode(),'LRTB',0,'C',0);
							$this->Cell(30,5,$part->getPartid()->getPrice(),'LRTB',0,'C',0);
						}
						else{
							
							$this->Cell(30);
							$this->Cell(20,5,$part->getQuantity(),'LRTB',0,'C',0);
							$this->Cell(30,5,$part->getOrigin(),'LRTB',0,'C',0);
							$this->Cell(40,5,$part->getPartid()->getPn(),'LRTB',0,'C',0);
							$this->Cell(40,5,$part->getPartid()->getSerial(),'LRTB',0,'C',0);
							$this->Cell(30,5,$part->getPartid()->getPrice(),'LRTB',0,'C',0);
						}
						$this->Ln();
						
						$this->Cell(45);
						$this->Cell(145,5,$part->getPartid()->getDesc(),'LRTB',0,'C',0);
						$this->Ln();
					}
				}
				
				$cptDetails++;
				$this->Ln();
				$this->SetFont('Arial','B',8);
			}
		}
	}
	
	function Totals(){
		
		$this->Cell(145,5,'TOTAL PRICE','LRTB',0,'R',0);
		$this->Cell(45,5,$this->ps->getCurrencyId()->getLabel().' '.$this->ps->getTotalPrice(),'LRTB',0,'R',0);
		$this->Ln();
		$this->Cell(145,5,'Value for Customs Purpose','LRTB',0,'R',0);
		$this->Ln();
	}
	
	function Memo(){
		
		$this->Ln();
		
		$this->SetFont('Arial','',8);
		$this->MultiCell(190,5,$this->ps->getMemo(),'','L',0);
		$this->Ln();
	}
	
	function build(){
					
		// Addresses
		$this->AddressesContacts();
		
		//Infos
		$this->PackingSheetInfos();
		
		//Packings
		$this->Packings();
		
		//Detailed Parts
		$this->DetailedParts();
		
		//Totals
		$this->Totals();
		
		//Memo
		$this->Memo();
	}
	
	function setPs($ps){
		$this->ps = $ps;
	}
	
	function setHeader($header){
		$this->header = $header;
	}
	
	function setFooter($footer){
		$this->footer = $footer;
	}
	
	function setHsCodesStatus($hsStatus){
		$this->hscodeStatus = $hsStatus;
	}
	
	function setLogo($logo){
		$this->logo = $_SERVER['DOCUMENT_ROOT'].'/img/'.$logo;
	}
	
	function setConsignedCode($code){
		$this->consignedCode = $code;
	}
	
	function setDeliveryCode($code){
		$this->deliveryCode = $code;
	}
}
