<?php
// Projet TraceGPS - services web
// fichier :  services/CreerUtilisateur.php
// Dernière mise à jour : 15/1/2018 par Jim

// Rôle : ce service permet à un utilisateur de se créer un compte
// Le service web doit recevoir 3 paramètres :
//     pseudo : le pseudo de l'utilisateur
//     adrMail : son adresse mail
//     numTel : son numéro de téléphone
// Le service retourne un flux de données XML contenant un compte-rendu d'exécution

// Les paramètres peuvent être passés par la méthode GET (pratique pour les tests, mais à éviter en exploitation) :
//     http://<hébergeur>/CreerUtilisateur.php?pseudo=turlututu&adrMail=delasalle.sio.eleves@gmail.com&numTel=1122334455

// Les paramètres peuvent être passés par la méthode POST (à privilégier en exploitation pour la confidentialité des données) :
//     http://<hébergeur>/CreerUtilisateur.php

// connexion du serveur web à la base MySQL
include_once ('../modele/DAO.class.php');
$dao = new DAO();

// Récupération des données transmises
// la fonction $_GET récupère une donnée passée en paramètre dans l'URL par la méthode GET
// la fonction $_POST récupère une donnée envoyées par la méthode POST
// la fonction $_REQUEST récupère par défaut le contenu des variables $_GET, $_POST, $_COOKIE
if ( empty ($_REQUEST ["pseudo"]) == true) $pseudo = "";  else $pseudo = $_REQUEST ["pseudo"];
if ( empty ($_REQUEST ["adrMail"]) == true)  $adrMail = "";  else $adrMail = $_REQUEST ["adrMail"];
if ( empty ($_REQUEST ["numTel"]) == true) $numTel = "";  else $numTel = $_REQUEST ["numTel"];

// Contrôle de la présence des paramètres
if ($pseudo == '' || $adrMail == '' || Outils::estUnNumTelValide($numTel) == false) {
	$msg = "Erreur : données incomplètes ou incorrectes !";
}
else {
    if ( strlen($pseudo) < 8 || $dao->existePseudoUtilisateur($pseudo) ) {
		$msg = "Erreur : pseudo trop court (8 car minimum) ou déjà existant !";
	}
	else {
	    if ( Outils::estUneAdrMailValide($adrMail) == false || $dao->existeAdrMailUtilisateur($adrMail) ) {
	        $msg = "Erreur : adresse mail incorrecte ou déjà existante !";
	    }
		else
		{	
			// création d'un mot de passe aléatoire de 8 caractères
			$password = Outils::creerMdp();
			$niveau = 1;                                     // 1 = utilisateur normal
			$dateCreation = date('Y-m-d H:i:s', time());     // date courante
			$nbTraces = 0;
			$dateDerniereTrace = null;
			// enregistrement de l'utilisateur dans la BDD
			$unUtilisateur = new Utilisateur(0, $pseudo, $password, $adrMail, $numTel, $niveau, $dateCreation, $nbTraces, $dateDerniereTrace);
			$ok = $dao->creerUnUtilisateur($unUtilisateur);
			if ( ! $ok ) {
				$msg = "Erreur : problème lors de l'enregistrement !";
			}
			else {
				// envoi d'un mail de confirmation de l'enregistrement
			    // envoi d'un mail de confirmation de l'enregistrement
			    $sujet = "Création de votre compte dans le système TraceGPS";
			    $contenuMail = "Vous venez de vous créer un compte utilisateur.\n\n";
			    $contenuMail .= "Les données enregistrées sont :\n\n";
			    $contenuMail .= "Votre pseudo : " . $pseudo . "\n";
			    $contenuMail .= "Votre mot de passe : " . $password . " (nous vous conseillons de le changer lors de la première connexion)\n";
			    $contenuMail .= "Votre numéro de téléphone : " . $unUtilisateur->getNumTel() . "\n";
			    
			    $ok = Outils::envoyerMail($adrMail, $sujet, $contenuMail, $ADR_MAIL_EMETTEUR);
			    if ( ! $ok ) {
					// l'envoi de mail a échoué
					$msg = "Erreur : enregistrement effectué. L'envoi du courriel à l'utilisateur a rencontré un problème !";
				}
				else {
					// tout a bien fonctionné
					$msg = "Enregistrement effectué. Vous allez recevoir un courriel avec votre mot de passe.";
				}
			}
		}
	}
}
// ferme la connexion à MySQL :
unset($dao);

// création du flux XML en sortie
creerFluxXML ($msg);

// fin du programme (pour ne pas enchainer sur la fonction qui suit)
exit;


// création du flux XML en sortie
function creerFluxXML($msg)
{	// crée une instance de DOMdocument (DOM : Document Object Model)
	$doc = new DOMDocument();	

	// specifie la version et le type d'encodage
	$doc->version = '1.0';
	$doc->encoding = 'UTF-8';
	
	// crée un commentaire et l'encode en UTF-8
	$elt_commentaire = $doc->createComment('Service web CreerUtilisateur - BTS SIO - Lycée De La Salle - Rennes');
	// place ce commentaire à la racine du document XML
	$doc->appendChild($elt_commentaire);
		
	// crée l'élément 'data' à la racine du document XML
	$elt_data = $doc->createElement('data');
	$doc->appendChild($elt_data);
	
	// place l'élément 'reponse' juste après l'élément 'data'
	$elt_reponse = $doc->createElement('reponse', $msg);
	$elt_data->appendChild($elt_reponse);
	
	// Mise en forme finale
	$doc->formatOutput = true;
	
	// renvoie le contenu XML
	echo $doc->saveXML();
	return;
}
?>