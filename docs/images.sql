# Mise à jour de chaque colonne picture dans la table product

UPDATE `product`
SET picture = REPLACE(picture, 'assets/images/', 'https://benoclock.github.io/S06-images/')
;

# Mise à jour de chaque colonne picture dans la table category

UPDATE `category`
SET picture = REPLACE(picture, 'assets/images/', 'https://benoclock.github.io/S06-images/')
;

