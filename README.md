# My Cinema

Une application web de gestion de cinéma développée en PHP permettant la gestion des films, des séances, des membres et des abonnements.

## Prérequis 🛠️

- Un environnement de développement local :
  - LAMP (Linux)
  - XAMPP (Windows/Linux)
  - MAMP (MacOS)
- PHP 7.4 ou supérieur
- MySQL/MariaDB
- Serveur web Apache

## Installation 📥

1. Cloner le dépôt :
```bash
git clone https://github.com/C-Ethan/My_Cinema.git
```

2. Configuration de l'environnement :

### Pour LAMP (Linux) :
```bash
sudo apt update
sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql
```

### Pour XAMPP :
- Télécharger depuis [apachefriends.org](https://www.apachefriends.org/)
- Installer et lancer le panneau de contrôle
- Démarrer Apache et MySQL

### Pour MAMP :
- Télécharger depuis [mamp.info](https://www.mamp.info/)
- Installer et lancer l'application
- Démarrer les serveurs

3. Base de données :
```bash
mysql -u votre_utilisateur -p votre_base < database/cinema.sql
```

4. Configuration :
- Modifier le fichier `config/Database.php` avec vos paramètres de connexion

## Fonctionnalités 🎯

- 🎬 Gestion des films
- 📅 Planification des séances
- 👥 Gestion des membres
- 💳 Gestion des abonnements
- 📋 Suivi des réservations
- 🏢 Gestion des salles
- 🎭 Organisation des genres et distributeurs

## Structure du Projet 📁

```
my_cinema/
├── api/               # Points d'entrée API
├── config/           # Configuration
├── controllers/      # Contrôleurs
├── models/          # Modèles de données
├── public/          # Assets publics
│   ├── css/
│   └── js/
└── views/           # Templates
    ├── components/
    └── layouts/
```

## Utilisation 💻

1. Lancer votre environnement local
2. Accéder au projet via : `http://localhost/my_cinema`
3. Navigation :
   - Gestion des films
   - Administration des membres
   - Planification des séances
   - Suivi des abonnements

## Contribution 🤝

1. Fork le projet
2. Créer une branche (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Commit (`git commit -m 'Ajout d'une nouvelle fonctionnalité'`)
4. Push (`git push origin feature/nouvelle-fonctionnalite`)
5. Ouvrir une Pull Request

## License 📄

Ce projet est sous licence MIT

## Auteur ✍️

[C-Ethan](https://github.com/C-Ethan)

## Support 💬

Pour toute question ou suggestion :
- Ouvrir une issue sur GitHub
- Me contacter via GitHub
