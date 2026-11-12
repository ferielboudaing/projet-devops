<?php
require_once 'config.php'; require_role(array('admin'));
if (isset($_GET['delete'])) { mysqli_query($conn, "DELETE FROM classes WHERE id=".intval($_GET['delete'])); header('Location: classes.php'); exit; }
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']); $level = trim($_POST['level']);
    $stmt = mysqli_prepare($conn, "INSERT INTO classes (name,level) VALUES (?,?)");
    mysqli_stmt_bind_param($stmt, "ss", $name, $level);
    $message = mysqli_stmt_execute($stmt) ? 'Classe ajoutée.' : 'Erreur lors de l’ajout.';
    mysqli_stmt_close($stmt);
}
$page_title='Classes'; include 'includes/header.php';
?>
<div class="page-heading"><div><span class="eyebrow">ADMINISTRATION</span><h1>Classes</h1><p>Organisez les étudiants par niveau et groupe.</p></div></div>
<?php if ($message) { ?><div class="alert success"><?php echo e($message); ?></div><?php } ?>
<div class="panel"><h2>Ajouter une classe</h2><form method="post" class="form-grid"><label>Nom de la classe<input name="name" placeholder="Ex. 2ème année GL - G1" required></label><label>Niveau / année<input name="level" placeholder="Ex. L2 ou M1" required></label><div><button class="btn">Ajouter</button></div></form></div>
<div class="panel"><h2>Liste des classes</h2><div class="table-wrap"><table><tr><th>Classe</th><th>Niveau</th><th>Action</th></tr><?php $r=mysqli_query($conn,"SELECT * FROM classes ORDER BY name"); while($c=mysqli_fetch_assoc($r)){ ?><tr><td><?php echo e($c['name']); ?></td><td><?php echo e($c['level']); ?></td><td><a class="delete-link" onclick="return confirm('Supprimer ?')" href="classes.php?delete=<?php echo $c['id']; ?>">Supprimer</a></td></tr><?php } ?></table></div></div>
<?php include 'includes/footer.php'; ?>