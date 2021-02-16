<?php 
require_once __DIR__."/../modele/dao/dao.php";
require_once __DIR__."/fpdf/fpdf.php";
require_once __DIR__."/../modele/bean/Entreprise.php";
session_cache_limiter('none');
session_start();

    class PDF extends FPDF{

        function tableau($header,$indexPause,$w){
            $dao = new Dao();
            $alljury= $dao->getjurie();
            $listes = $dao->getListeCreneaux();
            $ent = $_SESSION["idEnt"];
            $Allformation = $dao->getFormationsEntreprise($ent);

            $this->SetFillColor(173,216,230);
            $this->SetTextColor(0);
            $this->SetDrawColor(128,0,0);
            $this->SetLineWidth(.3);
            $this->SetFont('','B');
            $this->SetFontSize(7);
            for($i=0;$i<count($header);$i++)
                $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
            $this->Ln();
            $this->SetFillColor(224,235,255);
            $this->SetTextColor(0);
            $this->SetFont('');
            // Données
            $fill = false;
            foreach($Allformation as $form){
                $this->Cell($w[0],10,$alljury[$form[0]],'LR',0,'L',$fill);
                $this->Cell($w[1],10,$form[1],'LR',0,'L',$fill);
                for($cpt = 0; $cpt < count($listes)+1; $cpt++) {
                    $j = 2;
                    if($cpt+2 == $indexPause){
                        $this->Cell($w[$indexPause],10,'','LR',0,'L',$fill);
                    }
                    else{
                        $idEtu=$dao->getCreneau($cpt, $form[0]);
                        if ($idEtu!=null){
                            $this->Cell($w[$j],10,strtoupper($dao->getNomEtudiant($idEtu)),'LR',0,'L',$fill);
                        }
                        else{
                            $this->Cell($w[$j],10,'--------','LR',0,'L',$fill);
                        }
                    }
                    $j++;
                }
                $this->Ln();
                $fill = !$fill;
            }
            $this->Cell(array_sum($w),0,'','T');
        }
    }
    $dao = new DAO();
    $AllEntreprises = $dao->getAllEntreprises();
    $pause = $dao->getCreneauPause();
    switch($pause["heureCreneauPause"]){
    
        case "14:00:00":
            $header=array("Jury","Formation","13:40", "Pause", "14:20", "14:40","15:00", "15:20","15:40","16:00","16:20","16:40","17:00", "17:20","17:40");
            $indexPause = 3;
            $w = array(6,28,20,8,20,20,20,20,20,20,20,20,20,20,20);
        break;
    
        case "14:20:00":
            $header=array("Jury","Formation","13:40", "14:00", "Pause", "14:40","15:00", "15:20","15:40","16:00","16:20","16:40","17:00", "17:20","17:40");
            $indexPause = 4;
            $w = array(6,28,20,20,8,20,20,20,20,20,20,20,20,20,20);
        break;
    
        case "14:40:00":
            $header=array("Jury","Formation","13:40", "14:00", "14:20", "Pause","15:00", "15:20","15:40","16:00","16:20","16:40","17:00", "17:20","17:40");
            $indexPause = 5;
            $w = array(6,28,20,20,20,8,20,20,20,20,20,20,20,20,20);
        break;
    
        case "15:00:00":
            $header=array("Jury","Formation","13:40", "14:00", "14:20", "14:40","Pause", "15:20","15:40","16:00","16:20","16:40","17:00", "17:20","17:40");
            $indexPause = 6;
            $w = array(6,28,20,20,20,20,8,20,20,20,20,20,20,20,20);
        break;
    
        case "15:20:00":
            $header=array("Jury","Formation","13:40", "14:00", "14:20", "14:40","15:00", "Pause","15:40","16:00","16:20","16:40","17:00", "17:20","17:40");
            $indexPause = 7;
            $w = array(6,28,20,20,20,20,20,8,20,20,20,20,20,20,20);
        break;
    
        case "15:40:00":
            $header=array("Jury","Formation","13:40", "14:00", "14:20", "14:40","15:00", "15:20","Pause","16:00","16:20","16:40","17:00", "17:20","17:40");
            $indexPause = 8;
            $w = array(6,28,20,20,20,20,20,20,8,20,20,20,20,20,20);
        break;
    
        case "16:00:00":
            $header=array("Jury","Formation","13:40", "14:00", "14:20", "14:40","15:00", "15:20","15:40","Pause","16:20","16:40","17:00", "17:20","17:40");
            $indexPause = 9;
            $w = array(6,28,20,20,20,20,20,20,20,8,20,20,20,20,20);
        break;
    
        case "16:20:00":
            $header=array("Jury","Formation","13:40", "14:00", "14:20", "14:40","15:00", "15:20","15:40","16:00","Pause","16:40","17:00", "17:20","17:40");
            $indexPause = 10;
            $w = array(6,28,20,20,20,20,20,20,20,20,8,20,20,20,20);
        break;
    
        case "16:40:00":
            $header=array("Jury","Formation","13:40", "14:00", "14:20", "14:40","15:00", "15:20","15:40","16:00","16:20","Pause","17:00", "17:20","17:40");
            $indexPause = 11;
            $w = array(6,28,20,20,20,20,20,20,20,20,20,8,20,20,20);
        break;
    
        case "17:00:00":
            $header=array("Jury","Formation","13:40", "14:00", "14:20", "14:40","15:00", "15:20","15:40","16:00","16:20","16:40","Pause", "17:20","17:40");
            $indexPause = 12;
            $w = array(6,28,20,20,20,20,20,20,20,20,20,20,8,20,20);
        break;
    
        case "17:20:00":
            $header=array("Jury","Formation","13:40", "14:00", "14:20", "14:40","15:00", "15:20","15:40","16:00","16:20","16:40","17:00", "Pause","17:40");
            $indexPause = 13;
            $w = array(6,28,20,20,20,20,20,20,20,20,20,20,20,8,20);
        break;
    
        case "17:40:00":
            $header=array("Jury","Formation","13:40", "14:00", "14:20", "14:40","15:00", "15:20","15:40","16:00","16:20","16:40","17:00", "17:20","Pause");
            $indexPause = 14;
            $w = array(6,28,20,20,20,20,20,20,20,20,20,20,20,20,8);
        break;
    }

    $pdf = new PDF('L','mm','A4');
    $pdf->AddPage();
    $pdf->Image('img/bandeau-RAlt-small.png',45);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,60);
    $largeurDeCellule = 0; //0 étend la largeur a toute la page
    $hauteurDeCellule = 0;
    $border = 0; // pas de bordure de cellule
    $alignement = "C"; // centrage
    $monTexte = 'Planning de '.iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', str_replace("_", " ", $_SESSION["nomEnt"]));
    $pdf->SetXY(120,60);
    $pdf->Cell($largeurDeCellule, 50,$monTexte, $border, $alignement);
    $pdf->SetXY(10,90);
    $pdf->tableau($header,$indexPause,$w);



    $pdf->Output('I','planning_'.str_replace("_", " ", $_SESSION["nomEnt"]).'.pdf');


?>