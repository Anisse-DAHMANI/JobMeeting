# Project JobMeeting

Bonjour, à tout le monde.

Pour le moment, je ne sais que faire pour le window.

# Installation de la domaine en local :
* Pour commencer, on installe WAMP en utilisant cela : https://sourceforge.net/projects/wampserver/files/
NB : Après la fin d'installation, vérifiez si vous avez le dossier "wamp64" dans votre disque dur (par exemple, moi : C:/wamp64)

# Préparation de GIT : (https://git-scm.com/download/win si l'on n'a pas encore installé Git sur Windows)
* Copiez l'adresse du lien de git.
* Ouvrez le Git Bash, écrivez `cd /c/wamp64/www/` pour `C:/wamp64/www/`. (C: donc c, D: donc d , etc).
* Mettre notre git en place : `git clone https://gitlab.univ-nantes.fr/E190779T/project-jobmeeting.git` et puis votre connexion etc..

# Faciliter le travail :
* (Personnel) Prenez l'éditeur qui peut aussi gérer le git. (Par exemple, Atom).
* Ajouter le dossier du projet sur project-jobmeeting (qui se trouve dans www de wamp64).
* Stage, Unstage, Commit, Push, Fetch, etc.

# Visualiser la site :
* Lancer wamp64 et attenez que l'icone (au bas et droite sur la barre) devient vert.
* Après cela, tapez simplement sur google "localhost/projet-jobmeeting".
NB : C'est normal si vous voyez la site avec quelques minis erreurs (Cela vient des erreurs de connexion avec (PDOConnection)).

# Accès au base de données (LOCAL) :
* D'abord, récuperez le fichier "jobmeeting.sql" envoyé dans Messenger.
* Cliquez l'icone vert de wamp64 (dans la barre) et cliquez "phpmyadmin".
* Tapez "root" pour le nom d'utilisateur/email. (Pas de mot de passe)
* Créer la base de données nommée "jobmeeting". Puis cliquez sur cela et cliquez "Importer". Choisis "jobmeeting.sql" comme le fichier d'importation. Puis executez.
NB : Attention, si vous changez quelque chose à la base de données, cela ne affecte pas notre base de données (parce que c'est en local mais peu importe. Le plus important c'est pouvoir travailler et tester).

# Autres choses ..
* Pour y pouvoir tester sur les autres pages à part d'index.php, on doit passer le compte inscrit :
#### Email : `grdf@gmail.fr`
#### Mot de passe : `Grdf2020!` 

Bien sûr, quand on modifie quelque chose dans notre code, on peut visualiser de cette façon, quand c'est bon et ça marche sûrement, on le commit et push et bata ! Comme cela, nous pouvons recuperer cela avec fetch et c'est mis à jour dans votre domaine local ;)

J'espere vous aider mais bon

### BON COURAGE ET BON MERDE (même si nous sentons que nous sommes dans la sauce ahah)
