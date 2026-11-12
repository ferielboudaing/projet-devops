<?php
require_once 'config.php'; require_role(array('admin','enseignant'));
$message=''; $error='';
$cid=isset($_REQUEST['class_id'])?intval($_REQUEST['class_id']):0;
$sid=isset($_REQUEST['subject_id'])?intval($_REQUEST['subject_id']):0;
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['save_grades'])) {
 $cid=intval($_POST['class_id']); $sid=intval($_POST['subject_id']);
 $td=floatval($_POST['td_weight'])/100; $tp=floatval($_POST['tp_weight'])/100; $ex=floatval($_POST['exam_weight'])/100;
 if ($td<0 || $tp<0 || $ex<0 || abs($td+$tp+$ex-1)>0.001) {
  $error='Les pondérations TD, TP et Examen doivent totaliser exactement 100 %.';
 } else {
  $q=mysqli_prepare($conn,"UPDATE subjects SET td_weight=?,tp_weight=?,exam_weight=? WHERE id=?");
  mysqli_stmt_bind_param($q,"dddi",$td,$tp,$ex,$sid); mysqli_stmt_execute($q); mysqli_stmt_close($q);
  $list=mysqli_query($conn,"SELECT id FROM users WHERE role='etudiant' AND class_id=".$cid);
  while($st=mysqli_fetch_assoc($list)) {
   $student=intval($st['id']);
   foreach(array('TD'=>'td','TP'=>'tp','Examen'=>'exam') as $ev=>$field) {
    $v=isset($_POST[$field][$student]) && $_POST[$field][$student]!=='' ? floatval($_POST[$field][$student]) : -1;
    if($v>=0 && $v<=20) {
     $q=mysqli_prepare($conn,"INSERT INTO grades(student_id,subject_id,evaluation,score,created_by) VALUES(?,?,?,?,?) ON DUPLICATE KEY UPDATE score=VALUES(score),created_by=VALUES(created_by)");
     mysqli_stmt_bind_param($q,"iisdi",$student,$sid,$ev,$v,$_SESSION['user_id']); mysqli_stmt_execute($q); mysqli_stmt_close($q);
    } elseif($v>20) { $error='Une note dépasse 20. Vérifiez le tableau.'; }
   }
  }
  if($error=='') $message='Toutes les notes saisies ont été enregistrées.';
 }
}
$page_title='Saisie des notes'; include 'includes/header.php';
?>
<div class="page-heading"><div><span class="eyebrow">ESPACE PÉDAGOGIQUE</span><h1>Saisie des notes</h1><p>Un seul tableau pour tous les étudiants de la classe.</p></div></div>
<?php if($message){ ?><div class="alert success"><?php echo e($message); ?></div><?php } ?>
<?php if($error){ ?><div class="alert"><?php echo e($error); ?></div><?php } ?>
<div class="panel"><h2>1. Choisir une classe et un module</h2>
<form method="get" class="form-grid">
<label>Classe<select name="class_id" required><option value="">Choisir</option><?php $r=mysqli_query($conn,"SELECT id,name FROM classes ORDER BY name"); while($x=mysqli_fetch_assoc($r)){ ?><option value="<?php echo $x['id']; ?>" <?php if($cid==$x['id']) echo 'selected'; ?>><?php echo e($x['name']); ?></option><?php } ?></select></label>
<label>Module<select name="subject_id" required><option value="">Choisir</option><?php $r=mysqli_query($conn,"SELECT id,name,code FROM subjects ORDER BY name"); while($x=mysqli_fetch_assoc($r)){ ?><option value="<?php echo $x['id']; ?>" <?php if($sid==$x['id']) echo 'selected'; ?>><?php echo e($x['name'].' ('.$x['code'].')'); ?></option><?php } ?></select></label>
<div><button class="btn">Afficher les étudiants →</button></div></form></div>
<?php if($cid>0 && $sid>0) { $sub=mysqli_query($conn,"SELECT * FROM subjects WHERE id=".$sid); $subject=mysqli_fetch_assoc($sub); if($subject) { ?>
<form method="post" class="panel"><input type="hidden" name="class_id" value="<?php echo $cid; ?>"><input type="hidden" name="subject_id" value="<?php echo $sid; ?>">
<h2>2. Pondérations de la matière</h2><p>Les trois pourcentages doivent totaliser 100 %.</p>
<div class="weight-grid">
<label>TD (%)<input type="number" name="td_weight" min="0" max="100" value="<?php echo round($subject['td_weight']*100); ?>" required></label>
<label>TP (%)<input type="number" name="tp_weight" min="0" max="100" value="<?php echo round($subject['tp_weight']*100); ?>" required></label>
<label>Examen (%)<input type="number" name="exam_weight" min="0" max="100" value="<?php echo round($subject['exam_weight']*100); ?>" required></label></div>
<h2>3. Notes des étudiants</h2><div class="table-wrap"><table><tr><th>Étudiant</th><th>TD /20</th><th>TP /20</th><th>Examen /20</th></tr>
<?php $students=mysqli_query($conn,"SELECT id,name,email FROM users WHERE role='etudiant' AND class_id=".$cid." ORDER BY name"); $n=0; while($st=mysqli_fetch_assoc($students)){ $n++; $student=intval($st['id']); $v=array('TD'=>'','TP'=>'','Examen'=>''); $rr=mysqli_query($conn,"SELECT evaluation,score FROM grades WHERE student_id=".$student." AND subject_id=".$sid); while($g=mysqli_fetch_assoc($rr)) $v[$g['evaluation']]=$g['score']; ?>
<tr><td><b><?php echo e($st['name']); ?></b><small><?php echo e($st['email']); ?></small></td>
<td><input class="grade-input" type="number" name="td[<?php echo $student; ?>]" min="0" max="20" step="0.25" value="<?php echo e($v['TD']); ?>"></td>
<td><input class="grade-input" type="number" name="tp[<?php echo $student; ?>]" min="0" max="20" step="0.25" value="<?php echo e($v['TP']); ?>"></td>
<td><input class="grade-input" type="number" name="exam[<?php echo $student; ?>]" min="0" max="20" step="0.25" value="<?php echo e($v['Examen']); ?>"></td></tr>
<?php } if($n==0){ ?><tr><td colspan="4">Aucun étudiant dans cette classe. Affectez d'abord les étudiants à cette classe.</td></tr><?php } ?></table></div>
<?php if($n>0){ ?><div class="save-row"><span><?php echo $n; ?> étudiant(s)</span><button class="btn" name="save_grades" value="1">Enregistrer toutes les notes</button></div><?php } ?>
</form><?php } else { ?><div class="alert">Matière introuvable.</div><?php } } ?>
<?php include 'includes/footer.php'; ?>
