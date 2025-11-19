<?php

$motDePasseClair = "secret";

$hash = password_hash($motDePasseClair, PASSWORD_DEFAULT);
echo "Le hash de '$motDePasseClair' est : $hash\n";




?>