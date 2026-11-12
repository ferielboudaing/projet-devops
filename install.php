<?php
require_once 'config.php';
$message = '';
$count = mysqli_query($conn, "SELECT id FROM users WHERE role='admin' LIMIT 1");
if (mysqli_num_rows($count) > 0) {
    $message = 'Un compte administrateur existe déjà. Supprimez install.php pour sécuriser le site.';
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    if (strlen($password) < 6) {
        $message = 'Le mot de passe doit contenir au moins 6 caractères.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $role = 'admin';
        $stmt = mysqli_prepare($conn, "INSERT INTO users (name,email,password,role,active) VALUES (?,?,?,?,1)");
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hash, $role);
        if (mysqli_stmt_execute($stmt)) {
            $message = 'Compte administrateur créé. Connectez-vous, puis supprimez le fichier install.php.';
        } else { $message = 'Erreur : cet e-mail existe peut-être déjà.'; }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html><html lang="fr"><head><meta charset="utf-8"><title>Installation NOVA</title><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="install-card"><img src="assets/logo.png" class="install-logo"><h1>Installation de NOVA</h1>
<p>Créez le premier compte administrateur.</p>
<?php if ($message != '') { ?><div class="alert"><?php echo e($message); ?></div><?php } ?>
<?php if (mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='admin' LIMIT 1")) == 0) { ?>
<form method="post"><label>Nom complet</label><input name="name" required><label>E-mail</label><input type="email" name="email" required><label>Mot de passe (6 caractères minimum)</label><input type="password" name="password" required><button class="btn btn-full">Créer l'administrateur</button></form>
<?php } else { ?><a class="btn" href="login.php">Aller à la connexion</a><?php } ?>
</div></body></html>