<?php
// Projet TraceGPS
// fichier : modele/DAO.test.php
// Rôle : test de la classe DAO.class.php
// Dernière mise à jour : 12/8/2018 par JM CARTRON
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Test de la classe DAO</title>
	<style type="text/css">body {font-family: Arial, Helvetica, sans-serif; font-size: small;}</style>
</head>
<body>

<?php
// connexion du serveur web à la base MySQL
include_once ('DAO.class.php');
//include_once ('_DAO.mysql.class.php');
$dao = new DAO();

/*
// test de la méthode getNiveauConnexion ----------------------------------------------------------
// modifié par Jim le 12/8/2018
echo "<h3>Test de getNiveauConnexion : </h3>";
$niveau = $dao->getNiveauConnexion("admin", sha1("mdpadmin"));
echo "<p>Niveau de ('admin', 'mdpadmin') : " . $niveau . "</br>";

$niveau = $dao->getNiveauConnexion("europa", sha1("mdputilisateur"));
echo "<p>Niveau de ('europa', 'mdputilisateur') : " . $niveau . "</br>";

$niveau = $dao->getNiveauConnexion("europa", sha1("123456"));
echo "<p>Niveau de ('europa', '123456') : " . $niveau . "</br>";

$niveau = $dao->getNiveauConnexion("toto", sha1("mdputilisateur"));
echo "<p>Niveau de ('toto', 'mdputilisateur') : " . $niveau . "</br>";


// test de la méthode existePseudoUtilisateur -----------------------------------------------------
// modifié par Jim le 12/8/2018
echo "<h3>Test de existePseudoUtilisateur : </h3>";
if ($dao->existePseudoUtilisateur("admin")) $existe = "oui"; else $existe = "non";
echo "<p>Existence de l'utilisateur 'admin' : <b>" . $existe . "</b><br>";
if ($dao->existePseudoUtilisateur("europa")) $existe = "oui"; else $existe = "non";
echo "Existence de l'utilisateur 'europa' : <b>" . $existe . "</b></br>";
if ($dao->existePseudoUtilisateur("toto")) $existe = "oui"; else $existe = "non";
echo "Existence de l'utilisateur 'toto' : <b>" . $existe . "</b></p>";


// test de la méthode getUnUtilisateur -----------------------------------------------------------
// modifié par Jim le 12/8/2018
echo "<h3>Test de getUnUtilisateur : </h3>";
$unUtilisateur = $dao->getUnUtilisateur("admin");
if ($unUtilisateur) {
    echo "<p>L'utilisateur admin existe : <br>" . $unUtilisateur->toString() . "</p>";
}
else {
    echo "<p>L'utilisateur admin n'existe pas !</p>";
}
$unUtilisateur = $dao->getUnUtilisateur("europa");
if ($unUtilisateur) {
    echo "<p>L'utilisateur europa existe : <br>" . $unUtilisateur->toString() . "</p>";
}
else {
    echo "<p>L'utilisateur europa n'existe pas !</p>";
}
$unUtilisateur = $dao->getUnUtilisateur("admon");
if ($unUtilisateur) {
    echo "<p>L'utilisateur admon existe : <br>" . $unUtilisateur->toString() . "</p>";
}
else {
    echo "<p>L'utilisateur admon n'existe pas !</p>";
}
    

// test de la méthode getTousLesUtilisateurs ------------------------------------------------------
// modifié par Jim le 12/8/2018
echo "<h3>Test de getTousLesUtilisateurs : </h3>";
$lesUtilisateurs = $dao->getTousLesUtilisateurs();
$nbReponses = sizeof($lesUtilisateurs);
echo "<p>Nombre d'utilisateurs : " . $nbReponses . "</p>";
// affichage des utilisateurs
foreach ($lesUtilisateurs as $unUtilisateur)
{	echo ($unUtilisateur->toString());
    echo ('<br>');
}


// test de la méthode creerUnUtilisateur ----------------------------------------------------------
// modifié par Jim le 12/8/2018
echo "<h3>Test de creerUnUtilisateur : </h3>";
$unUtilisateur = new Utilisateur(0, "toto", "mdputilisateur", "toto@gmail.com", "5566778899", 1, date('Y-m-d H:i:s', time()), 0, null);
$ok = $dao->creerUnUtilisateur($unUtilisateur);
if ($ok)
{   echo "<p>Utilisateur bien enregistré !</p>";
    echo $unUtilisateur->toString();
}
else {
    echo "<p>Echec lors de l'enregistrement de l'utilisateur !</p>";
}


// test de la méthode modifierMdpUtilisateur ------------------------------------------------------
// modifié par Jim le 12/8/2018
echo "<h3>Test de modifierMdpUtilisateur : </h3>";
$unUtilisateur = $dao->getUnUtilisateur("toto");
if ($unUtilisateur) {
    echo "<p>Ancien mot de passe de l'utilisateur toto : <b>" . $unUtilisateur->getMdpSha1() . "</b><br>";
    $dao->modifierMdpUtilisateur("toto", "mdpadmin");
    $unUtilisateur = $dao->getUnUtilisateur("toto");
    echo "Nouveau mot de passe de l'utilisateur toto : <b>" . $unUtilisateur->getMdpSha1() . "</b><br>";
    
    $niveauDeConnexion = $dao->getNiveauConnexion('toto', sha1('mdputilisateur'));
    echo "Niveau de connexion de ('toto', 'mdputilisateur') : <b>" . $niveauDeConnexion . "</b><br>";
    
    $niveauDeConnexion = $dao->getNiveauConnexion('toto', sha1('mdpadmin'));
    echo "Niveau de connexion de ('toto', 'mdpadmin') : <b>" . $niveauDeConnexion . "</b></p>";
}
else {
    echo "<p>L'utilisateur toto n'existe pas !</p>";
}


// test de la méthode supprimerUnUtilisateur ------------------------------------------------------
// modifié par Jim le 12/8/2018
echo "<h3>Test de supprimerUnUtilisateur : </h3>";
$ok = $dao->supprimerUnUtilisateur("toto");
if ($ok) {
    echo "<p>Utilisateur toto bien supprimé !</p>";
}
else {
    echo "<p>Echec lors de la suppression de l'utilisateur toto !</p>";
}
$ok = $dao->supprimerUnUtilisateur("toto");
if ($ok) {
    echo "<p>Utilisateur toto bien supprimé !</p>";
}
else {
    echo "<p>Echec lors de la suppression de l'utilisateur toto !</p>";
}


// test de la méthode envoyerMdp ------------------------------------------------------------------
// modifié par Jim le 12/8/2018
echo "<h3>Test de envoyerMdp : </h3>";
// pour ce test, une adresse mail que vous pouvez consulter
$unUtilisateur = new Utilisateur(0, "toto", "mdputilisateur", "jean.michel.cartron@gmail.com", "5566778899", 2, date('Y-m-d H:i:s', time()), 0, null);
$ok = $dao->creerUnUtilisateur($unUtilisateur);
$dao->modifierMdpUtilisateur("toto", "mdpadmin");
$ok = $dao->envoyerMdp("toto", "mdpadmin");
if ($ok) {
    echo "<p>Mail bien envoyé !</p>";
}
else {
    echo "<p>Echec lors de l'envoi du mail !</p>";
}
// supprimer le compte créé
$ok = $dao->supprimerUnUtilisateur("toto");
if ($ok) {
    echo "<p>Utilisateur toto bien supprimé !</p>";
}
else {
    echo "<p>Echec lors de la suppression de l'utilisateur toto !</p>";
}
*/


