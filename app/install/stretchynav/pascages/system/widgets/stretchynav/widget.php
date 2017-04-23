<?php
class widgetStretchynav extends cmsWidget {

    public $is_cacheable = false;

    public function run(){
        $device_type = cmsRequest::getDeviceType();
        if ($device_type == 'mobile') {
            $position = $this->getOption('position_mobile');
            $direction = $this->getOption('direction_mobile');
            $tooltip = $this->getOption('tooltip_mobile');
            $border = $this->getOption('border_mobile');
            $bg_color = $this->getOption('bg_color_mobile');
            $text_color = $this->getOption('text_color_mobile');
            $trigger_color = $this->getOption('trigger_color_mobile');
            $nav_posture = $this->getOption('nav_posture_mobile');
            $top = $this->getOption('top_mobile');
            $bottom = $this->getOption('bottom_mobile');
            $left = $this->getOption('left_mobile');
            $right = $this->getOption('right_mobile');
        } else {
            $position = $this->getOption('position');
            $direction = $this->getOption('direction');
            $tooltip = $this->getOption('tooltip');
            $border = $this->getOption('border');
            $bg_color = $this->getOption('bg_color');
            $text_color = $this->getOption('text_color');
            $trigger_color = $this->getOption('trigger_color');
            $nav_posture = $this->getOption('nav_posture');
            $top = $this->getOption('top');
            $bottom = $this->getOption('bottom');
            $left = $this->getOption('left');
            $right = $this->getOption('right');
        }


        return array(
            'device_type'=> $device_type,
            'position'=> $position,
            'direction'=> $direction,
            'tooltip'=> $tooltip,
            'border'=> $border,
            'bg_color'=> $bg_color,
            'text_color'=> $text_color,
            'trigger_color'=> $trigger_color,
            'nav_posture'=> $nav_posture,
            'top'=> $top,
            'bottom'=> $bottom,
            'left'=> $left,
            'right'=> $right,
        );

    }

}