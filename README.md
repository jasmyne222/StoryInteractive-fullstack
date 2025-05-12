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

---

## 📱 Fonctionnalités

- 📖 **Multiples histoires** avec différents scénarios.
- 🤔 **Système de choix** influençant le déroulement de l'histoire.
- 🔄 **Possibilité de revenir en arrière** dans une histoire.
- 🎨 **Interface utilisateur moderne et responsive**.

---

## 🔄 API Endpoints

### **Stories**
- `GET /api/v1/stories` : Liste des histoires disponibles.
- `GET /api/v1/stories/{id}` : Détails d'une histoire.
- `GET /api/v1/stories/{id}/first-chapter` : Premier chapitre d'une histoire.

### **Chapters**
- `GET /api/v1/chapters/{id}` : Détails d'un chapitre.
- `GET /api/v1/chapters/{id}/choices` : Choix disponibles pour un chapitre.

---