// Le code restant à développer va être réparti entre les membres de l'équipe de développement.
// Afin de limiter les conflits avec GitHub, il est décidé d'attribuer une zone de ce fichier à chaque développeur.
// Développeur 1 : lignes 180 à 299
// Développeur 2 : lignes 300 à 399
// Développeur 3 : lignes 400 à 500

// Quelques conseils pour le travail collaboratif :
// avant d'attaquer un cycle de développement (début de séance, nouvelle méthode, ...), faites un Pull pour récupérer
// la dernière version du fichier.
// Après avoir testé et validé une méthode, faites un commit et un push pour transmettre cette version aux autres développeurs.


// --------------------------------------------------------------------------------------
// début de la zone attribuée au développeur 1 (xxxxxxxxxxxxxxxxxxxx) : lignes 180 à 299
// --------------------------------------------------------------------------------------


// test de la méthode existeAdrMailUtilisateur ----------------------------------------------------
// modifié par Jim le 12/8/2018
echo "<h3>Test de existeAdrMailUtilisateur : </h3>";
if ($dao->existeAdrMailUtilisateur("admin@gmail.com")) $existe = "oui"; else $existe = "non";
echo "<p>Existence de l'utilisateur 'admin@gmail.com' : <b>" . $existe . "</b><br>";
if ($dao->existeAdrMailUtilisateur("delasalle.sio.eleves@gmail.com")) $existe = "oui"; else $existe = "non";
echo "Existence de l'utilisateur 'delasalle.sio.eleves@gmail.com' : <b>" . $existe . "</b></br>";



