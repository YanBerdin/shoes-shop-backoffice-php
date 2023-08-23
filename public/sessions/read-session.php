<?php
// Avant tout, pour travailler avec la session, on doit démarrer le mécanisme de session
// NB : c'est la première chose à faire avant tout autre code PHP !
session_start();

print_r($_SESSION);
