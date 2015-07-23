<?php

App::uses('AppHelper', 'View/Helper');

class BreadcrumbHelper extends AppHelper {

    public $helpers = array('Html', 'Js' => array('jquery.min'));

    public function create($links) {

        $html = '';
        foreach ($links as $link) {

            if ($link['class'] != 'current') {
                $html .= $this->Js->link($link['title'], $link['url'], array(
                    'before' => $this->Js->get('#loading')->effect('fadeIn'),
                    'success' => $this->Js->get('#loading')->effect('fadeOut'),
                    'update' => '#content',
                    'class' => $link['class'],
                    'style' => 'font-size:12px'
                        )
                );
            } else {
                $html .= $link['title'];
            }
        }
        $html .= " / ";

        return $html;
    }

}
