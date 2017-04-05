<?php
class widgetKitdeveloper|WDNAME| extends cmsWidget {

    public function run(){

        $ctype_id        = $this->getOption('ctype_id');

        return array(
            'items'             => $items
        );

    }

}
