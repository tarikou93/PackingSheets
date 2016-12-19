<?php

namespace PackingSheets\Domain;

class PackingSheetPDF extends \FPDF
{
	// En-t�te
	function Header()
	{
		// Police Arial gras 15
		$this->SetFont('Arial','B',15);
		// D�calage � droite
		$this->Cell(80);
		// Titre
		$this->Cell(30,10,'Titre',1,0,'C');
		// Saut de ligne
		$this->Ln(20);
	}

	// Pied de page
	function Footer()
	{
		// Positionnement � 1,5 cm du bas
		$this->SetY(-15);
		// Police Arial italique 8
		$this->SetFont('Arial','I',8);
		// Num�ro de page
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}
