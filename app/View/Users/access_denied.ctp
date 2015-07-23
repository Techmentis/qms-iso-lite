<div  id="users_ajax">
    <div class="jumbotron  btn-default">
        <div class="container">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <span class="glyphicon glyphicon-ban-circle text-danger" style="font-size:150px"></span>
            </div>
            <div class="col-md-8">
                <h1><span  class="text-danger"><?php echo __("Access Denied"); ?></span></h1>
                <p><?php echo __("You do not have sufficient permissions to access this page. <br/>Contact your administrator for permissions related issues."); ?></p>
            </div>
        </div>
    </div>
    <div style="display:none"><?php echo $this->Session->flash(); ?>	</div>
</div>