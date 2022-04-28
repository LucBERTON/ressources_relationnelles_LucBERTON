# (Re)ssources Relationnelles
Repository Project - RIL 2021 / 2022

## Versions :



## Installer API Platform

Une fois la feature récupérée lancer un

```composer install```

Puis un

```npm install```

Cette commande va installer webpack (API Platform utilise webpack pour son interface graphique)

Ensuite lancer 

```npm run build```

Cette commande va compiler les fichiers du dossier assets et les mettre dans le dossier public pour être exploiter par twig



## Authentification via Api Platform avec JWT

1) Lorsque vous récupérer cette version vous devez impérativement faire un ``composer install`` qui va installer lexik.

2) Ensuite se rendre sur le site [Jwt web tokens](https://jwt.io/) et chosir le mode d'encodage RS256
3) Créer un dossier jwt dans le dossier config
4) créer 2 fichiers private.pem et public.pem et coller les clés générer dans les bons fichiers
5) Dans le .env s'assurer que les clés suivantes soient bien configurées

![image](https://user-images.githubusercontent.com/49317780/164980173-7621be6f-979f-45a4-9c79-1714ea59ed97.png)



Normalement c'est tout ce qu'il y a faire du côté de l'appli web
