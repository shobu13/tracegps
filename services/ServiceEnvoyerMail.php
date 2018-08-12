<?php
// fichier : http://sio.lyceedelasalle.fr/ae/services/ServiceEnvoyerMail.php
// Dernière mise à jour : 18/5/2018 par Jim

// Rôle : ce service permet à une application d'envoyer un courriel à partir du serveur serv-wamp1 du lycée De La Salle
// Il ne peut être appelé qu'à partir d'un poste de travail du lycée.
// Le service web doit recevoir 4 paramètres : adresseDestinataire, sujet, message, adresseEmetteur
//     adresseDestinataire : l'adresse du destinataire
//     sujet               : le sujet du courriel
//     message             : le texte du courriel
//     adresseEmetteur     : l'adresse de l'émetteur
// Le service retourne un flux de données XML contenant le compte rendu d'exécution ("true" si OK, "false" si pas OK)

// Les paramètres sont passés par la méthode GET :
//     http://sio.lyceedelasalle.fr/tracegps/services/ServiceEnvoyerMail.php?adresseDestinataire=delasalle.sio.eleves@gmail.com&sujet=le sujet du mail&message=le texte du message&adresseEmetteur=delasalle.sio.crib@gmail.com

// Récupération des données transmises
// la fonction $_REQUEST récupère par défaut le contenu des variables $_GET, $_POST, $_COOKIE
if ( empty ($_REQUEST["adresseDestinataire"]) == true) $adresseDestinataire = "";  else $adresseDestinataire = $_REQUEST["adresseDestinataire"];
if ( empty ($_REQUEST["sujet"]) == true)  $sujet = "";  else   $sujet = $_REQUEST["sujet"];
if ( empty ($_REQUEST["message"]) == true) $message = "";  else $message = $_REQUEST["message"];
if ( empty ($_REQUEST["adresseEmetteur"]) == true) $adresseEmetteur = "";  else $adresseEmetteur = $_REQUEST["adresseEmetteur"];

// Contrôle de la présence des paramètres
if ($adresseDestinataire == "" || $sujet == "" || $message == "" || $adresseEmetteur == "" )
{	$msg = "false";
}
else
{	// utilisation d'une expression régulière pour vérifier si c'est une adresse Gmail :
    if ( preg_match ( "#^.+@gmail\.com$#" , $adresseDestinataire) == true) {
        // on commence par enlever les points dans l'adresse gmail car ils ne sont pas pris en compte
        $adresseDestinataire = str_replace(".", "", $adresseDestinataire);
        // puis on remet le point de "@gmail.com"
        $adresseDestinataire = str_replace("@gmailcom", "@gmail.com", $adresseDestinataire);
    }
    // envoi du mail avec la fonction mail de PHP
    try {
        $ok = mail($adresseDestinataire , $sujet , $message, "From: " . $adresseEmetteur);
        $msg = "true";
    }
    catch (Exception $ex) {
        $msg = "false";
    }
}

// création du flux XML en sortie

/* Exemple de code XML
 <?xml version="1.0" encoding="UTF-8"?>
 <data>
 <reponse>true</reponse>
 </data>
 */

// crée une instance de DOMdocument (DOM : Document Object Model)
$doc = new DOMDocument();

// specifie la version et le type d'encodage
$doc->version = '1.0';
$doc->encoding = 'UTF-8';

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

?>
