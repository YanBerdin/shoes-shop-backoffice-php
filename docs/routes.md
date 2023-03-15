# Routes (Pushé par Gérard)

## Sprint 2

| URL | HTTP Method | Controller | Method | Title | Content | Comment |
|--|--|--|--|--|--|--|
| `/` | `GET` | `MainController` | `home` | Backoffice oShop | Backoffice dashboard | - |
| `/category/list` | `GET`| `CategoryController` | `category-list` | Liste des catégories | Categories list | - |
| `/category/add` | `GET`| `CategoryController` | `category-add` | Ajouter une catégorie | Form to add a category | - |
| `/category/update/[i:categoryId]` | `GET`| `CategoryController` | `update` | Éditer une catégorie | Form to update a category | [i:categoryId] is the category to update |
| `/category/delete/[i:categoryId]` | `GET`| `CategoryController` | `delete` | Supprimer une catégorie | Category delete | [i:categoryId] is the category to delete |
| `/brand/list` | `GET`| `BrandController` | `brand-list` | Liste des marques | Categories list | - |
| `/brand/add` | `GET`| `BrandController` | `brand-add` | Ajouter une marque | Form to add a brand | - |
| `/brand/update/[i:brandId]` | `GET`| `BrandController` | `update` | Éditer une marque | Form to update a brand | [i:brandId] is the brand to update |
| `/brand/delete/[i:brandId]` | `GET`| `BrandController` | `delete` | Supprimer une marque | Brand delete | [i:brandId] is the brand to delete |
| `/product/list` | `GET`| `ProductController` | `product-list` | Liste des produits | Categories list | - |
| `/product/add` | `GET`| `ProductController` | `product-add` | Ajouter un produit | Form to add a product | - |
| `/product/update/[i:productId]` | `GET`| `ProductController` | `update` | Éditer un produit | Form to update a product | [i:productId] is the product to update |
| `/product/delete/[i:productId]` | `GET`| `ProductController` | `delete` | Supprimer un produit | Product delete | [i:productId] is the product to delete |
| `/type/list` | `GET`| `TypeController` | `type-list` | Liste des types | Types list | - |
| `/type/add` | `GET`| `TypeController` | `type-add` | Ajouter un type | Form to add a type | - |
| `/type/update/[i:typeId]` | `GET`| `TypeController` | `update` | Éditer un type | Form to update a type | [i:typeId] is the type to update |
| `/type/delete/[i:typeId]` | `GET`| `TypeController` | `delete` | Supprimer un type | Type delete | [i:typeId] is the type to delete |
| `/user/list` | `GET`| `UserController` | `list` | Liste des utilisateurs | Users list | - |
| `/user/add` | `GET`| `UserController` | `add` | Ajouter un utilisateur | Form to add a user | - |
| `/user/update/[i:userId]` | `GET`| `UserController` | `update` | Éditer un utilisateur | Form to update a user | [i:userId] is the user to update |
| `/user/delete/[i:userId]` | `GET`| `UserController` | `delete` | Supprimer un utilisateur | User delete | [i:userId] is the user to delete |