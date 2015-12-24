<?php
use \yii\widgets\ActiveForm;
use \yii\helpers\Html; //���� ��������� �������
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="list-group">
        <a href="#" class="list-group-item">Second item</a>
        <a href="#" class="list-group-item">Third item</a>
    </div>

    <!--    ������ ����-�������-->
    <?php $form = ActiveForm::begin([                 #�������� ���� ����������
        'action' => ['site/save-masseges'],
    ]); ?>
    <?= $form->field($model, 'message')->textArea(['rows' => 6]) ?><!--    ���� ����������� ������������ ����-->

    <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>


</div>
