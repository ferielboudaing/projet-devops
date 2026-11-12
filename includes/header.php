<?php
if (!isset($page_title)) { $page_title = 'NOVA'; }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo e($page_title); ?> - NOVA</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="topbar">
  <a class="brand" href="dashboard.php"><img src="assets/logo.png" alt="NOVA"><span>NOVA</span></a>
  <div class="top-right">
    <?php if (is_logged_in()) { ?>
      <span class="user-label"><?php echo e($_SESSION['name']); ?> · <?php echo e($_SESSION['role']); ?></span>
      <a class="btn btn-small" href="logout.php">Déconnexion</a>
    <?php } ?>
  </div>
</div>
<div class="layout">
<?php if (is_logged_in()) { ?>
<aside class="sidebar">
  <div class="side-caption">MENU PRINCIPAL</div>
  <a href="dashboard.php">⌂ &nbsp; Tableau de bord</a>
  <?php if ($_SESSION['role'] == 'admin') { ?>
    <a href="users.php">♙ &nbsp; Utilisateurs</a>
    <a href="classes.php">▦ &nbsp; Classes</a>
    <a href="subjects.php">▤ &nbsp; Matières</a>
    <a href="grades.php">✎ &nbsp; Gestion des notes</a>
  <?php } elseif ($_SESSION['role'] == 'enseignant') { ?>
    <a href="grades.php">✎ &nbsp; Saisir les notes</a>
  <?php } else { ?>
    <a href="results.php">▤ &nbsp; Mes résultats</a>
  <?php } ?>
  <a href="logout.php">↪ &nbsp; Déconnexion</a>
  <div class="sidebar-bottom">La réussite, simplifiée.</div>
</aside>
<?php } ?>
<main class="main-content">
