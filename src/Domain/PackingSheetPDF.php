<?php

namespace PackingSheets\Domain;

class PackingSheetPDF extends \FPDF
{	
	private $header;
	private $ps;
	private $footer;
	private $hscodeStatus;
	
	// En-tête
	function Header()
	{
		
		$this->SetFont('Arial','B',9);
		
		$this->Cell(45,5,' ','LTR',0,'L',0);
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
		$secondaryFooter = 'Page '.$this->PageNo()." - ".'Printed on : '.date('Y-m-d');
		
		$this->Cell(140,20,$this->footer->getText(),'',0,'L',0);
		$this->Cell(50, 20, $secondaryFooter, '', 0, 'R', 0);
	}
	
	function AddressesContacts(){
		
		$this->SetFillColor(205, 208, 209);
		$this->SetFont('Arial','B',8);
		
		$this->Cell(95,5,'CONSIGNED TO','BLRT',0,'L',1);
		$this->Cell(95,5,'DELIVERY TO','BTRL',0,'L',1);
		
		$this->Ln();
		
		$this->SetFont('Arial','',8);
		
		$this->Cell(95,10,$this->ps->getConsignedAddressId()->getLabel(),'LRT',0,'L',0);
		$this->Cell(95,10,($this->ps->getDeliveryAddressId() === null) ? '' : $this->ps->getDeliveryAddressId()->getLabel() ,'TRL',0,'L',0);
		
		$this->Ln();
		
		$this->Cell(95,5,'','LR',0,'L',0);
		$this->Cell(95,5,'','RL',0,'L',0);
		
		$this->Ln();
		
		$this->Cell(95,5,$this->ps->getConsignedContactId()->getName(),'LR',0,'L',0);
		$this->Cell(95,5,($this->ps->getDeliveryContactId() === null) ? '' : $this->ps->getDeliveryContactId()->getName(),'RL',0,'L',0);
		
		$this->Ln();
		
		$this->Cell(95,5,$this->ps->getConsignedContactId()->getMail(),'LR',0,'L',0);
		$this->Cell(95,5,($this->ps->getDeliveryContactId() === null) ? '' : $this->ps->getDeliveryContactId()->getMail(),'RL',0,'L',0);
		
		$this->Ln();
		
		$this->Cell(95,5,'Phone : '.$this->ps->getConsignedContactId()->getPhoneNr().' Fax : '.$this->ps->getConsignedContactId()->getFaxNr(),'LRB',0,'L',0);
		
		$deliveryFax = ($this->ps->getDeliveryContactId() === null) ? '' : 'Phone : '.$this->ps->getDeliveryContactId()->getFaxNr();
		$deliveryPhone = ($this->ps->getDeliveryContactId() === null) ? '' : ' Fax : '.$this->ps->getDeliveryContactId()->getPhoneNr();
		
		$this->Cell(95,5,$deliveryPhone.$deliveryFax,'RLB',0,'L',0);
		
		$this->Ln();
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
		$this->Cell(65,5,'','LR',0,'C',0);
		
		$this->Ln();
		
		$this->Cell(45,5,'','LR',0,'C',0);
		$this->Cell(80,5,'','RL',0,'C',0);
		$this->SetFont('Arial','B',8);
		$this->Cell(65,5,'INCOTERMS','TBLR',0,'C',1);
		
		$this->Ln();
		
		$this->Cell(45,5,'','LRB',0,'C',0);
		$this->Cell(80,5,'','RLB',0,'C',0);
		$this->SetFont('Arial','',8);
		$this->Cell(65,5,$this->ps->getIncTypeId()->getLabel().' - '.$this->ps->getIncLocId()->getLabel(),'TBLR',0,'C',0);
		
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
		
		$this->Cell(95,5,'ACCOUNTING INFOS','LRTB',0,'C',1);
		$this->Cell(50,5,'ORDER NR','LRTB',0,'C',1);
		$this->SetFont('Arial','',8);
		$this->Cell(45,5,'','RLTB',0,'C',0);
		
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
				
				$this->Cell(10);
				$this->Cell(20,5,'QUANTITY','LRTB',0,'C',1);
				$this->Cell(20,5,'ORIGIN','LRTB',0,'C',1);
				$this->Cell(30,5,'PART NUMBER','LRTB',0,'C',1);
				$this->Cell(40,5,'PART SERIAL NUMBER','LRTB',0,'C',1);
				
				if($this->hscodeStatus){
					$this->Cell(40,5,'NOMENCLATURE','LRTB',0,'C',1);
					$this->Cell(30,5,'PRICE','LRTB',0,'C',1);
				}
				else{
					$this->Cell(70,5,'PRICE','LRTB',0,'C',1);
				}
				
				$this->Ln();
				
				if(!empty($pack->getParts())){
					
					foreach($pack->getParts() as $part){
						
						$this->SetFont('Arial','',8);
						
						$this->Cell(10);
						$this->Cell(20,5,$part->getQuantity(),'LRTB',0,'C',0);
						$this->Cell(20,5,$part->getOrigin(),'LRTB',0,'C',0);
						$this->Cell(30,5,$part->getPartid()->getPn(),'LRTB',0,'C',0);
						$this->Cell(40,5,$part->getPartid()->getSerial(),'LRTB',0,'C',0);
						
						if($this->hscodeStatus){
							$this->Cell(40,5,$part->getPartid()->getHSCode(),'LRTB',0,'C',0);
							$this->Cell(30,5,$part->getPartid()->getPrice(),'LRTB',0,'C',0);
						}
						else{
							$this->Cell(70,5,$part->getPartid()->getPrice(),'LRTB',0,'C',0);
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
		
		$this->Cell(160,5,'TOTAL PRICE','LRTB',0,'R',0);
		$this->Cell(30,5,$this->ps->getTotalPrice(),'LRTB',0,'R',0);
		$this->Ln();
		$this->Cell(160,5,'Value for Customs Purpose','LRTB',0,'R',0);
		$this->Ln();
	}
	
	function Memo(){
		
		$this->SetFont('Arial','',8);
		$this->Cell(190,20,$this->ps->getMemo(),'',0,'L',0);
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
}
