<?php
class widgetStretchynav extends cmsWidget {

    public $is_cacheable = false;

    public function run()
    {

        $position = $this->getOption('position');
        $stretch_bottom = $this->getOption('stretch_bottom');
        $attach = $this->getOption('attach');
        $border = $this->getOption('border');
        $bg_color = $this->getOption('bg_color');
        $text_color = $this->getOption('text_color');
        $trigger_color = $this->getOption('trigger_color');
        $nav_posture = $this->getOption('nav_posture');
        $off_top= $this->getOption('off_top');

        if ($position == 'stretch-right'){
            $tooltip_pos = 'left';
        } elseif ($position == 'stretch-left') {
            $tooltip_pos = 'right';
        } elseif ($position == 'add-content stretch-bottom') {
            $tooltip_pos = 'top';
        }
        
        if ($attach == true) {
            $position  = $position .= "-attach";
        }
        if ($stretch_bottom) {
            $position  = $position .= " stretch-bottom";

        }
        if ($nav_posture == true) {
            $position = $position .= " nav-is-visible trigger-is-hidden";
        }

        return array(
            'position'=> $position,
            'border'=> $border,
            'bg_color'=> $bg_color,
            'text_color'=> $text_color,
            'trigger_color'=> $trigger_color,
            'nav_posture'=> $nav_posture,
            'tooltip_pos'=> $tooltip_pos,
            'off_top'=> $off_top,
        );

    }

}