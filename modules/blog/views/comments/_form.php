<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model app\modules\blog\models\Comments */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="comments-form">

    <?php $form = ActiveForm::begin(['action' =>['/blog/comments/create'], 'id' => 'forum_post', 'method' => 'post',]); ?>

    <?= $form->field($model, 'post_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->getId()])->label(false) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Comment' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>