<?php
session_start();

// On écrase le contenu précédent de $_SESSION['mojo']
$_SESSION['mojo'] = "C'est cool les sessions";
