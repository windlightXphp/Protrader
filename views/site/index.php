<?php
//echo "<pre>";
//print_r($messages);die();
?>






<?php
use \yii\widgets\ActiveForm;
use \yii\helpers\Html; //���� ��������� �������
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="list-group">



        <? foreach ($messages as $message):?>
        <a href="#" class="list-group-item">

            <?= $message['messages']; ?>

            <span class="btn pull-right">at <?= date("d.m.Y H:i:s", $message['created_at']); ?></span>

<!--            .created by --><?//= $message['user_id']; ?>
        </a>
        <? endforeach; ?>





    </div>

    <!--    ������ ����-�������-->
    <?php $form = ActiveForm::begin([                 #�������� ���� ����������
        'action' => ['site/save-masseges'],
    ]); ?>
    <?= $form->field($model, 'message')->textArea(['rows' => 6]) ?><!--    ���� ����������� ������������ ����-->

    <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>


</div>
