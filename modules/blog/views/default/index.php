<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\blog\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Posts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row">
        <?php foreach ($posts as $item): ?>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
               <a href="/blog/default/view?id=<?= $item->id?>">
                   <img src="<?= $item->img ?>" alt="...">
                   <div class="caption">
                        <h3><?= $item->title?></h3>
                        <p><?= $item->text_preview?></p>
                        <?php if($item->user_id == Yii::$app->user->identity->getId()):?>
                            <p><a href="/blog/default/update?id=<?= $item->id ?>" class="btn btn-primary" role="button">Update</a> <a href="/blog/default/delete?id=<?= $item->id?>" class="btn btn-danger" role="button">Delete</a></p>
                        <?php endif; ?>
                </div>
               </a>

            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>


<?=yii\widgets\LinkPager::widget([
        'pagination' => $pages
    ]) ?>
