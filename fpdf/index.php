<?
//	le contenu des informations du svg est contenu dans une array presenter comme ceci :
/*
$mySVG1 = array (

	"filename" => "string",	//	(string) nom du fichier concerné
	"scale_x" => float,	//	(float) largeur de l'image dans le pdf
	"scale_y" => float,		//	(float) hauteur de l'image dans de pdf
	"scale_u" => "string",	//	(string) unité du l'image => 'mm' ou rien
	"scale_r" => "width",	//	(string) met l'image aux proportions par rapport à la hauteur ou la largeur, si le champ n'est pas renseigné l'image ne sera pas proportionnée
	
	"pos_x" => float,		//	(float) position du svg dans l'axe des absices
	"pos_y" => float,		//	(float) position du svg dans l'axe des ordonnées
	"pos_u" => "string"	//	(string) unité du positionement 'mm' ou rien
);

*/


//
//
//	exemple du script:


require('svg2pdf.php');
//
//	svg affiché correstement et calé selon sa largeur 


//
//	svg affiché correstement et calé selon sa longueur

$mySVG2 = array (

	"filename" => "iinn.svg",
	"scale_x" => 100,
	
	"scale_u" => "mm",
	"scale_r" => "width",
	"pos_x" => 55,
	"pos_y" => 30,
	"pos_u" => 'mm'
	
);


$pdf = new PDF_SVG('P','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->ImageSVG($mySVG2);
$pdf->Output();

?>