/*
 // test de la méthode getLesUtilisateursAutorisant ------------------------------------------------
 // modifié par Jim le 9/1/2018
 echo "<h3>Test de getLesUtilisateursAutorisant(idUtilisateur) : </h3>";
 $lesUtilisateurs = $dao->getLesUtilisateursAutorisant(4);
 $nbReponses = sizeof($lesUtilisateurs);
 echo "<p>Nombre d'utilisateurs autorisant l'utilisateur 4 à voir leurs parcours : " . $nbReponses . "</p>";
 // affichage des utilisateurs
 foreach ($lesUtilisateurs as $unUtilisateur)
 {	echo ($unUtilisateur->toString());
 echo ('<br>');
 }
 */


/*
 // test de la méthode getLesUtilisateursAutorises -------------------------------------------------
 // modifié par Jim le 9/1/2018
 echo "<h3>Test de getLesUtilisateursAutorises(idUtilisateur) : </h3>";
 $lesUtilisateurs = $dao->getLesUtilisateursAutorises(2);
 $nbReponses = sizeof($lesUtilisateurs);
 echo "<p>Nombre d'utilisateurs autorisés par l'utilisateur 2 : " . $nbReponses . "</p>";
 // affichage des utilisateurs
 foreach ($lesUtilisateurs as $unUtilisateur)
 {	echo ($unUtilisateur->toString());
 echo ('<br>');
 }
 */


/*
// test de la méthode autoriseAConsulter ----------------------------------------------------------
// modifié par Jim le 9/1/2018
echo "<h3>Test de autoriseAConsulter : </h3>";
if ($dao->autoriseAConsulter(2, 3)) $autorise = "oui"; else $autorise = "non";
echo "<p>L'utilisateur 2 autorise l'utilisateur 3 : <b>" . $autorise . "</b><br>";

if ($dao->autoriseAConsulter(3, 2)) $autorise = "oui"; else $autorise = "non";
echo "<p>L'utilisateur 3 autorise l'utilisateur 2 : <b>" . $autorise . "</b><br>";
*/


/*
// test de la méthode creerUneAutorisation ---------------------------------------------------------
// modifié par Jim le 9/1/2018
echo "<h3>Test de creerUneAutorisation : </h3>";
if ($dao->creerUneAutorisation(2, 1)) $ok = "oui"; else $ok = "non";
echo "<p>La création de l'autorisation de l'utilisateur 2 vers l'utilisateur 1 a réussi : <b>" . $ok . "</b><br>";

if ($dao->creerUneAutorisation(2, 1)) $ok = "oui"; else $ok = "non";
echo "<p>La création de l'autorisation de l'utilisateur 2 vers l'utilisateur 1 a réussi : <b>" . $ok . "</b><br>";
*/


/*
// test de la méthode supprimerUneAutorisation ----------------------------------------------------
// modifié par Jim le 9/1/2018
echo "<h3>Test de supprimerUneAutorisation : </h3>";
if ($dao->supprimerUneAutorisation(2, 1)) $ok = "oui"; else $ok = "non";
echo "<p>La suppression de l'autorisation de l'utilisateur 2 vers l'utilisateur 1 a réussi : <b>" . $ok . "</b><br>";
*/


/*
// test de la méthode getUneTrace -----------------------------------------------------------------
// modifié par Jim le 9/1/2018
echo "<h3>Test de getUneTrace : </h3>";
$uneTrace = $dao->getUneTrace(2);
if ($uneTrace)
    echo "<p>La trace 2 existe : <br>" . $uneTrace->toString() . "</p>";
else
    echo "<p>La trace 2 n'existe pas !</p>";
        
$uneTrace = $dao->getUneTrace(100);
if ($uneTrace)
    echo "<p>La trace 100 existe : <br>" . $uneTrace->toString() . "</p>";
else
    echo "<p>La trace 100 n'existe pas !</p>";
*/
       

