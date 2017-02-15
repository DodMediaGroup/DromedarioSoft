<!-- Left Sidebar Start -->
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Profile -->
        <div class="profile-info">
            
            <div class="col-xs-4">
              <a href="#" class="rounded-image profile-image"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/users/default.png"></a>
            </div>
            <div class="col-xs-8">
                <div class="profile-text">Bienvenido <b><?php echo Yii::app()->user->getState('_userName'); ?></b></div>
                <div class="profile-buttons">
                  <a href="javascript:;"><i class="fa fa-envelope-o pulse"></i></a>
                  <a class="md-trigger" data-modal="logout-modal" href="#" title="Sign Out"><i class="fa fa-power-off text-red-1"></i></a>
                </div>
            </div>
            
        </div>
        <!--- Divider -->
        <div class="clearfix"></div>
        <hr class="divider" />
        <div class="clearfix"></div>
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <?php $this->renderPartial('//layouts/__menu'); ?>
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->