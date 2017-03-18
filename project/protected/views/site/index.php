<?php
    if(Yii::app()->user->getState('_userRol') == 1)
        $this->renderPartial('index__admin');
    else
        $this->renderPartial('index__user');