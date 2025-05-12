# 💕 Dating Simulator Interactive 💕

Un simulateur de rencontres interactif où vos choix influencent le déroulement de l'histoire. Vivez des aventures romantiques uniques à travers différents scénarios !

---

## 📋 Prérequis

Pour faire fonctionner ce projet, vous aurez besoin de :

- **PHP** 8.2 ou supérieur
- **Composer**
- **Node.js** 18 ou supérieur
- **SQLite**
- **Un navigateur web moderne**

---

## 🚀 Installation

1. **Clonez le repository** :
   ```bash
   git clone <votre-repo>
   cd ProjectInteractive
   ```

2. **Installez les dépendances backend** :
   ```bash
   composer install
   ```

3. **Installez les dépendances frontend** :
   ```bash
   npm install
   ```

4. **Configurez l'environnement** :
   ```bash
   cp .env.example .env
   php artisan key:generate
   touch database/database.sqlite
   ```

5. **Exécutez les migrations et seeders** :
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Construisez les assets frontend** :
   ```bash
   npm run build
   ```

---

## 🎮 Lancement en mode développement

1. **Démarrez le serveur backend** :
   ```bash
   php artisan serve
   ```

2. **Démarrez le serveur frontend** :
   ```bash
   npm run dev
   ```

3. **Accédez à l'application** :
   - **Frontend** : [http://localhost:5173](http://localhost:5173)
   - **Backend API** : [http://localhost:8000](http://localhost:8000)

---

## 📱 Fonctionnalités

- 📖 **Multiples histoires** avec différents scénarios.
- 🤔 **Système de choix** influençant le déroulement de l'histoire.
- 🔄 **Possibilité de revenir en arrière** dans une histoire.
- 🎨 **Interface utilisateur moderne et responsive**.

---

## 🛠️ Architecture

- **Frontend** : Vue.js 3 avec Composition API.
- **Backend** : Laravel 12.
- **Base de données** : SQLite.
- **Styling** : Tailwind CSS.
- **State Management** : Vue Composition API + Composables.
- **API** : REST API avec Sanctum pour l'authentification.

---

## 📚 Structure des Stories

Les histoires sont organisées de la manière suivante :

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

---

## 🔄 API Endpoints

### **Stories**
- `GET /api/v1/stories` : Liste des histoires disponibles.
- `GET /api/v1/stories/{id}` : Détails d'une histoire.
- `GET /api/v1/stories/{id}/first-chapter` : Premier chapitre d'une histoire.

### **Chapters**
- `GET /api/v1/chapters/{id}` : Détails d'un chapitre.
- `GET /api/v1/chapters/{id}/choices` : Choix disponibles pour un chapitre.

### **Progress**
- `GET /api/v1/progress` : Progression actuelle de l'utilisateur.
- `PATCH /api/v1/progress/update` : Mise à jour de la progression.
- `PATCH /api/v1/progress/reset` : Réinitialisation de la progression.

---

## 🔧 Configuration

Le fichier `.env` doit contenir les informations suivantes :

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

---

## 📝 Contribution

1. **Forkez le projet**.
2. **Créez une branche** pour votre fonctionnalité (`git checkout -b feature/NouvelleFonctionnalite`).
3. **Committez vos changements** (`git commit -m 'Ajout d'une nouvelle fonctionnalité'`).
4. **Poussez vers la branche** (`git push origin feature/NouvelleFonctionnalite`).
5. **Ouvrez une Pull Request**.

---

## 🛡️ Sécurité

- L'authentification est gérée via Laravel Sanctum.
- Les routes sensibles sont protégées par des middlewares (`auth:sanctum`).

---

## 📖 Licence

Ce projet est sous licence [MIT](LICENSE).

---

## 📧 Support

Pour toute question ou problème, contactez-nous à [support@example.com](mailto:support@example.com).