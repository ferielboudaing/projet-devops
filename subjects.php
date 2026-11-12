<?php
require_once 'config.php'; require_role(array('admin'));
if (isset($_GET['delete'])) { mysqli_query($conn, "DELETE FROM subjects WHERE id=".intval($_GET['delete'])); header('Location: subjects.php'); exit; }
$message='';
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $name=trim($_POST['name']); $code=trim($_POST['code']); $coef=floatval($_POST['coefficient']); $semester=trim($_POST['semester']);
    $stmt=mysqli_prepare($conn,"INSERT INTO subjects (name,code,coefficient,semester) VALUES (?,?,?,?)");
    mysqli_stmt_bind_param($stmt,"ssds",$name,$code,$coef,$semester);
    $message=mysqli_stmt_execute($stmt)?'Matière ajoutée.':'Erreur : code déjà utilisé ?'; mysqli_stmt_close($stmt);
}
$page_title='Matières'; include 'includes/header.php';
?>
<div class="page-heading"><div><span class="eyebrow">ADMINISTRATION</span><h1>Matières</h1><p>Gérez les matières, leurs codes et coefficients.</p></div></div>
<?php if($message){ ?><div class="alert success"><?php echo e($message); ?></div><?php } ?>
<div class="panel"><h2>Ajouter une matière</h2><form method="post" class="form-grid"><label>Nom<input name="name" required></label><label>Code<input name="code" required></label><label>Coefficient<input type="number" name="coefficient" min="0.1" step="0.1" value="1" required></label><label>Semestre<select name="semester"><option>S1</option><option>S2</option></select></label><div><button class="btn">Ajouter</button></div></form></div>
<div class="panel"><h2>Liste des matières</h2><div class="table-wrap"><table><tr><th>Code</th><th>Matière</th><th>Coefficient</th><th>Semestre</th><th>Action</th></tr><?php $r=mysqli_query($conn,"SELECT * FROM subjects ORDER BY name"); while($s=mysqli_fetch_assoc($r)){ ?><tr><td><?php echo e($s['code']); ?></td><td><?php echo e($s['name']); ?></td><td><?php echo e($s['coefficient']); ?></td><td><?php echo e($s['semester']); ?></td><td><a class="delete-link" onclick="return confirm('Supprimer ?')" href="subjects.php?delete=<?php echo $s['id']; ?>">Supprimer</a></td></tr><?php } ?></table></div></div>
<?php include 'includes/footer.php'; ?>