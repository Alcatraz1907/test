<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\blog\models\Posts */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if($model->user_id == Yii::$app->user->identity->getId()): ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif; ?>
    <div class="panel panel-default">
        <div class="panel-heading"><?=$model->title ?></div>
        <div class="panel-body"><?= Html::decode($model->text) ?></div>
    </div>
	<hr>
	<h1>Comments</h1>
	<hr>
	<div class="">
		<?php if(!empty($comment_for_post)): ?>
			<?php foreach($comment_for_post as $item): ?>
				<div class="panel panel-default">

					<div class="panel-heading" data-user-id="<?= $item['user_id']?>">
						<b><?= $item['username'] ?></b>
						<br>
						<?=$item['title'] ?>
					</div>
					<div class="panel-body"><?= Html::decode($item['text']) ?></div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<?= $this->render('../comments/_form', [
		'model' => $comment_form,
	]) ?>
</div>
