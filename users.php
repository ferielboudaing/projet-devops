<?php
require_once 'config.php'; require_role(array('admin'));
$message = '';
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id != $_SESSION['user_id']) { mysqli_query($conn, "DELETE FROM users WHERE id=".$id." AND role <> 'admin'"); }
    header('Location: users.php'); exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']); $email = trim($_POST['email']);
    $role = $_POST['role']; $password = $_POST['password'];
    if (!in_array($role, array('enseignant','etudiant'))) { $message = 'Rôle invalide.'; }
    elseif (strlen($password) < 6) { $message = 'Le mot de passe doit contenir au moins 6 caractères.'; }
    else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $class_id = isset($_POST['class_id']) && $_POST['class_id'] !== '' ? intval($_POST['class_id']) : 0;
        if ($role == 'etudiant' && $class_id > 0) {
            $stmt = mysqli_prepare($conn, "INSERT INTO users (name,email,password,role,active,class_id) VALUES (?,?,?,?,1,?)");
            mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $hash, $role, $class_id);
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO users (name,email,password,role,active) VALUES (?,?,?,?,1)");
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hash, $role);
        }
        if (mysqli_stmt_execute($stmt)) { $message = 'Utilisateur ajouté avec succès.'; } else { $message = 'Erreur : e-mail déjà utilisé ?'; }
        mysqli_stmt_close($stmt);
    }
}
$page_title = 'Utilisateurs'; include 'includes/header.php';
?>
<div class="page-heading"><div><span class="eyebrow">ADMINISTRATION</span><h1>Utilisateurs</h1><p>Ajoutez les enseignants et les étudiants.</p></div></div>
<?php if ($message != '') { ?><div class="alert success"><?php echo e($message); ?></div><?php } ?>
<div class="panel"><h2>Ajouter un utilisateur</h2><form method="post" class="form-grid">
<label>Nom et prénom<input name="name" required></label>
<label>Adresse e-mail<input type="email" name="email" required></label>
<label>Rôle<select name="role"><option value="etudiant">Étudiant</option><option value="enseignant">Enseignant</option></select></label>
<label>Classe (pour un étudiant)<select name="class_id"><option value="">Aucune classe</option><?php $cr=mysqli_query($conn,"SELECT id,name FROM classes ORDER BY name"); while($cl=mysqli_fetch_assoc($cr)){ ?><option value="<?php echo $cl['id']; ?>"><?php echo e($cl['name']); ?></option><?php } ?></select></label>
<label>Mot de passe initial<input type="password" name="password" minlength="6" required></label>
<div><button class="btn">Ajouter</button></div></form></div>
<div class="panel"><h2>Liste des utilisateurs</h2><div class="table-wrap"><table><tr><th>Nom</th><th>E-mail</th><th>Rôle</th><th>Classe</th><th>Action</th></tr>
<?php $res = mysqli_query($conn, "SELECT users.id,users.name,users.email,users.role,classes.name AS class_name FROM users LEFT JOIN classes ON users.class_id=classes.id WHERE users.role <> 'admin' ORDER BY name");
while ($u = mysqli_fetch_assoc($res)) { ?><tr><td><?php echo e($u['name']); ?></td><td><?php echo e($u['email']); ?></td><td><?php echo e($u['role']); ?></td><td><?php echo e(isset($u['class_name']) ? $u['class_name'] : '—'); ?></td><td><a class="delete-link" onclick="return confirm('Supprimer cet utilisateur ?')" href="users.php?delete=<?php echo $u['id']; ?>">Supprimer</a></td></tr><?php } ?>
</table></div></div>
<?php include 'includes/footer.php'; ?>