# 💕 Dating Simulator Interactive 💕

Un simulateur de rencontres interactif où vos choix influencent le déroulement de l'histoire. Vivez des aventures romantiques uniques à travers différents scénarios !

## 📋 Prérequis

Pour faire fonctionner ce projet, vous aurez besoin de :

- PHP 8.2 ou supérieur
- Composer
- Node.js 18 ou supérieur
- SQLite
- Un navigateur web moderne

## 🚀 Installation

1. Clonez le repository :
```bash
git clone <votre-repo>
cd ProjectInteractive
```

2. Installez les dépendances :
```bash
composer install
npm install
```

3. Configurez l'environnement :
```bash
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
```

4. Exécutez les migrations et les seeders :
```bash
php artisan migrate:fresh --seed
```

5. Construisez les assets :
```bash
npm run build
```

## 🎮 Lancement en mode développement

Dans un premier terminal :
```bash
php artisan serve
```

Dans un second terminal :
```bash
npm run dev
```

L'application sera accessible à :
- Frontend : http://localhost:5173
- Backend API : http://localhost:8000

## 📱 Fonctionnalités

- 📖 Multiples histoires avec différents scénarios
- 🤔 Système de choix influençant le déroulement de l'histoire
- 💾 Sauvegarde automatique de la progression
- 🔄 Possibilité de recommencer une histoire
- 🎨 Interface utilisateur moderne et responsive

## 🛠️ Architecture

- **Frontend** : Vue.js 3 avec Composition API
- **Backend** : Laravel 12
- **Base de données** : SQLite
- **Styling** : Tailwind CSS
- **State Management** : Vue Composition API + Composables
- **API** : REST API avec sanctum pour l'authentification

## 📚 Structure des Stories

Notre système d'histoire est organisé de la manière suivante :

```json
{
  "story": {
    "id": 1,
    "title": "Une rencontre inattendue",
    "description": "Votre aventure commence dans un café...",
    "chapters": [
      {
        "id": 1,
        "content": "Le texte du chapitre...",
        "choices": [
          {
            "id": 1,
            "text": "Aller lui parler",
            "next_chapter": 2
          },
          {
            "id": 2,
            "text": "Rester à sa place",
            "next_chapter": 3
          }
        ]
      }
    ]
  }
}
```

## 🔄 API Endpoints

### Stories
```http
GET /api/stories         # Liste des histoires disponibles
GET /api/stories/{id}    # Détails d'une histoire
```

### Chapters
```http
GET /api/chapters/{id}           # Détails d'un chapitre
GET /api/chapters/{id}/choices   # Choix disponibles
```

### Progress
```http
GET /api/progress              # Progression du joueur
POST /api/progress/update      # Mise à jour de la progression
POST /api/progress/reset       # Réinitialisation
```

## 🔧 Configuration

Le fichier `.env` doit contenir :

```env
APP_NAME="Dating Simulator"
APP_ENV=local
APP_KEY=your-key-here
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

## 👥 Contribution

1. Fork le projet
2. Créez votre branche (`git checkout -b feature/NouvelleFonctionnalite`)
3. Committez vos changements (`git commit -m 'Ajout d'une nouvelle fonctionnalité'`)
4. Push vers la branche (`git push origin feature/NouvelleFonctionnalite`)
5. Ouvrez une Pull Request

## 📝 License

[MIT](LICENSE)