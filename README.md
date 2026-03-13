# Brigade API

API REST développée avec Laravel pour gérer les plats et catégories d’un restaurant.

## Technologies

- Laravel
- Laravel Sanctum
- MySQL
- Cloudinary (upload images)
- Swagger (documentation API)
- Postman

## Installation

1. Cloner le projet

git clone https://github.com/username/brigade-api.git

2. Installer les dépendances

composer install

3. Copier le fichier .env

cp .env.example .env

4. Générer la clé Laravel

php artisan key:generate

5. Migration de la base de données

php artisan migrate

6. Lancer le serveur

php artisan serve

## Routes principales

### Auth

POST /api/register  
POST /api/login  
POST /api/logout  
GET /api/user  

### Categories

POST /api/categories  
GET /api/categories  
GET /api/categories/{id}  
PUT /api/categories/{id}  
DELETE /api/categories/{id}  

### Plats

POST /api/plats  
GET /api/plats  
GET /api/plats/{id}  
PUT /api/plats/{id}  
DELETE /api/plats/{id}  

### Associer plat à catégorie

POST /api/categories/{id}/plats

## Documentation API

Swagger :

http://127.0.0.1:8000/api/documentation

## Auteur

Amine HMIDOUCHE  
Développeur Web & Web Mobile