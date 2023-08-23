<div class="container my-4">
    <a href="<?= $router->generate('category-list') ?>" class="btn btn-success float-end">Retour</a>
    <!-- <h2>Ajouter une catégorie</h2> -->

    <!-- On va gérer un affichage dynamique pour le libellé h2 -->
    <!-- Objectif : savoir si on est en mode create ou update -->
    <!-- Comment savoir cela ? -->
    <!-- En mode create, ce template ne récupère aucune donnée -->
    <!-- En mode update, ce template récupère une catégorie (et éventuellement une catégorie id) -->
    <!-- On va donc gérer la condition en fonction de la catégorie reçue ou pas -->

    <?php if (empty($categoryId)) : ?>
        <!-- Si on arrive ici avec Bouton Ajouter $categoryId est vide -->
        <!-- ce h2 est alors affiché -->
        <h2>Ajouter une catégorie</h2>
    <?php else : ?>
        <!-- Sinon on arrive ici avec Bouton Valider/Submit => $categoryId est renseigné -->
        <!-- cet autre h2 est alors affiché -->
        <h2>Modifier la catégorie</h2>
    <?php endif; ?>


    <!-- 2 attributs sont à indiquer dans la balise <form> -->
    <!-- action : fournit l'URL de redirection au submit du formulaire -->
    <!-- si action est vide ('') alors au submit, on restera sur la page actuelle -->
    <!-- method : fournit la méthode HTTP utilisée (GET ou POST) -->
    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nom de la catégorie" value="<?= $category->getName() ?>"  required autocomplete="off">
            <!-- L'attribut name permet de récupérer la valeur de l'input qui sera saisie -->
            <!-- La méthode est 'POST' ==> on retrouvera les données dans l'array associatif $_POST -->
            <!-- Par ex, pour l'input suivant subtitle, on récupèrera la données via 
                $_POST['subtitle'] -->

            <!-- for permet de créer Focus pour entrer dans champ input -->
        </div>
        <div class="mb-3">
            <label for="subtitle" class="form-label">Sous-titre</label>
            <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Sous-titre" aria-describedby="subtitleHelpBlock" value="<?= $category->getSubtitle() ?>" required autocomplete="off">
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Sera affiché sur la page d'accueil comme bouton devant l'image
            </small>
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Image</label>
            <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock" value="<?= $category->getPicture() ?>" required autocomplete="off">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>

<?php //dump($_POST); ?>
<!-- And for every user interaction, we import Bootstrap JS components -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>