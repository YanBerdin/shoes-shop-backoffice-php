<!-- <h1>403 Forbidden</h1>

<p>
    OUPS ! Vous n'avez pas l'autorisation d'accéder à cette ressource.
</p>

<a href="<?php // echo $router->generate('main-home') ?>">Retour à l'accueil</a> -->



<div class="container my-4">
  <h1>403 Forbidden</h1>

  <p>
    Vous n'êtes pas autorisés à accéder à cette page !
  </p>

  <div>      
    <img src="https://media.tenor.com/EgvXcIbZLqgAAAAM/gandalf-the-grey-lord-of-the-rings.gif" alt="You shall not pass" />
  </div>

  <a href="<?= $router->generate('main-home') ?>">
    Retour à l'accueil
  </a>
</div>