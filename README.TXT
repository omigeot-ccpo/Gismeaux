ATTENTION: Ceci est en cours de travaux. Ce répertoire contient une expérimentation 
concernant la sécurisation des accès à GISMeaux. En conséquence de quoi, il est très 
peu recommandé de l'utiliser, sauf si farfouiller dans du code PHP ne vous fait pas 
peur. Et encore.

Le but initial de cette branche est de tester de nouvelles idées et d'en discuter.

ATTENTION (suite) : Ceci est toujours en travaux puisque l'application doit r�pondre 
aux attentes de ses utilisateurs!!
Il est maintenant recommand� de l'utiliser cette ensemble d'applications �tant 
actuellement en production.
Toutefois les fichiers install.php et configuration.php sont livr�s en l'�tat (ils 
nous ont aucune utilit� notre site existant depuis 2004) et donc les retours d'exp�riences 
seront les bienvenus

PRINCIPALES MODIFICATIONS

* Regroupement des branches "intranet", "internet" et "test_ssl" 
  en une seule branche, nommée "application".

* Rationalisation des inclusions. Les fichiers PHP 
  partagés se trouvent dans /inc, les fichiers appellés à être 
  modifiés à l'installation sont dans /conf.

* Modularisation des routines de base de données. /inc/database.php 
  définit désormais une classe (DBpg) et une variable globale ($DB) 
  qui embarque les anciennes fonction "tab_result" et assimil�es.

* Un même entête se trouve désormais au début de tous les 
  fichiers PHP inclus. Celui-ci s'assure que les fichiers 
  ne sont pas appellés directement.

* Un même entête se trouve désormais au début de tous les 
  autres fichiers PHP. Celui-ci positionne la constante 
  GIS_ROOT et se charge d'inclure les fichiers utiles (via common.php).

* Deux appels de fonction sont fournis pour la gestion des sessions.
       - Le premier, gis_session_start(), charge les données de la 
       session si besoin. Il doit être appellé au début de chaque 
       fichier PHP non-inclus.
       - Le second, gis_init(), s'occupe en plus de vérifier 
       l'authentification et - en résumé - d'initialiser une nouvelle 
       session si besoin. Il ne doit être appellé QUE par les "points 
       d'entrée" de l'utilisateur dans le système (carto.php, 
       index.php, back_office.php, etc.).

* L'authentification s'appuie désormais sur un système de "profils" 
  (/inc/profiles.php). Ceux-ci dérivent d'une classe "Profile" et 
  implémentent divers mécanismes.
       - Tout d'abord, ils fournissent une fonction qui permet de tester 
       si le profil s'applique ou non. Ainsi, on peut sélectionner un 
       profil différent selon que l'utilisateur se connecte depuis une 
       IP locale ou non, depuis une connexion sécurisée ou non, etc.
       - Ensuite, ils fournissent une routine d'identification. Par 
       exemple, le "CertifiedProfile" (qui gère les authentifications 
       par certificat SSL) extrait le nom d'utilisateur du certificat. 
       Le profil par défaut (InternetProfile) positionne automatiquement 
       le nom d'utilisateur à "Visiteur". Dans les cas qui s'y prête, 
       cette étape récupère aussi le mot de passe.
       - Enfin, ils vérifient par le moyen adéquat que l'utilisateur 
       est bien ce qu'il prétend. Dans le cas d'un certificat client, 
       le simple fait d'avoir un certificat valide est une garantie suffisante. 
       Dans le cas d'une authentification sur LDAP, le protil tentera juste 
       de se connecter au serveur LDAP avec le login et le mot de passe fournis 
       lors de l'identification. Dans le cas du "InternetProfile", 
       l'authentification est automatiquement réussie.

* L'utilisation de mapserv.php - interface à PHP/Mapscript simulant 
  (partiellement) le comportement du CGI de Mapserver - en lieu 
  et place du-dit CGI. L'idée étant notamment de pouvoir intégrer 
  un cache pour les rasters.

* Création d'un /index.php visant à fournir - à terme - un point 
  d'entrée convivial vers les différentes fonctionnalités. Un tel 
  point d'entrée devrait, notamment, modifier son contenu en 
  fonction du profil utilisé. Pour le moment, il est majoritairement
  utilisé à des fins de débuguage.

* Transfert des "applications" (le cadastre uniquement, pour le moment)
  dans /apps. L'idée serait, à terme, de mettre en place une inter-
  face commune aux différentes applications pour permettre l'ajout
  et la suppression "simple" de tels composants. Typiquement, une
  application devrait être capable de renseigner d'elle-même
  les tables utiles (permissions, etc.).

* Transfert des notions de commune par défaut et d'application 
  par défaut aux profils. Ceux-ci peuvent éventuellement déléguer
  cette sélection à un composant tiers (DB, LDAP, etc.)

* Définit les permissions par rapport à un rôle (chaque utilisateur pouvant 
  avoir plusieurs rôles) plutôt que par rapport à l'utilisateur
  lui-même. Ceci permettant de simplifier l'administration, 
  l'ajout d'un nouvel utilisateur se résumant le plus souvent 
  à le rattacher à un rôle existant.

NOTES DIVERSES

* L'utilisation "simple" de la branche nécessite de faire pointer
  un hôte virtuel Apache vers /gismeaux/application.

* L'utilisation de l'authentification SSL nécessite l'ajout de
  directives dans Apache (SSLRequire optional) pour l'hôte
  virtuel SSL.

* L'authentification SSL nécessite également de configurer une
  PKI minimaliste : une CA, un certificat serveur signé par 
  la-dite CA et un nombre quelconque de certificats clients 
  également signés par la CA. L'utilisation d'un outil comme
  XCA (http://xca.hohnstaedt.de/) peut être d'une grande aide
  par rapport à la manipulation manuelle des commandes OpenSSL.

* La configuration de la base de données reste - pour 
  l'essentiel - identique à celle de la branche "normale" de
  l'application. Quelques tables supplémentaires sont à créer
  dans admin_svg. (DATABASE.TXT)

TRUCS ENCORE A FAIRE (SELON LE TEMPS)

* Passer à un "vrai" SRID (au lieu de -1), pour pouvoir être interopérable.

* Construire un outil "intégré" de configuration initiale de la DB.