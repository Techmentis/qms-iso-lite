<div  id="users_ajax">
    <div class="jumbotron  btn-default">
        <div class="container">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <span class="glyphicon glyphicon-lock text-danger" style="font-size:150px"></span>
            </div>
            <div class="col-md-8">
                <h1><span  class="text-danger"><?php echo __("Record is locked"); ?></span></h1>
                <p><?php echo __("This record is under process and assigned to other user for updation. You can not access this record while its locked. <br/>Contact your administrator for permissions related issues."); ?></p>
            </div>
        </div>
    </div>
    <div style="display:none"><?php echo $this->Session->flash(); ?>	</div>
</div>