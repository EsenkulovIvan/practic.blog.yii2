<?php

/** @var yii\web\View $this */

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4"><?= Yii::$app->name ?></h1>

       <!-- <p class="lead">You have successfully created your Yii-powered application.</p>-->

        <!--<p><a class="btn btn-lg btn-success" href="https://www.yiiframework.com">Get started with Yii</a></p>-->
    </div>

    <div class="body-content">
        <?php foreach ($model as $item): ?>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h2><?= $item->title ?></h2>
                <p><?= $item->content ?></p>
                <?php foreach ($item->comments as $comment): ?>
                <p><?= $comment->content ?></p>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
