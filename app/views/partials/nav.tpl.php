<?php
//TODO Recherches Perso Affichage Conditionnel
// dump($viewData); 
dump($_SESSION);
//dump($_SESSION['userObject']->getRole()) ; 
?>

<!-- Bonus : gestion de la classe active -->
<!-- Plusieurs manières de faire -->
<!-- Copyright Christelle -->
<!-- <a class="nav-link <?php // echo $viewName === "main/home" ? "active" : ""
                        ?>" href="<?php // echo $router->generate('main-home') 
                                    ?>"> -->

<!-- Copyright Erwann -->
<?php //TODO (strpos($currentPage, 'product') !== false) ? "active" : ""; 
?>

<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $router->generate('main-home') ?>">oShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <!-- <a class="nav-link" href="<?php // echo $router->generate('main-home') 
                                                    ?>">Accueil</a> -->
                    <a class="nav-link <?= (strpos($currentPage, 'home') !== false) ? "active" : ""; ?>" href="<?= $router->generate('main-home') ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="<?php // echo $router->generate('category-list') 
                                                    ?>">Catégories <span class="sr-only">(current)</span></a> -->
                    <a class="nav-link <?= (strpos($currentPage, 'category-list') !== false) ? "active" : ""; ?>" href="<?= $router->generate('category-list') ?>">Catégories</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="<?php // echo $router->generate('product-list') 
                                                    ?>">Produits</a> -->
                    <a class="nav-link <?= (strpos($currentPage, 'product-list') !== false) ? "active" : ""; ?>" href="<?= $router->generate('product-list') ?>">Produits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Types</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Marques</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tags</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="#">Sélection Accueil</a> -->
                    <a class="nav-link <?= (strpos($currentPage, 'manage') !== false) ? "active" : ""; ?>" href="<?= $router->generate('category-manage') ?>">Sélection Accueil</a>
                </li>
                <?php if (isset($_SESSION['userId'])) : ?>

                    <?php if ($_SESSION['userObject']->getRole() === "admin") : ?>

                        <li class="nav-item">
                            <a class="nav-link <?= (strpos($currentPage, 'user-list') !== false) ? "active" : ""; ?>" href="<?= $router->generate('user-list') ?>">
                                Utilisateurs
                            </a>
                        </li>

                    <?php endif; ?>
            </ul>
        </div>
        <a href="<?= $router->generate('user-logout') ?>" class="btn btn-success float-end">Déconnexion</a>

    <?php endif; ?>

    </div>

    <!-- Si aucun User en Session => Afficher le bouton -->

    <?php if (!isset($_SESSION['userId'])) :  ?>
        <a href="<?= $router->generate('user-login') ?>" class="btn btn-success float-end">Se Connecter</a>

    <?php endif; ?>


</nav>