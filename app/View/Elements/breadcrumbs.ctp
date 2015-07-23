<?php
    $controller = Inflector::humanize($this->request->params['controller']);
    if (isset($breadcrumbs[$this->request->params['controller']]['dashboard']))
        echo $this->Breadcrumb->create(array(
            array(
                'title' => $breadcrumbs[$this->request->params['controller']]['dashboard'],
                'url' => array('controller' => 'dashboards', 'action' => $breadcrumbs[$this->request->params['controller']]['dashboard_action']),
                'class' => 'text',
            )
        ));
    $this->Js->writeBuffer();
    echo $this->Session->flash();
?>