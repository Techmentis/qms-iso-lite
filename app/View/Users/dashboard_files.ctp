<div style="margin:20px">
<h2>
<?php echo Inflector::Humanize($this->request->params['pass'][0]) ;?>
</h2>
	<?php 
		if($this->request->params['pass'][0] != 'formats') echo $this->Element('files',array('filesData' => array('files'=>$files,'action'=>$this->request->params['pass'][0]))); 
		else echo 'Data added to FlinkISO&trade; application will be considred as a "Records" & Forms are available under "MR Dashboard".';
	?>        
</div>