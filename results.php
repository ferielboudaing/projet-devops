<?php
require_once 'config.php'; require_role(array('etudiant'));
$page_title='Mes résultats'; include 'includes/header.php';
$stmt=mysqli_prepare($conn,"SELECT s.name,s.code,s.coefficient,g.evaluation,g.score FROM grades g JOIN subjects s ON s.id=g.subject_id WHERE g.student_id=? ORDER BY s.name,g.id");
mysqli_stmt_bind_param($stmt,"i",$_SESSION['user_id']); mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,$subject,$code,$coef,$evaluation,$score);
$rows=array(); $sums=array();
while(mysqli_stmt_fetch($stmt)) {
    $rows[]=array('subject'=>$subject,'code'=>$code,'coef'=>$coef,'evaluation'=>$evaluation,'score'=>$score);
    if(!isset($sums[$subject])) $sums[$subject]=array('total'=>0,'count'=>0,'coef'=>$coef);
    $sums[$subject]['total'] += $score; $sums[$subject]['count']++;
}
mysqli_stmt_close($stmt);
$weighted=0; $coefs=0;
foreach($sums as $item){ $avg=$item['total']/$item['count']; $weighted += $avg*$item['coef']; $coefs += $item['coef']; }
?>
<div class="page-heading"><div><span class="eyebrow">ESPACE ÉTUDIANT</span><h1>Mes résultats</h1><p>Retrouvez vos notes et vos moyennes par matière.</p></div></div>
<div class="result-highlight"><span>Moyenne générale indicative</span><strong><?php echo $coefs ? number_format($weighted/$coefs,2,',',' ') : '--'; ?> / 20</strong><small>Calculée à partir des moyennes simples des évaluations saisies.</small></div>
<div class="panel"><h2>Détail des notes</h2><div class="table-wrap"><table><tr><th>Matière</th><th>Code</th><th>Évaluation</th><th>Note / 20</th></tr>
<?php foreach($rows as $row){ ?><tr><td><?php echo e($row['subject']); ?></td><td><?php echo e($row['code']); ?></td><td><?php echo e($row['evaluation']); ?></td><td><b><?php echo e($row['score']); ?></b></td></tr><?php } ?>
<?php if(count($rows)==0){ ?><tr><td colspan="4">Aucune note n'est encore disponible.</td></tr><?php } ?>
</table></div></div>
<?php include 'includes/footer.php'; ?>