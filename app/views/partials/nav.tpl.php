<!-- Bonus : gestion de la classe active -->
<!-- Plusieurs manières de faire -->
<!-- Copyright Christelle -->
<!-- <a class="nav-link <?php // echo $viewName === "main/home" ? "active" : ""?>" href="<?php // echo $router->generate('main-home') ?>"> -->

<!-- Copyright Erwann -->
<?php //TODO (strpos($currentPage, 'product') !== false) ? "active" : ""; ?>

<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $router->generate('main-home') ?>">oShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>


            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="<?php // echo $router->generate('main-home') ?>">Accueil</a> -->
                        <a class="nav-link <?= (strpos($currentPage, 'home') !== false) ? "active" : "";?>" href="<?= $router->generate('main-home') ?>">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="<?php // echo $router->generate('category-list') ?>">Catégories <span class="sr-only">(current)</span></a> -->
                        <a class="nav-link <?= (strpos($currentPage, 'category') !== false) ? "active" : "";?>" href="<?= $router->generate('category-list') ?>">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="<?php // echo $router->generate('product-list') ?>">Produits</a> -->
                        <a class="nav-link <?= (strpos($currentPage, 'product') !== false) ? "active" : "";?>" href="<?= $router->generate('product-list') ?>">Produits</a>
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
                        <a class="nav-link" href="#">Sélection Accueil</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
