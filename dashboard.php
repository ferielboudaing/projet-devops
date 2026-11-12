<?php
require_once 'config.php'; require_login();
$page_title = 'Tableau de bord';
include 'includes/header.php';
function total_rows($conn, $table) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM " . $table);
    $row = mysqli_fetch_assoc($result); return $row['total'];
}
?>
<div class="page-heading"><div><span class="eyebrow">ESPACE <?php echo strtoupper(e($_SESSION['role'])); ?></span><h1>Bonjour, <?php echo e($_SESSION['name']); ?> 👋</h1><p>Bienvenue sur votre tableau de bord NOVA.</p></div></div>
<?php if ($_SESSION['role'] == 'admin') { ?>
<div class="stat-grid">
  <div class="dashboard-stat"><span>Étudiants</span><strong><?php $student_count = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='etudiant'"); $student_row = mysqli_fetch_assoc($student_count); echo $student_row['total']; ?></strong><small>Comptes utilisateurs au total</small></div>
  <div class="dashboard-stat"><span>Classes</span><strong><?php echo total_rows($conn, 'classes'); ?></strong><small>Classes enregistrées</small></div>
  <div class="dashboard-stat"><span>Matières</span><strong><?php echo total_rows($conn, 'subjects'); ?></strong><small>Matières enregistrées</small></div>
  <div class="dashboard-stat"><span>Notes</span><strong><?php echo total_rows($conn, 'grades'); ?></strong><small>Notes saisies</small></div>
</div>
<div class="panel"><h2>Accès rapide</h2><div class="quick-links"><a href="users.php">+ Gérer les utilisateurs</a><a href="classes.php">+ Gérer les classes</a><a href="subjects.php">+ Gérer les matières</a><a href="grades.php">+ Gérer les notes</a></div></div>
<?php } elseif ($_SESSION['role'] == 'enseignant') { ?>
<div class="panel"><h2>Espace enseignant</h2><p>Vous pouvez saisir les notes des étudiants dans les matières disponibles.</p><a class="btn" href="grades.php">Accéder à la saisie des notes →</a></div>
<?php } else { ?>
<div class="panel"><h2>Mon parcours</h2><p>Consultez vos notes et vos résultats enregistrés par vos enseignants.</p><a class="btn" href="results.php">Consulter mes résultats →</a></div>
<?php } ?>
<?php include 'includes/footer.php'; ?>