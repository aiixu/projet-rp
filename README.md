# ProjetRp

## Contenu

- Vue globale de la structure du projet
- Explication de chaque fichier nécessaire au bon fonctionnement de l'application
- Des informations sur comment utiliser Angular

## Structure du projet

- [/e2e](#/e2e)
- [/node_modules](#/node_modules)
- [/src](#/src) 
    - [/app](#/src/app)
        - [app-routing.module.ts](#/src/app/app-routing.module.ts)
        - [app.component.html](#/src/app/app.component.html)
        - [app.component.css](#/src/app/app.component.css)
        - [app.component.spec.ts](#/src/app/app.component.spec.ts)
        - [app.component.ts](#/src/app/app.component.ts)
        - [app.module.ts](#/src/app/app.module.ts)
    - [/assets](#/src/assets)
    - [/environments](#/src/environments)
    - [/favicon.ico](#/src/favicon.ico)
    - [/index.html](#/src/index.html)
    - [/main.ts](#/src/main.ts)
    - [/polyfill.ts](#/src/polyfill.ts)
    - [/styles.css](#/src/styles.css)
    - [/test.ts](#/src/test.ts)
- [/.browserslistrc](#/.browserslistrc)
- [/.editorconfig](#/.editorconfig)
- [/.gitignore](#/.gitignore)
- [/angular.json](#/angular.json)
- [/karma.conf.js](#/karma.conf.js)
- [/package-lock.json](#/package-lock.json)
- [/package.json](#/package.json)
- [/README.md](#/README.md)
- [/tsconfig.app.json](#/tsconfig.app.json)
- [/tsconfig.json](#/tsconfig.json)
- [/tsconfig.spec.json](#/tsconfig.spec.json)
- [/tslint.json](#/tslint.json)

## Explication

- #### /e2e

    > Généré par `Angular CLI`, c'est un dossier qui contient les test End-To-End. Ils sont utiles lorsque l'on veut tester des fonctionnalités très complètes dans lesquelles le développeur à besoin d'une grande partie de l'application.

- #### /node_modules

    > Généré par `NPM`, c'est un dossier contenant toutes les dépendances externes nécessaires au bon fonctionnement du projet.

- #### /src

    > Généré par `Angular CLI`, contient tous les fichiers nécessaires au bon fonctionement de l'application, dont les sources, les environements de développement (cf: /src/environments) et les assets (des images par exemples).

    - #### /src/app

        > Contient les fichiers de comopnents dans lesquels la logique et les données de l'application sont définies

        - #### /src/app/app-routing.module.ts

            > Fichier servant à gérer les routes de l'application

        - #### /src/app/app.component.html

            > Définit le modèle HTML associé au AppComponent

        - #### /src/app/app.component.css

            > Définit la feuille de style CSS de base pour l'AppComponent

        - #### /src/app/app.component.spec.ts

            > Définit un test unitaire pour l'AppComponent

        - #### /src/app/app.component.ts

            > Définit la logique du composant racine de l'application, nommé AppComponent. La vue associée à ce composant racine devient la racine de la hiérarchie des vues lorsque qu'on ajoute des components à l'application

        - ### /src/app/app/module.ts

            > Définit le module racine, nommé AppModule, qui indique à Angular comment assembler l'application. Initialement, déclare uniquement AppComponent. Lorsque qu'on ajoute des components à l'application, ils doivent être déclarés ici

    - #### /src/assets

        > Contient des images ou autre fichier de ressource pour l'application

    - #### /src/environments

        > Contient des options de configuration de construction pour des environnements particuliers. Par défaut, il existe un environnement de développement standard sans nom et un environnement de production ("prod")

    - #### /src/favicon.ico

        > Ce fichier est un fichier icon: c'est celui utilisé par défaut dans le navigateur

    - #### /src/index.html

        > La page HTML principale qui est envoyée lorsqu'un internaute visite votre site. La CLI ajoute automatiquement tous les fichiers JavaScript et CSS lors de la création de votre application, donc pas besoin d'ajouter manuellement des balises \<script> ou \<link> (sauf pour Bulma par exemple)

    - #### /src/main.ts

        > Le principal point d'entrée de votre application

    - #### /src/polyfill.ts

        > Généré par la CLI, fournit des scripts polyfill pour la prise en charge du navigateur
    
    - #### /src/styles.css

        > Répertorie les fichiers CSS qui fournissent des styles pour un projet. L'extension reflète le préprocesseur de style que vous avez configuré pour le projet (CSS, SASS, SCSS...)

    - #### /src/test.ts

        > Le point d'entrée principal pour vos tests unitaires, avec une configuration spécifique à Angular    

- #### /.browserslistrc

    > La configuration pour partager les navigateurs cibles et les versions de Node.js entre différents outils front-end. Voir [github/browserslist](https://github.com/browserslist/browserslist)

- #### /.editorconfig

    > Configuration pour les éditeurs de code

- #### /.gitignore

    > Permet de dire à Git d'ignorer certains fichiers ou dossier lors des comits (notamment `node_module`)

- #### /angular.json

    > Paramètres de configuration d'`Angular CLI`, avec les options de configuration pour les outils de génération, de service et de test dont la CLI a besoin

- #### /karma.conf.js

    > Configuration Karma spécifique à l'application

- #### /package-lock.json

    > Fournit des informations de version pour tous les packages installés dans node_modules par `NPM`

- #### /package.json

    > Configurer les dépendances `NPM` pour le projet

- #### /README.md

    > Documentation pour l'application de base (on pourrait en avoir une pour chaque component ou page de cette dernière)

- #### /tsconfig.app.json

    > Configuration TypeScript spécifique à l'application. Comprend aussi les options du compilateur de modèles TypeScript et Angular

- #### /tsconfig.json

    > La configuration TypeScript de base pour les projets dans l'espace de travail

- #### /tsconfig.spec.json

    > Configuration TypeScript pour les tests d'application

- #### /tslint.json

    > Configuration [TSLint](https://palantir.github.io/tslint/) par défaut pour les projets dans l'espace de travail

## Comment utiliser Angular

0. Installation

L'`Angular CLI` est l'invité de commande Angular, pour créer des projets, les compiler, ajouter des components etc.  
Pour l'installer, il faut avoir `NPM`, puis faire `npm install -g @angular/cli`.  
Vous pouvez ensuite utiliser les commandes relatives à angular.

1. Compilation

Pour compiler le projet Angular, il faut ouvrir un terminal dans le dossier racine de l'application (./projet-rp/) et écrire `ng serve`. Ensuite, allez sur l'URL donnée par Angular dans la console dans et vous aurez accès à l'application.  
C'est comme un live server, donc vous pouvez le laisser tourner et les modifications seront appliquées en direct

2. Créer une nouvelle page

Pour créer une nouvelle page, il faut générer un nouveau component. Pour ce faire, il faut ouvrir un terminal dans le dossier racine de l'application (./projet-rp/) et écrire `ng generate component nom-du-component` (le component devrait être écrit en Kebab Case ([lien](https://www.theserverside.com/definition/Kebab-case)) minuscule, avec un nom court et descriptif, en anglais de préférence. Acceuil sera alors "home" par example)  
Il faudra ensuite ajouter ce component au routeur.  
**Attention, une page ne doit contenir que ce son contenu**: pas de header, footer ni rien, tout cela sera géré par le composant racine. Il faut s'imaginer qu'on construit une maison, le component racine AppComponent représente les fondations, chaque page un mur: pas besoin de remettre des fondations en dessous de chaque mur, une fois suffit.  

3. Ajouter une page au routeur

Allez dans `src/app/app-routing.module.ts`. Il y a un objet `Routes`. Pour y en ajouter une nouvelle, il suffit d'ajouter les bonnes données dans ce tableau :
```js
{
    path: "",  // Route pour accéder à la page, par exemple "home"
    component: // Nom de votre component, par exemple HomeComponent
}
```
Quand vous ajoutez une nouvelle route, il faut faire attention à bien laisser la route
```js
{
    path: "",
    redirectTo: "/home",
    pathMatch: "full"
}
```
en dernier.  
Il faut maintenant importer le component. Pour ce faire, il suffit d'ajouter, en haut du script la ligne
```ts
import { /* Nom du component */ } from /* Chemin du component */;
// Par exemple, avec le component Home, il faudrait écrire
import { HomeComponent } from './home/home.component';
```

4. Ajouter un lien vers une page

Pour faire un lien vers une page, il suffit d'ajouter deux propriétés à n'importe quel élément:
```html
<p class="title" routerLike="route" routerLinkActive="active">Lorem Ipsum</p>
```
Par exemple, pour rediriger vers la page "home, il faudrait écrire
```html
<p class="title" routerLike="home" routerLinkActive="active">Accueil</p>
```
L'élément va ensuite se comporter comme un lien. Cette méthode s'applique sur n'importe quel élément HTML.
