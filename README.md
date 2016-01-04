# eedomus_getOuvertures
Obtenir l'état des ouvertures sous forme XML pour la box domotique eedomus

Le script php suivant donne l'état des différentes ouvertures de la maison, et construit un message qui pourra être lu vocalement 
à votre guise.

1/ Il vous faut au préalable mettre vos codes API, et modifier le tableau des ouvertures pour chacun des cas de votre habitat

2/ Le script est au format PHP pour serveur classique (testé sur synology), il doit bien y avoir un bon samaritain 
qui doit pouvoir le mettre à jour pour qu'il fonctionne au sein des scripts eedomus directement. A mon avis, il y a peu de changement.

3/ Cela génère un xml, il vous faut donc créer un capteur http, avec l'appel au script http://IP/getOuvertures.php, 
et le XPATH /OUVERTURES/MESSAGE pour avoir le message donc

4/ Mettez une mise à jour à 0 mn pour ce capteur http

5/ Créez une règle qui, à chaque fois qu'une de vos ouvertures devient ouverte ou fermée, met à jour le capteur http. 
Ainsi, à chaque changement d'état, le message indique ce qui est ouvert, précisément.

6/ Pour ceux qui ont un test à faire lors d'un armement alarme ou autre, il suffit de tester si au moins une des ouvertures est ouverte, 
et si oui, vous pouvez faire lire le message du capteur http.

7/ Si vous utilisez le bloc-notes, pensez à enregistrer le fichier php en encodage UTF-8

Si les accents sont mal encodés (Serveur Raspberry PI), remplacer la première ligne par :
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";


La version EtatOuvertures.php est un script identique intégrable directement au coeur de l'eedomus (version initiale modifée par Madoma73). 

Dans le champ URL, cette version du script peut être appeler de deux manières différentes
soit: 
- http://localhost/script/?exec=EtatOuverture.php&periphIds=1,2,3
- http://localhost/script/?exec=EtatOuverture.php&periphIds=1,2,3&resultPeriphId=4

la deuxième manière nécessitant de créer un nouveau périphérique de type état (usage détecteur d'ouverture) qui permet de faire des règles plus faciles à mon goût, ce périphérique est "ouvert" si au moins des portes déclarées l'est et fermé sinon.
