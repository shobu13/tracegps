<?php
// Projet TraceGPS
// fichier : modele/Utilisateur.test.php
// Rôle : test de la classe Utilisateur.class.php
// Dernière mise à jour : 18/7/2018 par JM CARTRON

include_once ('Utilisateur.class.php');
//include_once ('Trace.class.php');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Test de la classe Utilisateur</title>
	<style type="text/css">body {font-family: Arial, Helvetica, sans-serif; font-size: small;}</style>
</head>
<body>

<?php
echo "<h3>Test de la classe Utilisateur</h3>";

// tests du constructeur et des accesseurs (get)
$utilisateur1 = new Utilisateur(1, "Tess Tuniter", sha1("mdputilisateur"), "tess.tuniter@gmail.com", "1122334455", 1, date('Y-m-d H:i:s', time()), 0, null);
// $utilisateur2 = new Utilisateur(2, "Chantal Gorithme", sha1("mdpadmin"), "chantal.gorithme@gmail.com", "2233445566", 2, date('Y-m-d H:i:s', time()), 0, null);
// $utilisateur3 = new Utilisateur(3, "Amédée Bogueur", sha1("mdputilisateur"), "amedee.bogueur@gmail.com", "3344556677", 1, date('Y-m-d H:i:s', time()), 0, null);

// $trace1 = new Trace(1, "2017-12-11 14:00:00", "2017-12-11 14:10:00", true, 2);
// $trace2 = new Trace(2, "2017-12-11 16:00:00", null, false, 3);

// $utilisateur1->ajouteIdACeuxQueJautorise(2);
// $utilisateur1->ajouteIdACeuxQuiMautorisent(3);
// $utilisateur1->ajouteIdTrace(1);
// $utilisateur1->ajouteIdTrace(2);

echo "<h4>objet utilisateur1 : </h4>";
echo ('id : ' . $utilisateur1->getId() . '<br>');
echo ('pseudo : ' . $utilisateur1->getPseudo() . '<br>');
echo ('mdpSha1 : ' . $utilisateur1->getMdpSha1() . '<br>');
echo ('adrMail : ' . $utilisateur1->getAdrMail() . '<br>');
echo ('numTel : ' . $utilisateur1->getNumTel() . '<br>');
echo ('niveau : ' . $utilisateur1->getNiveau() . '<br>');
echo ('dateCreation : ' . $utilisateur1->getDateCreation() . '<br>');
echo ("nbtraces : " . $utilisateur1->getNbTraces() . '<br>');
echo ('dateDerniereTrace : ' . $utilisateur1->getDateDerniereTrace() . '<br>');
// echo ("nombre d'utilisateurs que j'autorise : " . $utilisateur1->getNbCeuxQueJautorise() . '<br>');
// echo ("nombre d'utilisateurs qui m'autorisent : " . $utilisateur1->getNbCeuxQuiMautorisent() . '<br>');

echo ('<br>');

// test de la méthode toString
echo "<h4>méthode toString sur objet utilisateur1 : </h4>";
echo ($utilisateur1->toString());
echo ('<br>');

// tests des mutateurs (set)
$utilisateur1->setId(4);
$utilisateur1->setPseudo("Sophie Fonfec");
$utilisateur1->setMdpSha1(sha1("mdpadmin"));
$utilisateur1->setAdrMail("sophie.fonfec@gmail.com");
$utilisateur1->setNumTel("4455667788");
$utilisateur1->setNiveau(2);
$utilisateur1->setDateCreation(date('Y-m-d H:i:s', time() - 7200));
$utilisateur1->setNbTraces(2);
$utilisateur1->setDateDerniereTrace(date('Y-m-d H:i:s', time() - 3600));

echo "<h4>objet utilisateur1 : </h4>";
echo ('id : ' . $utilisateur1->getId() . '<br>');
echo ('pseudo : ' . $utilisateur1->getPseudo() . '<br>');
echo ('mdpSha1 : ' . $utilisateur1->getMdpSha1() . '<br>');
echo ('adrMail : ' . $utilisateur1->getAdrMail() . '<br>');
echo ('numTel : ' . $utilisateur1->getNumTel() . '<br>');
echo ('niveau : ' . $utilisateur1->getNiveau() . '<br>');
echo ('dateCreation : ' . $utilisateur1->getDateCreation() . '<br>');
echo ("nbtraces : " . $utilisateur1->getNbTraces() . '<br>');
echo ('dateDerniereTrace : ' . $utilisateur1->getDateDerniereTrace() . '<br>');
// echo ("nombre d'utilisateurs que j'autorise : " . $utilisateur1->getNbCeuxQueJautorise() . '<br>');
// echo ("nombre d'utilisateurs qui m'autorisent : " . $utilisateur1->getNbCeuxQuiMautorisent() . '<br>');
echo ('<br>');

// // tests de la méthode getIdUtilisateurAutorise
// $idUtilisateurConsulte = $utilisateur1->getIdUtilisateurAutorise(0);
// echo "<h4>test de getIdUtilisateurAutorise(0) : </h4>";
// echo ($idUtilisateurConsulte);
// echo ('<br>');

// // tests de la méthode getIdUtilisateurAutorisant
// $idUtilisateurConsulte = $utilisateur1->getIdUtilisateurAutorisant(0);
// echo "<h4>test de getIdUtilisateurAutorisant(0) : </h4>";
// echo ($idUtilisateurConsulte);
// echo ('<br>');

// echo "<h4>vidage des collections : </h4>";
// // tests de la méthode viderCeuxQueJautorise
// $utilisateur1->viderCeuxQueJautorise();
// echo ("nombre d'utilisateurs que j'autorise après vidage : " . $utilisateur1->getNbCeuxQueJautorise() . '<br>');
// echo ('<br>');

// // tests de la méthode viderCeuxQuiMautorisent
// $utilisateur1->viderCeuxQuiMautorisent();
// echo ("nombre d'utilisateurs qui m'autorisent après vidage : " . $utilisateur1->getNbCeuxQuiMautorisent() . '<br>');
// echo ('<br>');

// // tests de la méthode viderTraces
// $utilisateur1->viderTraces();
// echo ("nombre de traces après vidage : " . $utilisateur1->getNbTraces() . '<br>');
// echo ('<br>');
?>

</body>
</html>