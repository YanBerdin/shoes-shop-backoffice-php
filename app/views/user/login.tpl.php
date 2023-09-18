<?php // dump($_SESSION); 
?>

<h1>Page de connexion à l'interface admin</h1>

<!-- <form action="" method="POST" class="mt-5">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" email="email" placeholder="Veuillez entrer votre email" value="" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Veuillez entrer votre mot de passe" aria-describedby="passwordHelpBlock" value="" required>
        <small id="passwordHelpBlock" class="form-text text-muted">
        </small>
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary mt-5">Me connecter</button>
    </div>
</form> -->

<div class="container my-4">
  <div class="row justify-content-center align-items-center">
    <div id="login-column" class="col-md-6">
      <div class="box">
        <div class="float">

<!-- ----------------------------------------------------------------------------------- -->

         <!-- Si $errors contient des erreurs => Afficher la liste des erreurs -->

          <?php if( !empty( $errors ) ) : ?>
            <div class="alert alert-danger">
              <strong>
                Erreur : 
              </strong>
              <ul class="mb-0">
              <!-- Boucle pour afficher la liste -->
                <?php foreach( $errors as $error ) : ?>
                  <li>
                    <?= $error ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <!-- ----------------------------------------------------------------------------------- -->

          <form class="form" action="<?= $router->generate('user-login'); ?>" method="post">
            <div class="form-group mb-3">
              <label for="email">
                E-mail:
              </label>
              <br>
              <input type="text" name="email" id="email" class="form-control">
            </div>
            <div class="form-group mb-3">
              <label for="password">
                Mot de passe :
              </label>
              <br>
              <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group mb-3">
              <input type="submit" class="btn btn-info btn-md" value="Connexion">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
