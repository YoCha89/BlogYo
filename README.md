Nom du projet : BlogYo

Objet : Cette application gère un système de consultation de blogpost et inclus en fonctionnalité :
    • la création/modification/suppression des blogposts
    • la création/modification/suppression de comptes utilisateur
    • la création/modification/suppression de comptes administrateur
    • la création/modification/suppression de commentaires
    • Un système de récupération de mots de passe différencié pour administrateur et utilisateur
    • Un système de prise de contact avec l’administrateur du site

pre requis :
    • PHP : 7.4.1
    • Apache : 2.2.31 
    • SQL : 5.7.24 
    • Développé sous MAMP 

Pour installer l’application :
    1. téléchargez le code et placez les dossiers contenant votre projet
    2. Via votre ligne de commande, installez les dépendances avec l’instruction : composer install
    3. créer une base de donnée appelée : blogyo
    4. Exécutez le fichier sql 
    5. Au sein du code, quelque modification rendront entièrement viable l’application. Vous devez paramétrer les boites mails utilisées au sein des méthodes gérants les envois d’email (une en frontend, une autre en backend). Cette fonctionnalité a été prévu pour une adresse mail google. A partir de la racine du projet :
        1. Dans  App>Frontend>Modules>Account>AccountController, au sein de la méthode privée sendMail(), entrez 
            1. l’adresse email que vous utilisez pour envoyer les mails à partir de l’application ligne : 368 et 373 ($mailAdmin->Username et $mailAdmin->setFrom)
            2. le mot de passe de cette boite mail ligne : 369 ($mailAdmin->Password)
            3. l’adresse email que vous utilisez pour recevoir les mails et répondre en tant qu’ administrateur, ligne : 274 ($AdminMail) et 403 ($masterAdmin)
        2. Répétez l’opération pour la méthode du même nom coté backend :  App>Backend>Modules>Admin>AdminController
            1. l’adresse email que vous utilisez pour envoyer les mails à partir de l’application ligne : 285 et 290  ($mailAdmin→Username et $mailAdmin->setFrom)
            2. le mot de passe de cette boite mail ligne : 286 ($mailAdmin->Password)
            3. l’adresse email que vous utilisez pour recevoir les mails et répondre en tant qu’ administrateur, ligne : 153 ($masterAdmin)
    6. Vous pouvez créer un compte d’utilisateur via l’interface de l’application.
    7. Vous avez en revanche besoin d’un compte administrateur d’entré. Vous pouvez utiliser les identifiants du compte par défaut :
        ◦ Pseudo : masterAdmin
        ◦ Pass : Master&2021