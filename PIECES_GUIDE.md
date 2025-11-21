# Gestion des Pièces et Catégories - Guide d'utilisation

## Installation et Configuration

### 1. Exécuter les migrations

Pour créer les tables nécessaires dans la base de données :

```bash
php artisan migrate
```

Cela créera deux nouvelles tables :
- `piece_categories` - Pour les catégories de pièces (hiérarchiques)
- `pieces` - Pour les pièces/produits

### 2. Peupler les catégories de démonstration (optionnel)

Pour créer des catégories de test comme Mécanique, Freinage, Disque, etc. :

```bash
php artisan db:seed --class=PieceCategorySeeder
```

## Fonctionnalités

### Gestion des Catégories de Pièces

**Accès:** Menu Admin → Référentiel → Catégories de Pièces

#### Caractéristiques :
- **Hiérarchie à plusieurs niveaux** : Créez des catégories parentes (ex: Mécanique) et des sous-catégories (ex: Freinage → Disque)
- **Slug automatique** : Le slug URL est généré automatiquement à partir du nom
- **Images** : Ajoutez des images pour chaque catégorie
- **Ordre personnalisable** : Contrôlez l'ordre d'affichage
- **Statut actif/inactif** : Activez ou désactivez des catégories

#### Exemples de structure :
```
Mécanique
├── Freinage
│   ├── Disque
│   └── Plaquettes
└── Batterie

Électrique
└── Éclairage

Carrosserie
```

### Gestion des Pièces

**Accès:** Menu Admin → Référentiel → Pièces

#### Caractéristiques :
- **Informations complètes** : Nom, référence, description, prix, stock
- **Liaison avec catégories** : Associez chaque pièce à une catégorie
- **Liaison avec marques** : Associez chaque pièce à une marque existante
- **Images de produits** : Ajoutez une image pour chaque pièce
- **Filtres** : Filtrez les pièces par catégorie ou marque
- **Gestion du stock** : Suivez les quantités en stock
- **Statut actif/inactif** : Contrôlez la visibilité des pièces

### Intégration Frontend

Les pièces peuvent être affichées sur le frontend avec filtrage par catégorie :

#### URLs disponibles :
- `/pieces` - Toutes les pièces actives
- `/pieces/mecanique` - Pièces de la catégorie Mécanique
- `/pieces/freinage` - Pièces de la catégorie Freinage
- `/pieces/disque` - Pièces de la catégorie Disque

## Routes API

### Routes Admin (nécessite authentification)

**Catégories de Pièces :**
- `GET /piece-categories` - Liste des catégories
- `GET /piece-categories/create` - Formulaire de création
- `POST /piece-categories` - Créer une catégorie
- `GET /piece-categories/{id}` - Détails d'une catégorie
- `GET /piece-categories/{id}/edit` - Formulaire d'édition
- `PUT /piece-categories/{id}` - Mettre à jour une catégorie
- `DELETE /piece-categories/{id}` - Supprimer une catégorie
- `POST /piece-categories/{id}/toggle-status` - Activer/désactiver

**Pièces :**
- `GET /pieces` - Liste des pièces (avec filtres)
- `GET /pieces/create` - Formulaire de création
- `POST /pieces` - Créer une pièce
- `GET /pieces/{id}` - Détails d'une pièce
- `GET /pieces/{id}/edit` - Formulaire d'édition
- `PUT /pieces/{id}` - Mettre à jour une pièce
- `DELETE /pieces/{id}` - Supprimer une pièce
- `POST /pieces/{id}/toggle-status` - Activer/désactiver

### Routes Frontend (public)
- `GET /pieces` - Afficher toutes les pièces
- `GET /pieces/{categorySlug}` - Afficher les pièces d'une catégorie spécifique

## Intégration avec le Menu de Navigation

Les catégories peuvent être liées au menu de navigation existant pour créer une structure de navigation dynamique sur le frontend.

**Exemple :**
1. Créez un menu "Pièces Auto" dans "Menu de Navigation"
2. Ajoutez des sous-menus avec les URLs `/pieces/mecanique`, `/pieces/freinage`, etc.
3. Ces liens filtreront automatiquement les pièces par catégorie

## Structure de la Base de Données

### Table `piece_categories`
- `id` - Identifiant unique
- `name` - Nom de la catégorie
- `slug` - Slug URL (généré automatiquement)
- `description` - Description de la catégorie
- `image` - Chemin de l'image
- `parent_id` - ID de la catégorie parente (NULL pour les catégories principales)
- `order` - Ordre d'affichage
- `is_active` - Statut actif/inactif
- `created_at`, `updated_at`, `deleted_at`

### Table `pieces`
- `id` - Identifiant unique
- `name` - Nom de la pièce
- `reference` - Référence unique
- `description` - Description
- `price` - Prix (décimal)
- `image` - Chemin de l'image
- `category_id` - ID de la catégorie (foreign key)
- `brand_id` - ID de la marque (foreign key)
- `stock` - Quantité en stock
- `is_active` - Statut actif/inactif
- `created_at`, `updated_at`, `deleted_at`

## Conseils d'utilisation

1. **Créez d'abord les catégories parentes** avant de créer les sous-catégories
2. **Utilisez des slugs descriptifs** pour un meilleur référencement SEO
3. **Ajoutez des images** pour améliorer la présentation visuelle
4. **Gérez le stock** régulièrement pour éviter les ruptures
5. **Utilisez les filtres** pour trouver rapidement les pièces dans l'administration

## Support

Pour toute question ou problème, veuillez créer un ticket sur le dépôt GitHub.
