<?php
        include "functions.php";
        include "config/connection.php";
        $menuLink=getAll('navigacija');
?>
<header>
      <nav>
        <label class="logo"><a href="index.php"><img src="assets/img/logo.png"></a></label>
        <ul>
        <?php foreach($menuLink as $x): ?>
            <li><a href="<?= $x->nav_putanja ?>"><?= $x->nav_ime ?></a></li>
        <?php endforeach; ?>
        <?php if(isset($_SESSION['user']) && $_SESSION['user']->id_uloga==1): ?>
            <li><a href="admin-page/admin.php">Profil</a></li>
            <li class="btn"><a href="models/logout.php">Odjavi se</a></li>
        <?php elseif(isset($_SESSION['user']) && $_SESSION['user']->id_uloga==2): ?>
            <li><a href="profile.php">Profil</a></li>
            <li><a href="poll.php">Anketa</a></li>
            <li class="btn"><a href="models/logout.php">Odjavi se</a></li>
        <?php else: ?>
            <li class="btn" id="btnLog"><a href="log.php">Prijava</a></li>
            <li class="btn"><a href="register.php">Registracija</a></li>
         <?php endif; ?>
        </ul>
        <label for="" id="icon">
          <i class="fa fa-bars"></i>
        </label>
      </nav>
</header>