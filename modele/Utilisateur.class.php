<?php
// Projet TraceGPS
// fichier : modele/Utilisateur.class.php
// Rôle : la classe Utilisateur représente les utilisateurs de l'application
// Dernière mise à jour : 18/7/2018 par JM CARTRON

include_once ('Outils.class.php');
// include_once ('Trace.class.php');

class Utilisateur
{
	// ------------------------------------------------------------------------------------------------------
	// ---------------------------------- Attributs privés de la classe -------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
	private $id;                   // identifiant de l'utilisateur (numéro automatique dans la BDD)
	private $pseudo;               // pseudo de l'utilisateur
	private $mdpSha1;			   // mot de passe de l'utilisateur (hashé en SHA1)
	private $adrMail;              // adresse mail de l'utilisateur
	private $numTel;               // numéro de téléphone de l'utilisateur
	private $niveau;               // niveau d'accès : 1 = utilisateur (pratiquant ou proche)    2 = administrateur
	private $dateCreation;         // date de création du compte
	private $nbTraces;             // nombre de traces stockées actuellement
	private $dateDerniereTrace;    // date de début de la dernière trace
// 	private $ceuxQueJautorise;     // la collection des id des utilisateurs que j'autorise à me suivre
// 	private $ceuxQuiMautorisent;   // la collection des id des utilisateurs qui m'autorisent à les suivre
// 	private $mesTraces;            // la collection des id des traces de l'utilisateur
	
	// ------------------------------------------------------------------------------------------------------
	// ----------------------------------------- Constructeur -----------------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
	public function Utilisateur($unId, $unPseudo, $unMdpSha1, $uneAdrMail, $unNumTel, $unNiveau, $uneDateCreation, $unNbTraces, $uneDateDerniereTrace) {
		$this->id = $unId;
		$this->pseudo = $unPseudo;
		$this->mdpSha1 = $unMdpSha1;
		$this->adrMail = $uneAdrMail;
		$this->numTel = Outils::corrigerTelephone($unNumTel);
		$this->niveau = $unNiveau;
		$this->dateCreation = $uneDateCreation;
		$this->nbTraces = $unNbTraces;
		$this->dateDerniereTrace = $uneDateDerniereTrace;
// 		$this->ceuxQueJautorise = array();
// 		$this->ceuxQuiMautorisent = array();
// 		$this->mesTraces = array();
	}	

	// ------------------------------------------------------------------------------------------------------
	// ---------------------------------------- Getters et Setters ------------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
	public function getId()	{return $this->id;}
	public function setId($unId) {$this->id = $unId;}
	
	public function getPseudo()	{return $this->pseudo;}
	public function setPseudo($unPseudo) {$this->pseudo = $unPseudo;}
	
	public function getMdpSha1()	{return $this->mdpSha1;}
	public function setMdpSha1($unMdpSha1) {$this->mdpSha1 = $unMdpSha1;}
	
	public function getAdrMail()	{return $this->adrMail;}
	public function setAdrMail($uneAdrMail) {$this->adrMail = $uneAdrMail;}
	
	public function getNumTel()	{return $this->numTel;}
	public function setNumTel($unNumTel) {$this->numTel = Outils::corrigerTelephone($unNumTel);}

	public function getNiveau()	{return $this->niveau;}
	public function setNiveau($unNiveau) {$this->niveau = $unNiveau;}

	public function getDateCreation()	{return $this->dateCreation;}
	public function setDateCreation($uneDateCreation) {$this->dateCreation = $uneDateCreation;}

	public function getNbTraces()	{return $this->nbTraces;}
	public function setNbTraces($unNbTraces) {$this->nbTraces = $unNbTraces;}
	
	public function getDateDerniereTrace()	{return $this->dateDerniereTrace;}
	public function setDateDerniereTrace($uneDateDerniereTrace) {$this->dateDerniereTrace = $uneDateDerniereTrace;}
	
// 	public function getCeuxQueJautorise()	{return $this->ceuxQueJautorise;}
// 	public function getCeuxQuiMautorisent()	{return $this->ceuxQuiMautorisent;}
// 	public function getMesTraces()	{return $this->mesTraces;}
	
