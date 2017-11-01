<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Repo */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Repos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/bootbox.min.js',['depends'=>[\yii\web\JqueryAsset::className(),]]);
$this->registerJsFile('js/requests.js',['depends'=>[\yii\web\JqueryAsset::className(),]]);
?>
<div class="repo-view">

    <h1><?= Html::encode($this->title) ?></h1>

<?php if($model->adminid == \Yii::$app->user->id): ?>
    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ishide',
            'RegisterDate',
            [
                'label' => 'Owner',
                'value' => Html::a($model->user->name,['repo/index-for-user','uid'=>$model->user->id]),
                'format' => 'html',
            ],
        ],
    ]) ?>
<?php if($model->adminid == \Yii::$app->user->id): ?>
    <h3>Invite other user to join this project</h3>
    <p>invite <input>to join as a testManager <button class="invite" data-role="M" data-repoid="<?= $model->id ?>" data-url="<?= Url::to(["request/invite"]) ?>">OK</button></p>
    <p>invite <input>to join as a tester <button class="invite" data-role="E" data-repoid="<?= $model->id ?>" data-url="<?= Url::to(["request/invite"]) ?>">OK</button></p>
<?php endif; ?>
<?php if($testManagers): ?>
    <h3>Test Manager</h3>
    <ul>
    <?php foreach($testManagers as $m): ?>
        <li><?= Html::a($m->name,['repo/index-for-user','uid'=>$m->id]) ?></li>
    <?php endforeach; ?>
    </ul>    
<?php endif; ?>
<?php if($testers): ?>
    <h3>Tester</h3>
    <ul>
    <?php foreach($testers as $t): ?>
        <li><?= Html::a($t->name,['repo/index-for-user','uid'=>$t->id]) ?></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if(!\Yii::$app->user->isGuest && !$model->isRelevantForUser(\Yii::$app->user->id)): ?>
    <div>
        <a href="<?= Url::to(['request/apply-join-in'],true) ?>" class="btn btn-danger apply" data-repoid="<?= $model->id ?>" data-guest="<?= \Yii::$app->user->isGuest ?>">I want to join this project.</a>
    </div>
<?php endif; ?>

<?php if($model->adminid == \Yii::$app->user->id): ?>
    <p>
        <?= Html::a('Create Area', '#', [
            'class' => 'btn btn-success',
            'onclick' => 'bootbox.prompt("Please input Area to be created:", function(result){ alert("Area:"+result+",repoid:'.$model->id.'"); });',
        ]) ?>
    </p>
    <h2>Area list</h2>
    <?php foreach($areas as $a): ?>
        <li><?= Html::label($a->area,$a->area) ?> <?= Html::a('Modify Area', '#', [
            'class' => 'btn btn-link',
            'onclick' => 'bootbox.prompt("Please modify Area:", function(result){ alert("Area:"+result+",areaid:'.$a->id.'"); });',
        ]) ?></li>
    <?php endforeach; ?>
    <p>
        <?= Html::a('Create Category', '#', [
            'class' => 'btn btn-success',
            'onclick' => 'bootbox.prompt("Please input Category to be created:", function(result){ alert("Category:"+result+",repoid:'.$model->id.'"); });',
        ]) ?>
    </p>
    <h2>Category list</h2>
    
    <p>
        <?= Html::a('Create Tag', '#', [
            'class' => 'btn btn-success',
            'onclick' => 'bootbox.prompt("Please input Tag to be created:", function(result){ alert("Tag:"+result+",repoid:'.$model->id.'"); });',
        ]) ?>
    </p>
    <h2>Tag list</h2>
<?php endif; ?>

</div>
