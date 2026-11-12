<?php
require_once 'config.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }
$page_title='Accueil'; include 'includes/header.php';
?>
<section class="hero hero-full"><div class="hero-text">
<span class="eyebrow">✦ LA RÉUSSITE, SIMPLIFIÉE</span>
<h1>Chaque note compte.<br><span>Chaque réussite aussi.</span></h1>
<p>NOVA réunit administration, enseignants et étudiants dans un espace universitaire simple pour gérer les notes, suivre les résultats et accompagner chaque parcours.</p>
<a class="btn" href="login.php">Accéder à mon espace →</a> <a class="btn btn-light" href="#features">Découvrir NOVA</a>
<div class="hero-points"><span>✓ Suivi pédagogique</span><span>✓ Résultats centralisés</span><span>✓ Accès personnalisé</span></div>
</div><div class="hero-preview"><div class="preview-head">Votre espace de réussite <span class="live-dot">● NOVA</span></div>
<div class="preview-list"><div><span class="preview-icon">♙</span><span><b>Gestion des étudiants</b><small>Informations et classes organisées</small></span><i>✓</i></div>
<div><span class="preview-icon">✎</span><span><b>Saisie des notes</b><small>TD, TP et examen au même endroit</small></span><i>✓</i></div>
<div><span class="preview-icon">▤</span><span><b>Résultats en ligne</b><small>Notes et moyennes par semestre</small></span><i>✓</i></div></div>
<div class="stats"><div class="stat"><small>Organisation</small><strong>Simple</strong></div><div class="stat"><small>Accès</small><strong>Sécurisé</strong></div><div class="stat"><small>Suivi</small><strong>Clair</strong></div></div></div></section>
<div class="trust-strip"><span>UNE PLATEFORME</span><b>Simple</b><b>Centralisée</b><b>Accessible</b><b>Pratique</b></div>
<section id="features" class="features"><span class="eyebrow">FONCTIONNALITÉS</span><h2>Tous les outils au même endroit</h2><p>Les fonctions essentielles pour faciliter la gestion pédagogique.</p>
<div class="feature-grid">
<div class="feature-card"><div class="feature-symbol">♙</div><b>Gestion des étudiants</b><p>Centralisez les informations et organisez les étudiants par classe.</p></div>
<div class="feature-card"><div class="feature-symbol">✎</div><b>Saisie des notes</b><p>Saisissez les notes TD, TP et examen dans un tableau unique.</p></div>
<div class="feature-card"><div class="feature-symbol">▤</div><b>Calcul des moyennes</b><p>Calculez les moyennes selon les pondérations définies.</p></div>
<div class="feature-card"><div class="feature-symbol">▥</div><b>Suivi académique</b><p>Consultez les résultats par matière et semestre.</p></div>
<div class="feature-card"><div class="feature-symbol">◈</div><b>Gestion pédagogique</b><p>Organisez les classes, les matières et les utilisateurs.</p></div>
<div class="feature-card"><div class="feature-symbol">⌂</div><b>Espace personnalisé</b><p>Un accès adapté à chaque rôle : administration, enseignant et étudiant.</p></div>
</div></section>
<section class="how-section"><div><span class="eyebrow">COMMENT ÇA MARCHE ?</span><h2>Un espace adapté à chacun</h2><p>NOVA facilite la collaboration entre les acteurs de la vie universitaire.</p></div>
<div class="how-grid"><div class="how-card"><span>01</span><h3>Administration</h3><p>Gère les utilisateurs, les classes et les matières.</p></div><div class="how-card"><span>02</span><h3>Enseignants</h3><p>Saisissent les notes des étudiants de leurs classes.</p></div><div class="how-card"><span>03</span><h3>Étudiants</h3><p>Consultent leurs notes et leurs résultats.</p></div></div></section>
<section class="cta-section"><h2>Votre parcours universitaire, mieux organisé.</h2><p>Connectez-vous à votre espace NOVA en quelques clics.</p><a class="btn btn-white" href="login.php">Se connecter →</a></section>
<footer class="site-footer"><b>NOVA</b><p>La réussite, simplifiée.</p><span>© <?php echo date('Y'); ?> NOVA — Plateforme de gestion des notes</span></footer>
<?php include 'includes/footer.php'; ?>