/*
// test de la méthode getToutesLesTraces ----------------------------------------------------------
// modifié par Jim le 9/1/2018
echo "<h3>Test de getToutesLesTraces : </h3>";
$lesTraces = $dao->getToutesLesTraces();
$nbReponses = sizeof($lesTraces);
echo "<p>Nombre de traces : " . $nbReponses . "</p>";
// affichage des traces
foreach ($lesTraces as $uneTrace)
{	echo ($uneTrace->toString());
    echo ('<br>');
}
*/


/*
// test de la méthode getLesTraces($idUtilisateur) ------------------------------------------------
// modifié par Jim le 9/1/2018
echo "<h3>Test de getLesTraces(idUtilisateur) : </h3>";
$lesTraces = $dao->getLesTraces(2);
$nbReponses = sizeof($lesTraces);
echo "<p>Nombre de traces de l'utilisateur 2 : " . $nbReponses . "</p>";
// affichage des traces
foreach ($lesTraces as $uneTrace)
{	echo ($uneTrace->toString());
    echo ('<br>');
}
*/


/*
// test de la méthode getLesTracesAutorisees($idUtilisateur) --------------------------------------
// modifié par Jim le 9/1/2018
echo "<h3>Test de getLesTracesAutorisees(idUtilisateur) : </h3>";
$lesTraces = $dao->getLesTracesAutorisees(2);
$nbReponses = sizeof($lesTraces);
echo "<p>Nombre de traces autorisées à l'utilisateur 2 : " . $nbReponses . "</p>";
// affichage des traces
foreach ($lesTraces as $uneTrace)
{	echo ($uneTrace->toString());
    echo ('<br>');
}
$lesTraces = $dao->getLesTracesAutorisees(3);
$nbReponses = sizeof($lesTraces);
echo "<p>Nombre de traces autorisées à l'utilisateur 3 : " . $nbReponses . "</p>";
// affichage des traces
foreach ($lesTraces as $uneTrace)
{	echo ($uneTrace->toString());
    echo ('<br>');
}
*/


/*
// test de la méthode creerUneTrace ----------------------------------------------------------
// modifié par Jim le 9/1/2018
echo "<h3>Test de creerUneTrace : </h3>";
$trace1 = new Trace(0, "2017-12-18 14:00:00", "2017-12-18 14:10:00", true, 3);
$ok = $dao->creerUneTrace($trace1);
if ($ok)
{   echo "<p>Trace bien enregistrée !</p>";
    echo $trace1->toString();
}
else
    echo "<p>Echec lors de l'enregistrement de la trace !</p>";

$trace2 = new Trace(0, date('Y-m-d H:i:s', time()), null, false, 3);
$ok = $dao->creerUneTrace($trace2);
if ($ok)
{   echo "<p>Trace bien enregistrée !</p>";
    echo $trace2->toString();
}
else
    echo "<p>Echec lors de l'enregistrement de la trace !</p>";
*/


/*
// test de la méthode supprimerUneTrace -----------------------------------------------------------
// modifié par Jim le 10/1/2018
echo "<h3>Test de supprimerUneTrace : </h3>";
$ok = $dao->supprimerUneTrace(22);
if ($ok)
    echo "<p>Trace bien supprimée !</p>";
else
    echo "<p>Echec lors de la suppression de la trace !</p>";
*/


