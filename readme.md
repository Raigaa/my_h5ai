# My H5AI - File Explorer

## Description
**My H5AI** est une application web légère permettant d'explorer, de visualiser et de gérer des fichiers et dossiers sur un serveur ou un système local. Inspirée par H5AI, cette application offre une interface simple et intuitive pour naviguer dans les répertoires.

## Fonctionnalités
- **Exploration des fichiers et dossiers** :
  - Navigation dans les répertoires avec une vue en tableau.
  - Retour au dossier parent facilement.
- **Affichage des fichiers** :
  - Support des images, vidéos, fichiers audio et texte.
  - Affichage des fichiers texte avec possibilité d'édition.
- **Recherche** :
  - Filtrage des fichiers et dossiers via une barre de recherche.
- **Icônes personnalisées** :
  - Icônes spécifiques pour différents types de fichiers et dossiers.

## Structure du projet
- **Back-end** :
  - PHP pour scanner les répertoires et gérer les actions utilisateur.
  - Classe principale `H5AI` pour la logique de l'application.
- **Front-end** :
  - JavaScript pour les interactions dynamiques (modale, recherche).
  - CSS pour un design responsive et minimaliste.

### Arborescence des fichiers
```plaintext
my_h5ai/
├── index.php          # Point d'entrée principal
├── H5AI.php           # Classe principale
├── save.php           # Gestion de la sauvegarde des fichiers texte
├── public/
│   ├── js/
│   │   └── script.js  # Scripts JavaScript
│   ├── style/
│   │   └── style.css  # Feuilles de style CSS
│   └── icons/         # Icônes pour les fichiers et dossiers
└── readme.md          # Documentation du projet
```

## Installation
1. Clonez le dépôt :
   ```bash
   git clone https://github.com/votre-utilisateur/my_h5ai.git
   ```

2. Placez le projet sur un serveur web compatible PHP.

3. Accédez à l'application via votre navigateur.

## Utilisation
1. Ouvrez l'application dans votre navigateur.
2. Naviguez dans les répertoires et explorez les fichiers.
3. Modifiez les fichiers texte directement depuis l'interface.

## Contributions
Les contributions sont les bienvenues ! N'hésitez pas à ouvrir une issue ou à soumettre une pull request pour améliorer le projet.