<?php if(isset($_SERVER['PHP_AUTH_USER']) AND isset($_SERVER['PHP_AUTH_PW'])){ ?>
Votre login est «<?php echo htmlspecialchars($_SERVER['PHP_AUTH_USER'], ENT_QUOTES) . "»\n";?>
Votre mot de passe est «<?php echo htmlspecialchars($_SERVER['PHP_AUTH_PW'], ENT_QUOTES). "»\n";?>
<?php } else{?>
Vous n'avez pas précisé de login ou/et de mot de passe.
<?php } ?>