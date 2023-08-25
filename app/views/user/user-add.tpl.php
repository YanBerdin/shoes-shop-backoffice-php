<?php //dump($errors);?>

<div class="container my-4">
        <a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-end">Retour</a>
       <!-- //si je rentre par le bouton 'ajouter' de la page user/list -->
        <?php if (empty($userId)) : ?>
            <h2>Ajouter un Utilisateur</h2>
        <?php else : ?>
            <h2>Modification un Utilisateur</h2>
        <?php endif; ?>

        <h3>
            <ul>
                <!-- On boucle sur $errors, array d'erreurs transmis par show() -->
                <!-- On doit vérifier que $errors existe et contient bien quelque chose -->
                <?php if (isset($viewData['$errors'])) : ?>
                    <?php foreach($errors as $error) : ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </h3>

        <form action="" method="POST" class="mt-5">
            <div class="mb-3">
                <label for="firstname" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="prenom de l'utilisateur" value="<?= $user->getFirstName() ?>" >
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Nom</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom de l'utilisateur" value="<?= $user->getLastName() ?>" >
            </div> 
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="email" value="<?= $user->getEmail() ?>" required>
            </div> 
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
            </div> 
            <div class="mb-3">
                <label for="role" class="form-label">Rôle</label>
                <select name="role" id="role" value="<?= $user->getRole() ?>" required>
                    <option value="admin">Admin</option>
                    <option value="catalog-manager">Catalog-manager</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" value="<?= $user->getStatus() ?>" required>
                    <option value="-">-</option>
                    <option value="1">Actif</option>
                    <option value="2">Désactivé</option>
                </select>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
            </div>
        </form>
    </div>