<?php /* if ($this->request->is('ajax') == true) { ?>
    <?php echo $this->Session->flash('flash', array('params' => array('class' => 'alert-danger'))); ?>
<?php } else */
    if ($this->request->is('ajax') != true)
    { ?>
    <?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
    <?php echo $this->fetch('script'); ?>
    <?php //echo $this->Session->flash('flash', array('params' => array('class' => 'alert-danger'))); ?>

<script>
    $().ready(function() {
        $('#UserLoginForm').validate();
    })
</script>

    <div  id="users_ajax">
        <?php echo $this->Session->flash(); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-7 pull-left">
                    <br />
                    <div class="panel">

                        <div class="panel-body">

                        <h3>Quick Login Help</h3>

                        <strong>What is my username & password?</strong>

                        <p>If you are the MR or Administrator, and you have set up & installed this application, your username is your Email Address which you have used during the installation. If you do not recollect your username, please contact us. If you are not MR or Administrator, contact your MR or Admin.</p>


                        <strong>Why do I get "Already Logged in" error?</strong>

                        <p>As a security feature, FlinkISO&trade; does not allow multiple logins (concurrent logins) by the same username . If you have previously logged in and did not log out or have closed the browser without logging out, you will get this error.</p>


                        <strong>How do I manage to login in such situations?</strong>

                        <p>FlinkISO&trade; will wait for 3 minutes and check if your login request is valid and no other user is logged in with the same username from any other machine or browser. If no one is logged in or active at that time, you will be allowed to log in automatically.</p>


                        <strong>Regular Updates</strong>

                        <p>Our team is working diligently to enhance FlinkISO&trade;, add features and make it much more robust. We will be updating our repository from time to time & will notify you on updates. By regularly updating FlinkISO&trade;, you can enjoy the new features and enhancements.</p>


                        <h3>What is FlinkISO&trade; & How does it work?</h3>



                        <p>FlinkISO&trade; is a "Best In Class" Free open-source application that can automate your Quality Management System. You can download, install & start using it without any cost.</p>

                        <p>FlinkISO&trade; covers all aspects of ISO 9001:2008 certification & Quality Management. Once your organization is ISO-certified, you can use FlinkISO&trade; for post certification benefits, such as continued improvement and effectiveness of your certification system and maintaining a state of preparedness for periodic surveillance checks and re-certification audits. On the other hand if you are an organisation who wants to deploy QMS within your organisation without following any particular standard, you can still start using FlinkISO&trade; as the first step towards your QMS journey.</p>


                        <p>FlinkISO&trade; electronically maintains all your records; your quality and procedure manuals and other sensitive information at a single source for easy retrieval and safe storage.</p>

                        <p>FlinkISO&trade; analysis the available information and auto generates "eye to detail reports", audit preparedness report, "real time" process compliance and does year-on-year performance analysis for the management to gauge the organization's growth and productivity, and take corrective measures, as and when needed.</p>

                        <p>FlinkISO&trade; is designed to serve existing ISO 9001:2008 compliant organizations by providing them with key generic modules to fulfill their audit requirements. FlinkISO&trade; is designed to provide a cost-effective solution with a user-friendly interface.</p>

                        <p>By entrusting QMS / ISO compliance to FlinkISO&trade;, you free your resource to focus on their core competencies, while FlinkISO&trade; takes care of all the tedious internal and external ISO documentation and quality processes.</p>

                         <h3>About TECHMENTIS <?php echo $this->Html->link($this->Html->image('techmentis-logo-small.jpg', array('id' => 'techmentis-logo')),'http://www.techmentis.biz',array('class'=>'pull-right','target'=>'_blank','escape'=>false));?></h3>
                         <h5>This application is developed & maintained by Techmentis Global Services Pvt Ltd.</h5>

                        <p>TECHMENTIS GLOBAL SERVICES PVT. LTD offers an array of web business solutions through e-commerce, B2B, B2C and mobile applications. Our young and dynamic team not only thrives to create and innovate, but also focuses on building a sustainable business model which enables our clients to remain competitive and profitable in the versatile global market.</p>

                        <p>We are a team of enthusiastic professionals with more than 15 years of experience in Information Technology and related industries. Established in March-2013, Techmentis is accelerating towards success along with its valued customers and partners. Having credible experience working with both domestic and global clients.</p>

                        <p>Visit us at : <a href="www.techmentis.biz">www.techmentis.biz</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 pull-right">
                    <br />
                    <?php echo $this->Form->create('User', array('controller' => 'login', 'role' => 'form', 'class' => 'form-signin no-padding')); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo __('Signin to access your dashboard'); ?></div>
                        </div>
                        <div class="panel-body">
                            <?php
                                if(isset($this->request->params['pass'])) echo $this->Form->input('username', array('value'=>base64_decode($this->request->params['pass']['0']),'div' => false, 'label' => false, 'placeholder' => __('Please Enter username')));
                                else echo $this->Form->input('username', array('div' => false, 'label' => false, 'placeholder' => __('Please Enter username')));
                                echo $this->Form->password('password', array('div' => false, 'label' => __('Password'), 'placeholder' => '*******'));
                                echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-lg btn-primary btn-block'));
                                echo $this->Form->end();
                            ?>
                        </div>
                        <div class="panel-footer">
                            <?php echo $this->Html->link(__('Forgot password?'), array('action' => 'reset_password'), array('class' => 'forgot-pwd')); ?>
                            <?php if ($_SERVER['HTTP_HOST'] != 'localhost') { ?>
                                <span id="siteseal" style="margin-left:65px;"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=xf1CnWvbgitNP5hRlt9jx4GR7bvuKfEGP6Drm6IxMnpT3hd4u0j9J"></script><br /></span>
                                <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 pull-right">
                    <br />

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo __('Latest News & Updates')?></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            try{
                                $xml = Xml::build('http://www.flinkiso.com/flinkiso-updates/news.xml', array('return' => 'simplexml'));
                                
                                if($xml){
                                    foreach($xml as $news):
                                        echo "<h5 class='text-info'>". (string)$news->title. "<br /><small>". (string)$news->date. "</small></h5>";
                                        echo "<p>". (string)$news->description. "</p>";
                                        echo "<p><a href=".(string)$news->link." class='text-link' target='_blank'>". (string)$news->link. "</a></p><br />";
                                    endforeach;

                                }else{
                                    echo "Can not access updates";
                                }
                                
                            }catch (Exception $e){
                                echo "<h5 class='text-danger'> Can not access updates</small></h5>";
                                }
                            ?>
                        </div>
                    </div>
                                        <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo __('Spread The Quality Revolution!')?><br /><small><?php echo __('Like us, connect with us ..')?></small></div>
                </div>

                        <div class="panel-body">
                            <div class="fb-like" data-href="https://www.facebook.com/flinkiso" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
                            <br /><br />                            
                            <a class="twitter-timeline" href="https://twitter.com/FlinkISO" data-widget-id="510512945076256768">Tweets by @FlinkISO</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                        </div>                        
                    </div>
                    
                </div>

                    
                </div>
                </div>
            </div>
        </div>
   <?php } ?>
