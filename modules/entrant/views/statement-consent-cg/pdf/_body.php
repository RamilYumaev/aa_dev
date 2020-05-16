<?php
/* @var $this yii\web\View */
/* @var $gender string */

/* @var $anketa array */
/* @var $statementConsent modules\entrant\models\StatementConsentCg */
?>

<h1>Заявления  о согласии зачеслении</h1>
<h2> заявления от <?= $statementConsent->statementCg->statement->numberStatement ?></h2>
<h2> Обр программа <?= $statementConsent->statementCg->cg->fullName ?></h2>

