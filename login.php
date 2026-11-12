<?php
require_once 'config.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $stmt = mysqli_prepare($conn, "SELECT id, name, email, password, role FROM users WHERE email = ? AND role = ? AND active = 1 LIMIT 1");
    mysqli_stmt_bind_param($stmt, "ss", $email, $role);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $name, $db_email, $hash, $db_role);
    if (mysqli_stmt_fetch($stmt) && password_verify($password, $hash)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $db_email;
        $_SESSION['role'] = $db_role;
        mysqli_stmt_close($stmt);
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Identifiant, mot de passe ou espace incorrect.';
    }
    mysqli_stmt_close($stmt);
}
$page_title = 'Connexion';
include 'includes/header.php';
?>
<div class="login-wrap">
  <div class="login-intro">
    <div class="login-mark">✦</div>
    <h1>Bienvenue dans<br>votre espace de<br>réussite.</h1>
    <p>Pilotez les parcours, suivez les progrès et révélez le potentiel de chaque étudiant.</p>
    <div class="login-note">◈ Connexion sécurisée &nbsp;&nbsp; Support NOVA</div>
  </div>
  <div class="login-form-area">
    <form class="login-form" method="post" action="login.php">
      <span class="eyebrow">ESPACE PERSONNEL</span>
      <h2>Ravi de vous revoir</h2>
      <p>Connectez-vous pour accéder à votre espace NOVA.</p>
      <?php if ($error != '') { ?><div class="alert"><?php echo e($error); ?></div><?php } ?>
      <label>Votre espace</label>
      <div class="role-tabs">
        <label><input type="radio" name="role" value="admin" checked> Administration</label>
        <label><input type="radio" name="role" value="enseignant"> Enseignant</label>
        <label><input type="radio" name="role" value="etudiant"> Étudiant</label>
      </div>
      <label>Adresse e-mail</label>
      <input type="email" name="email" placeholder="exemple@nova.edu" required>
      <label>Mot de passe</label>
      <input type="password" name="password" placeholder="Votre mot de passe" required>
      <button class="btn btn-full" type="submit">Se connecter →</button>
      <a class="back-link" href="index.php">← Retour à l'accueil</a>
    </form>
  </div>
</div>
<?php include 'includes/footer.php'; ?>