/*
// test des méthodes creerUnPointDeTrace et terminerUneTrace --------------------------------------
// modifié par Jim le 19/1/2018
echo "<h3>Test de creerUnPointDeTrace et terminerUneTrace : </h3>";
//$laTrace = new Trace(0, date('Y-m-d H:i:s', time()), null, false, 3);
$laTrace = new Trace(0, date('Y-m-d H:i:s', time()), NULL, FALSE, 3);
$ok = $dao->creerUneTrace($laTrace);
for ($i = 1 ; $i <= 10 ; $i++)
{
    $unIdTrace = $laTrace->getId();
    $unID = $i;
    $uneLatitude = 48.2099 + $i * 0.001;
    $uneLongitude = -1.5545 + $i * 0.001;
    $uneAltitude = 50 + $i * 10;
    $uneDateHeure = date('Y-m-d H:i:s', time() + $i*20 - 20);   // un point toutes les 20 secondes
    $unRythmeCardio = 80 + $i;
    $unTempsCumule = $i - 1;
    $uneDistanceCumulee = ($i-1) * 10;
    $uneVitesse = 15;
    $unPoint = new PointDeTrace($unIdTrace, $unID, $uneLatitude, $uneLongitude, $uneAltitude, $uneDateHeure, $unRythmeCardio, $unTempsCumule, $uneDistanceCumulee, $uneVitesse);
    
    $ok = $dao->creerUnPointDeTrace($unPoint);
}
$dao->terminerUneTrace($unIdTrace);
$laTrace = $dao->getUneTrace($unIdTrace);
echo "<h4>méthode toString sur objet laTrace : </h4>";
echo ($laTrace->toString());
echo ('<br>');
*/


/*
// test des méthodes creerUnPointDeTrace et terminerUneTrace --------------------------------------
// modifié par Jim le 19/1/2018
echo "<h3>Création de 2 traces par utilisateur : </h3>";
for ($idUtilisateur = 2 ; $idUtilisateur <= 12 ; $idUtilisateur++)
{   // création d'une première trace non terminée en forêt de Rennes avec 5 points
    $laTrace = new Trace(0, date('Y-m-d H:i:s', time()), null, FALSE, $idUtilisateur);
    $ok = $dao->creerUneTrace($laTrace);
    $unIdTrace = $laTrace->getId();
    for ($i = 1 ; $i <= 5 ; $i++)
    {
        $unID = $i;
        $uneLatitude = 48.2099 + $i * 0.001;
        $uneLongitude = -1.5545 + $i * 0.001;
        $uneAltitude = 50 + $i * 10;                                // on monte de 10 m entre chaque point
        $uneDateHeure = date('Y-m-d H:i:s', time() + $i*20 - 20);   // un point toutes les 20 secondes
        $unRythmeCardio = 80 + $i;                                  // le rythme monte de 1 entre chaque point
        $unTempsCumule = 0;
        $uneDistanceCumulee = 0;
        $uneVitesse = 0;
        $unPoint = new PointDeTrace($unIdTrace, $unID, $uneLatitude, $uneLongitude, $uneAltitude, $uneDateHeure, $unRythmeCardio, $unTempsCumule, $uneDistanceCumulee, $uneVitesse);
        
        $ok = $dao->creerUnPointDeTrace($unPoint);
    }
    $laTrace = $dao->getUneTrace($unIdTrace);
    echo "<h4>méthode toString sur objet laTrace : </h4>";
    echo ($laTrace->toString());
    echo ('<br>');
    
    // création d'une deuxième trace terminée en forêt de Rennes avec 10 points
    $laTrace = new Trace(0, date('Y-m-d H:i:s', time()), null, FALSE, $idUtilisateur);
    $ok = $dao->creerUneTrace($laTrace);
    $unIdTrace = $laTrace->getId();
    for ($i = 1 ; $i <= 10 ; $i++)
    {
        $unID = $i;
        $uneLatitude = 48.2099 + $i * 0.001;
        $uneLongitude = -1.5545 + $i * 0.001;
        $uneAltitude = 50 + $i * 10;                                // on monte de 10 m entre chaque point
        $uneDateHeure = date('Y-m-d H:i:s', time() + $i*20 - 20);   // un point toutes les 20 secondes
        $unRythmeCardio = 80 + $i;                                  // le rythme monte de 1 entre chaque point
        $unTempsCumule = 0;
        $uneDistanceCumulee = 0;
        $uneVitesse = 0;
        $unPoint = new PointDeTrace($unIdTrace, $unID, $uneLatitude, $uneLongitude, $uneAltitude, $uneDateHeure, $unRythmeCardio, $unTempsCumule, $uneDistanceCumulee, $uneVitesse);
        
        $ok = $dao->creerUnPointDeTrace($unPoint);
    }
    // on termine la trace
    $dao->terminerUneTrace($unIdTrace);
    $laTrace = $dao->getUneTrace($unIdTrace);
    echo "<h4>méthode toString sur objet laTrace : </h4>";
    echo ($laTrace->toString());
    echo ('<br>');
}
*/


// ferme la connexion à MySQL :
unset($dao);
?>

</body>
</html>