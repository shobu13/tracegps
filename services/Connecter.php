<?php
// Projet TraceGPS - services web
// fichier : services/Connecter.php
// Dernière mise à jour : 14/1/2018 par Jim

// Rôle : ce service permet à un utilisateur de s'authentifier
// Le service web doit recevoir 2 paramètres :
//     pseudo : le pseudo de l'utilisateur
//     mdpSha1 : le mot de passe hashé en sha1
// Le service retourne un flux de données XML contenant un compte-rendu d'exécution

// Les paramètres peuvent être passés par la méthode GET (pratique pour les tests, mais à éviter en exploitation) :
//     http://<hébergeur>/Connecter.php?pseudo=europa&mdpSha1=13e3668bbee30b004380052b086457b014504b3e

// Les paramètres peuvent être passés par la méthode POST (à privilégier en exploitation pour la confidentialité des données) :
//     http://<hébergeur>/Connecter.php
	
// Récupération des données transmises
// la fonction $_GET récupère une donnée passée en paramètre dans l'URL par la méthode GET
// la fonction $_POST récupère une donnée envoyées par la méthode POST
// la fonction $_REQUEST récupère par défaut le contenu des variables $_GET, $_POST, $_COOKIE
if ( empty ($_REQUEST ["pseudo"]) == true)  $pseudo = "";  else   $pseudo = $_REQUEST ["pseudo"];
if ( empty ($_REQUEST ["mdpSha1"]) == true)  $mdpSha1 = "";  else   $mdpSha1 = $_REQUEST ["mdpSha1"];

// Contrôle de la présence des paramètres
if ( $pseudo == "" || $mdpSha1 == "" )
{	$msg = "Erreur : données incomplètes ou incorrectes !";
}
else
{	// connexion du serveur web à la base MySQL
	include_once ('../modele/DAO.class.php');
	$dao = new DAO();
	$niveauConnexion = $dao->getNiveauConnexion($pseudo, $mdpSha1);
	
	if ( $niveauConnexion == 0 ) $msg = "Erreur : authentification incorrecte !";	
	if ( $niveauConnexion == 1 ) $msg = "Utilisateur authentifié.";
	if ( $niveauConnexion == 2 ) $msg = "Administrateur authentifié.";
	
	// ferme la connexion à MySQL :
	unset($dao);
}

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
	$elt_commentaire = $doc->createComment('Service web Connecter - BTS SIO - Lycée De La Salle - Rennes');
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
