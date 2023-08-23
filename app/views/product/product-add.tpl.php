<div class="container my-4">
<?php dump($viewData); ?>
<?php // dump($brands); ?>
<?php // dump($categories); ?>
<?php // dump($types); ?>

        <a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-end">Retour</a>
        <h1>Ajouter un produit</h1>
        
        <form action="" method="POST" class="mt-5">
        <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom du produit" required>
            </div>
            <div class="mb-3">
                <label for="descrition" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Description" aria-describedby="subtitleHelpBlock" required>
                <small id="subtitleHelpBlock" class="form-text text-muted">
                    Sera affiché sur la page d'accueil comme bouton devant l'image
                </small>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Image</label>
                <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock" required>
                <small id="pictureHelpBlock" class="form-text text-muted">
                    URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
                </small>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prix</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Ex : 45,90" aria-describedby="subtitleHelpBlock" required>
                <small id="subtitleHelpBlock" class="form-text text-muted">
                    Sera affiché sur la page d'accueil comme bouton devant l'image
                </small>
            </div>
            <div class="mb-3">
                <label for="rate" class="form-label">Note</label>
                <select name="rate" id="rate" required>
                //! Boucle sur les "rate"
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Statut</label>
                <select name="status" id="status" required>
                //! Boucle sur les "status"
                <?php for ($i = 1; $i <= 2; $i++) : ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
           </div>
             <div class="mb-3">
                <label for="category_id" class="form-label">Catégorie</label>
                <select name="category_id" id="category_id" required>
                //! Boucle sur les "category"
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="brand_id" class="form-label">Marque</label>
                <select name="brand_id" id="brand_id" required>
                //! Boucle sur les "brand"
                <?php foreach ($brands as $brand) : ?>
                    <option value="<?= $brand->getId() ?>"><?= $brand->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="type_id" class="form-label">Type</label>
                <select name="type_id" id="type_id" required>
                //! Boucle sur les "type"
                <?php foreach ($types as $type) : ?>
                    <option value="<?= $type->getId() ?>"><?= $type->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
            </div>
        </form>
    </div>
