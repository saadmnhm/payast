<?php

use App\Models\User;
use App\Models\BlogPost;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

// Tableau de bord (point de départ)
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Tableau de bord', route('dashboard'));
});

// User Management Breadcrumbs
Breadcrumbs::for('apps.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Utilisateurs', route('apps.users.index'));
});

// Tableau de bord > Utilisateurs > [Utilisateur]
Breadcrumbs::for('apps.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('apps.users.index');
    $trail->push(ucwords($user->name), route('apps.users.show', $user));
});

// Tableau de bord > Utilisateurs > Corbeille
Breadcrumbs::for('apps.users.trashed', function ($trail) {
    $trail->parent('apps.users.index');
    $trail->push('Utilisateurs supprimés', route('apps.users.trashed'));
});

// Tableau de bord > Rôles (directement)
Breadcrumbs::for('apps.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Rôles', route('apps.roles.index'));
});

// Tableau de bord > Permissions (directement)
Breadcrumbs::for('apps.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Permissions', route('apps.permissions.index'));
});

// Blog Categories Breadcrumbs
Breadcrumbs::for('apps.blog.categories.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Référentiel des catégories', route('apps.blog.categories.index'));
});

// Tableau de bord > Blog > Catégories > Créer
Breadcrumbs::for('apps.blog.categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('apps.blog.categories.index');
    $trail->push('Créer', route('apps.blog.categories.create'));
});

// Tableau de bord > Blog > Catégories > Modifier
Breadcrumbs::for('apps.blog.categories.edit', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('apps.blog.categories.index');
    $trail->push('Modifier', route('apps.blog.categories.edit', $category));
});

// Tableau de bord > Blog > Catégories > [Catégorie]
Breadcrumbs::for('apps.blog.categories.show', function (BreadcrumbTrail $trail, $categorie) {
    $trail->parent('apps.blog.categories.index');
    $trail->push('Consulter', route('apps.blog.categories.show', $categorie));
});

// Tableau de bord > Blog > Catégories > Corbeille
Breadcrumbs::for('apps.blog.categories.trashed', function (BreadcrumbTrail $trail) {
    $trail->parent('apps.blog.categories.index');
    $trail->push('Corbeille', route('apps.blog.categories.trashed'));
});

// Blog Articles Breadcrumbs
Breadcrumbs::for('apps.blog.articles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Articles', route('apps.blog.articles.index'));
});

// Tableau de bord > Blog > Articles > Nouveau
Breadcrumbs::for('apps.blog.articles.create', function (BreadcrumbTrail $trail) {
    $trail->parent('apps.blog.articles.index');
    $trail->push('Nouvel article', route('apps.blog.articles.create'));
});

// Tableau de bord > Blog > Articles > Modifier
Breadcrumbs::for('apps.blog.articles.edit', function (BreadcrumbTrail $trail, BlogPost $article) {
    $trail->parent('apps.blog.articles.index');
    $trail->push('Modifier: ' . Str::limit($article->title, 40), route('apps.blog.articles.edit', $article));
});

// Tableau de bord > Blog > Articles > [Article]
Breadcrumbs::for('apps.blog.articles.show', function (BreadcrumbTrail $trail, $article) {
    $trail->parent('apps.blog.articles.index');
    $trail->push($article->title, route('apps.blog.articles.show', $article));
});

// Tableau de bord > Blog > Articles > Corbeille
Breadcrumbs::for('apps.blog.articles.trashed', function (BreadcrumbTrail $trail) {
    $trail->parent('apps.blog.articles.index');
    $trail->push('Articles supprimés', route('apps.blog.articles.trashed'));
});

// Pour compatibilité avec les anciens templates qui utilisent 'home'
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Tableau de bord', route('dashboard'));
});


// Tableau de bord > contact
Breadcrumbs::for('apps.contact.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Demandes de contact', route('apps.contact.index'));
});

// Tableau de bord > contact > Voir contact
Breadcrumbs::for('apps.contact.show', function (BreadcrumbTrail $trail, $contact) {
    $trail->parent('apps.contact.index');
    $trail->push('contact #' . $contact->id, route('apps.contact.show', $contact));
});


// Tableau de bord > contact > Retour contact
Breadcrumbs::for('apps.contact.fich_retour', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('apps.contact.index');
    $trail->push('Fiche de retour #'. $id, route('apps.contact.fich_retour', $id));
});

// Navigation Menu Breadcrumbs
Breadcrumbs::for('apps.navigation-menu.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Gestion du Menu', route('apps.navigation-menu.index'));
});

Breadcrumbs::for('apps.navigation-menu.create', function (BreadcrumbTrail $trail) {
    $trail->parent('apps.navigation-menu.index');
    $trail->push('Créer un Menu', route('apps.navigation-menu.create'));
});

Breadcrumbs::for('apps.navigation-menu.edit', function (BreadcrumbTrail $trail, $navigationMenu) {
    $trail->parent('apps.navigation-menu.index');
    $trail->push('Modifier: ' . $navigationMenu->title, route('apps.navigation-menu.edit', $navigationMenu));
});

Breadcrumbs::for('apps.navigation-menu.show', function (BreadcrumbTrail $trail, $navigationMenu) {
    $trail->parent('apps.navigation-menu.index');
    $trail->push($navigationMenu->title, route('apps.navigation-menu.show', $navigationMenu));
});

// Brand Management Breadcrumbs
Breadcrumbs::for('apps.brand.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Marques', route('apps.brand.index'));
});

Breadcrumbs::for('apps.brand.create', function (BreadcrumbTrail $trail) {
    $trail->parent('apps.brand.index');
    $trail->push('Ajouter une marque', route('apps.brand.create'));
});

Breadcrumbs::for('apps.brand.edit', function (BreadcrumbTrail $trail, $brand) {
    $trail->parent('apps.brand.index');
    $trail->push('Modifier ' . $brand->label, route('apps.brand.edit', $brand));
});

// Constructeur Management Breadcrumbs
Breadcrumbs::for('apps.constructeur.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Constructeurs', route('apps.constructeur.index'));
});

Breadcrumbs::for('apps.constructeur.create', function (BreadcrumbTrail $trail) {
    $trail->parent('apps.constructeur.index');
    $trail->push('Ajouter un constructeur', route('apps.constructeur.create'));
});

Breadcrumbs::for('apps.constructeur.edit', function (BreadcrumbTrail $trail, $constructeur) {
    $trail->parent('apps.constructeur.index');
    $trail->push('Modifier ' . $constructeur->label, route('apps.constructeur.edit', $constructeur));
});