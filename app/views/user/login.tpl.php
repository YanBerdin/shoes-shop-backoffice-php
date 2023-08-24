<h1>Page de connexion à l'interface admin</h1>

<form action="" method="POST" class="mt-5">
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
        <button type="submit" class="btn btn-primary mt-5">Se connecter</button>
    </div>
</form>