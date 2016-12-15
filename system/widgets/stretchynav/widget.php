<?php
class widgetStretchynav extends cmsWidget {

    public $is_cacheable = false;

    public function run(){

        $mene_id   = $this->getOption('menu');
        $bg_color   = $this->getOption('bg_color');


        $model = cmsCore::getModel('menu');

        return array(
        );

    }

}
