<?php
// Projet TraceGPS - services web
// fichier :  services/ArreterEnregistrementParcours.php
// Dernière mise à jour : 25/1/2018 par Jim

// Rôle : ce service permet à un utilisateur de terminer l'enregistrement de son parcours
// Le service web doit recevoir 3 paramètres :
//     pseudo : le pseudo de l'utilisateur
//     mdpSha1 : le mot de passe hashé en sha1
//     idTrace : l'id de la trace à terminer
// Le service retourne un flux de données XML contenant un compte-rendu d'exécution (avec l'id du point créé)

// Les paramètres peuvent être passés par la méthode GET (pratique pour les tests, mais à éviter en exploitation) :
//     http://<hébergeur>/ArreterEnregistrementParcours.php?pseudo=europa&mdpSha1=13e3668bbee30b004380052b086457b014504b3e&idTrace=26

// Les paramètres peuvent être passés par la méthode POST (à privilégier en exploitation pour la confidentialité des données) :
//     http://<hébergeur>/ArreterEnregistrementParcours.php

// connexion du serveur web à la base MySQL
include_once ('../modele/DAO.class.php');
$dao = new DAO();

// Récupération des données transmises
// la fonction $_GET récupère une donnée passée en paramètre dans l'URL par la méthode GET
// la fonction $_POST récupère une donnée envoyées par la méthode POST
// la fonction $_REQUEST récupère par défaut le contenu des variables $_GET, $_POST, $_COOKIE
if ( empty ($_REQUEST ["pseudo"]) == true)  $pseudo = "";  else   $pseudo = $_REQUEST ["pseudo"];
if ( empty ($_REQUEST ["mdpSha1"]) == true)  $mdpSha1 = "";  else   $mdpSha1 = $_REQUEST ["mdpSha1"];
if ( empty ($_REQUEST ["idTrace"]) == true)  $idTrace = "";  else   $idTrace = $_REQUEST ["idTrace"];

// initialisation
$unPoint = null;

// Contrôle de la présence des paramètres
if ( $pseudo == "" || $mdpSha1 == "" || $idTrace == "" )
{	$msg = "Erreur : données incomplètes !";
}
else
{	if ( $dao->getNiveauConnexion($pseudo, $mdpSha1) == 0 )
    {   $msg = "Erreur : authentification incorrecte !";
    }
    else
    {   // récupération de la trace
        $laTrace = $dao->getUneTrace($idTrace);
        if ($laTrace == null)
        {   $msg = "Erreur : le numéro de trace n'existe pas !";
        }
        else 
        {   // récupération de l'id de l'utilisateur
            $idUtilisateurConsulte = $dao->getUnUtilisateur($pseudo)->getId();
            if ($idUtilisateurConsulte != $laTrace->getIdUtilisateur())
            {   $msg = "Erreur : le numéro de trace ne correspond pas à cet utilisateur !";
            }
            else 
            {   // tester si la trace est déjà terminée
                if ($laTrace->getTerminee() == true)
                {   $msg = "Erreur : cette trace est déjà terminée !";
                }
                else
                {   // on termine la trace
                    $ok =  $dao->terminerUneTrace($idTrace);
                    if (! $ok)
                    {   $msg = "Erreur : problème lors de la fin de l'enregistrement de la trace !";
                    }
                    else
                    {   $msg = "Enregistrement terminé.";
                    }
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
	$elt_commentaire = $doc->createComment('Service web ArreterEnregistrementParcours - BTS SIO - Lycée De La Salle - Rennes');
	// place ce commentaire à la racine du document XML
	$doc->appendChild($elt_commentaire);
		
	// crée l'élément 'data' à la racine du document XML
	$elt_data = $doc->createElement('data');
	$doc->appendChild($elt_data);
	
	// place l'élément 'reponse' juste après l'élément 'data'
	$elt_reponse = $doc->createElement('reponse', $msg);
	$elt_data->appendChild($elt_reponse);
	
	// place l'élément 'donnees' dans l'élément 'data'
	$elt_donnees = $doc->createElement('donnees');
	$elt_data->appendChild($elt_donnees);
	
	// Mise en forme finale
	$doc->formatOutput = true;
	
	// renvoie le contenu XML
	echo $doc->saveXML();
	return;
}
?>