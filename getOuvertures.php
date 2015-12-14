<?php
	$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";		
	//***********************************************************************************************************************
	// V1.0 : Script qui fournit l'etat des ouvertures parametrees et le message vocal associe
	//*************************************** API eedomus ******************************************************************
	$api_user = "XXXXXX";
	$api_secret = "xxxxxxxxxxxxxxxx";
	//*************************************** Messages personnels***********************************************************
	$msg_allclosed = "Apres vérification, tout est bien fermé";
	$msg_open = "Je detecte que ";
	//*************************************** Tableau des ouvertures *******************************************************
        $tabouvertures = array(1 => array("TYPE" => "la porte du garage", "API" => "AAAAAA", "ETAT" => 0),
			       2 => array("TYPE" => "la fenêtre de la chambre de Louis", "API" => "BBBBBB", "ETAT" => 0));
	$nbouvertures = 2;
	//**********************************************************************************************************************
	$xml .= "<OUVERTURES>";
	$idoors = 1;
	$nbouvert = 0;
	$annonce = $msg_allclosed;
	foreach($tabouvertures as $ouvertures) {
		$periphid = $ouvertures["API"];
		$urlValue =  "https://api.eedomus.com/get?action=periph.caract&periph_id=".$periphid."&api_user=".$api_user."&api_secret=".$api_secret;
		$arrValue = json_decode(utf8_encode(file_get_contents($urlValue)));
		if(array_key_exists("body", $arrValue) && array_key_exists("last_value", $arrValue->body)) {
			if ($arrValue->body->last_value == 0) {
				$ouvertures["ETAT"] = 0;
			}
			else {
				$ouvertures["ETAT"] = 1;
				$nbouvert++;
				if ($nbouvert == 1) {
					$annonce = $msg_open.$ouvertures["TYPE"];
				}
				else {
					$annonce = $annonce." et ".$ouvertures["TYPE"];
				}
			}
			$xml .= "<OUVERTURE_".$idoors."><TYPE>".$ouvertures["TYPE"]."</TYPE>";
			$xml .= "<ETAT>".$ouvertures["ETAT"]."</ETAT></OUVERTURE_".$idoors.">";
		}
		$idoors++;
	}
	if ($nbouvert == 1) {
		$annonce .= " est ouverte.";
	} else if ($nbouvert > 1) {
		$annonce .= " sont ouvertes.";
	}
	$xml .= "<MESSAGE>".$annonce."</MESSAGE>";
	$xml .= "</OUVERTURES>";
	header("Content-Type: text/xml");
	echo $xml;
?>