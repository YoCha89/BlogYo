Nom du projet : BlogYo <br/>

Objet : Cette application gère un système de consultation de blogpost et inclus en fonctionnalité :<br/>

<ul>
    <li> la création/modification/suppression des blogposts</li>
    <li> la création/modification/suppression de comptes utilisateur</li>
    <li> la création/modification/suppression de comptes administrateur</li>
    <li> la création/modification/suppression de commentaires</li>
    <li> Un système de récupération de mots de passe différencié pour administrateur et utilisateur</li>
    <li> Un système de prise de contact avec l’administrateur du site</li>
</ul>

pre requis :<br/>

<ul>
    <li> PHP : 7.4.1</li>
    <li> Apache : 2.2.31 </li>
    <li> SQL : 5.7.24 </li>
    <li> Développé sous MAMP </li>
</ul>

Pour installer l’application :<br/>

<ol>    
    <li>téléchargez le code et placez les dossiers contenant votre projet</li>
    <li>Via votre ligne de commande, installez les dépendances avec l’instruction : composer install</li>
    <li>créer une base de donnée appelée : blogyo</li>
    <li>Exécutez le fichier sql </li>
    <li>Au sein du code, quelque modification rendront entièrement viable l’application. Vous devez paramétrer les boites mails utilisées au sein des méthodes gérants les envois d’email (une en frontend, une autre en backend). Cette fonctionnalité a été prévu pour une adresse mail google. A partir de la racine du projet :</li>
        <ol> 
            1. Dans  App>Frontend>Modules>Account>AccountController, au sein de la méthode privée sendMail(), entrez
                <ol>
                    <li>l’adresse email que vous utilisez pour envoyer les mails à partir de l’application ligne : 368 et 373 ($mailAdmin->Username et $mailAdmin->setFrom)</li>
                    <li>le mot de passe de cette boite mail ligne : 369 ($mailAdmin->Password)</li>
                    <li>l’adresse email que vous utilisez pour recevoir les mails et répondre en tant qu’ administrateur, ligne : 274 ($AdminMail) et 403 ($masterAdmin)  </li>
                </ol>
            2. Répétez l’opération pour la méthode du même nom coté backend :  App>Backend>Modules>Admin>AdminController
                <ol>
                    <li>l’adresse email que vous utilisez pour envoyer les mails à partir de l’application ligne : 285 et 290  ($mailAdmin→Username et $mailAdmin->setFrom)</li>
                    <li>le mot de passe de cette boite mail ligne : 286 ($mailAdmin->Password)</li>
                    <li>l’adresse email que vous utilisez pour recevoir les mails et répondre en tant qu’ administrateur, ligne : 153 ($masterAdmin)</li>
                </ol>
        </ol>
    <li>Vous pouvez créer un compte d’utilisateur via l’interface de l’application.</li>
    <li>Vous avez en revanche besoin d’un compte administrateur d’entré. Vous pouvez utiliser les identifiants du compte par défaut :</li>
        ◦ Pseudo : masterAdmin
        ◦ Pass : Master&2021
</ol>
