<?php
class widgetStretchynav extends cmsWidget {

    public $is_cacheable = false;

    public function run(){

        $device_type = cmsRequest::getDeviceType();

        $this->setWrapper('wrapper_plain');

        $mobile = $device_type == 'mobile' ? '_mobile' : '';

        return array(
            'device_type'=> $device_type,
            'position' => $this->getOption('position'.$mobile),
            'direction' => $this->getOption('direction'.$mobile),
            'tooltip' => $this->getOption('tooltip'.$mobile),
            'border' => $this->getOption('border'.$mobile),
            'bg_color' => $this->getOption('bg_color'.$mobile),
            'text_color' => $this->getOption('text_color'.$mobile),
            'trigger_color' => $this->getOption('trigger_color'.$mobile),
            'nav_posture' => $this->getOption('nav_posture'.$mobile),
            'top' => $this->getOption('top'.$mobile),
            'bottom' => $this->getOption('bottom'.$mobile),
            'left' => $this->getOption('left'.$mobile),
            'right' => $this->getOption('right'.$mobile),
        );

    }

}