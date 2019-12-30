<?php

session_start();
session_destroy();
unset($_COOKIE["lembrar"]);

header("location: ../index.php");