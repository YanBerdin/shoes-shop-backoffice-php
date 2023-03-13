<nav>
    <ul>
        <li><a href="<?= $router->generate('main-home') ?>">Accueil</a></li>
        <li><a href="<?= md5(time()) ?>">404</a></li>
    </ul>
</nav>