	// ------------------------------------------------------------------------------------------------------
	// -------------------------------------- Méthodes d'instances ------------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
// 	public function ajouteIdACeuxQueJautorise($unIdUtilisateur)
// 	{	// ajoute l'identifiant de l'utilisateur à la liste
// 	    $this->ceuxQueJautorise[] = $unIdUtilisateur;
// 	}
// 	public function getIdUtilisateurAutorise($i)
// 	{	// fournit l'identifiant de l'utilisateur autorisé correspondant à la position $i indiquée
// 	    return $this->ceuxQueJautorise[$i];
// 	}
// 	public function getNbCeuxQueJautorise()
// 	{	// fournit le nombre d'utilisateurs que j'autorise
// 	    return sizeof($this->ceuxQueJautorise);
// 	}
// 	public function viderCeuxQueJautorise()
// 	{	// vide la collection des utilisateurs que j'autorise
// 	    $this->ceuxQueJautorise = array();
// 	}

// 	public function ajouteIdACeuxQuiMautorisent($unIdUtilisateur)
// 	{	// ajoute l'identifiant de l'utilisateur à la liste
// 	    $this->ceuxQuiMautorisent[] = $unIdUtilisateur;
// 	}
// 	public function getIdUtilisateurAutorisant($i)
// 	{	// // fournit l'identifiant de l'utilisateur autorisant correspondant à la position $i indiquée
// 	    return $this->ceuxQuiMautorisent[$i];
// 	}
// 	public function getNbCeuxQuiMautorisent()
// 	{	// fournit le nombre d'utilisateurs qui m'autorisent
// 	    return sizeof($this->ceuxQuiMautorisent);
// 	}
// 	public function viderCeuxQuiMautorisent()
// 	{	// vide la collection des utilisateurs qui m'autorisent
// 	    $this->ceuxQuiMautorisent = array();
// 	}

// 	public function ajouteIdTrace($unIdTrace)
// 	{	// ajoute l'identifiant de la trace à la liste
// 	    $this->mesTraces[] = $unIdTrace;
// 	    $this->nbTraces = sizeof($this->mesTraces);
// 	}
// 	public function getIdTrace($i)
// 	{	// // fournit l'identifiant de la trace correspondant à la position $i indiquée
// 	    return $this->mesTraces[$i];
// 	}
// 	public function viderTraces()
// 	{	// vide la collection des traces de l'utilisateur
// 	    $this->mesTraces = array();
// 	    $this->nbTraces = sizeof($this->mesTraces);
// 	}
	
	public function toString() {
	    $msg = 'id : ' . $this->id . '<br>';
	    $msg .= 'pseudo : ' . $this->pseudo . '<br>';
	    $msg .= 'mdpSha1 : ' . $this->mdpSha1 . '<br>';
	    $msg .= 'adrMail : ' . $this->adrMail . '<br>';
	    $msg .= 'numTel : ' . $this->numTel . '<br>';
	    $msg .= 'niveau : ' . $this->niveau . '<br>';
	    $msg .= 'dateCreation : ' . $this->dateCreation . '<br>';
	    $msg .= 'nbTraces : ' . $this->nbTraces . '<br>';
	    $msg .= 'dateDerniereTrace : ' . $this->dateDerniereTrace . '<br>';
	    
// 	    $msg .= "nombre d'utilisateurs que j'autorise : " . $this->getNbCeuxQueJautorise() . '<br>';
// 	    // ajout des id des utilisateurs que j'autorise dans la chaîne
// 	    foreach ($this->ceuxQueJautorise as $unId)
// 	    {	$msg .= $unId . " - ";
// 	    }
// 	    $msg .= '<br>';
	    
// 	    $msg .= "nombre d'utilisateurs qui m'autorisent : " . $this->getNbCeuxQuiMautorisent() . '<br>';
// 	    // ajout des id des utilisateurs qui m'autorisent dans la chaîne
// 	    foreach ($this->ceuxQuiMautorisent as $unId)
// 	    {	$msg .= $unId . " - ";
// 	    }
// 	    $msg .= '<br>';

// 	    $msg .= "nombre de traces : " . $this->getNbTraces() . '<br>';
// 	    // ajout des id des traces dans la chaîne
// 	    foreach ($this->mesTraces as $unId)
// 	    {	$msg .= $unId . " - ";
// 	    }
// 	    $msg .= '<br>';
	    
	    return $msg;
	}
	
} // fin de la classe Utilisateur

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces après la balise de fin de script !!!!!!!!!!!!