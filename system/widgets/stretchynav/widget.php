<?php
class widgetStretchynav extends cmsWidget {

    public $is_cacheable = false;

    public function run(){

        $position = $this->getOption('position');
        $attach = $this->getOption('attach');
        $border = $this->getOption('border');
        $bg_color = $this->getOption('bg_color');
        $text_color = $this->getOption('text_color');
        $trigger_color = $this->getOption('trigger_color');
        $nav_posture = $this->getOption('nav_posture');

        if ($attach == true) {
            $position  = $position .= "-attach";
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
        );

    }

}