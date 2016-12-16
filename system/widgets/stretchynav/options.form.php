<?php

class formWidgetStretchynavOptions extends cmsForm {

    public function init() {

        return array(

            array(
                'type' => 'fieldset',
                'title' => LANG_OPTIONS, 
                'childs' => array(

                    new fieldList('options:menu', array(
                        'title' => LANG_MENU,
                        'generator' => function($item) {

                            $menu_model = cmsCore::getModel('menu');
                            $tree = $menu_model->getMenus();

                            $items = array();

                            if ($tree) {
                                foreach ($tree as $item) {
                                    $items[$item['name']] = $item['title'];
                                }
                            }

                            return $items;

                        }
                    )),

                    new fieldList('options:position', array(
                        'title' => LANG_WD_STRETCHYNAV_POSITION,
                        'default' => 'right',
                        'items' => array(
                            'stretch-right' => LANG_WD_STRETCHYNAV_POSITION_RIGHT,
                            'stretch-left' => LANG_WD_STRETCHYNAV_POSITION_LEFT
                        )
                    )),

                    new fieldCheckbox('options:attach', array(
                        'title' => LANG_WD_STRETCHYNAV_ATTACH,
                    )),

                    new fieldList('options:border', array(
                        'title' => LANG_WD_STRETCHYNAV_BORDER,
                        'default' => 'no-border',
                        'items' => array(
                            'stretch-rounded-no' => LANG_WD_STRETCHYNAV_BORDER_NO,
                            'stretch-rounded' => LANG_WD_STRETCHYNAV_BORDER_ALL,
                            'stretch-rounded-top' => LANG_WD_STRETCHYNAV_BORDER_TOP,
                            'stretch-rounded-right' => LANG_WD_STRETCHYNAV_BORDER_RIGHT,
                            'stretch-rounded-bottom' => LANG_WD_STRETCHYNAV_BORDER_BOTTOM,
                            'stretch-rounded-left' => LANG_WD_STRETCHYNAV_BORDER_LEFT,
                            'stretch-rounded-circle' => LANG_WD_STRETCHYNAV_BORDER_CIRCLE,
                        )
                    )),

                    new fieldList('options:bg_color', array(
                        'title' => LANG_WD_STRETCHYNAV_BG_COLOR,
                        'default' => 'bg-success',
                        'items' => array(
                            'bg-success' => LANG_WD_STRETCHYNAV_BG_COLOR_SUCCESS,
                            'bg-primary' => LANG_WD_STRETCHYNAV_BG_COLOR_PRIMARY,
                            'bg-info' => LANG_WD_STRETCHYNAV_BG_COLOR_INFO,
                            'bg-warning' => LANG_WD_STRETCHYNAV_BG_COLOR_WARNING,
                            'bg-danger' => LANG_WD_STRETCHYNAV_BG_COLOR_DANGER,
                            'bg-inverse' => LANG_WD_STRETCHYNAV_BG_COLOR_INVERSE,
                            'bg-faded' => LANG_WD_STRETCHYNAV_BG_COLOR_FADED,
                        )
                    )),

                    new fieldList('options:text_color', array(
                        'title' => LANG_WD_STRETCHYNAV_TEXT_COLOR,
                        'default' => 'text-white',
                        'items' => array(
                            'text-success' => LANG_WD_STRETCHYNAV_TEXT_COLOR_SUCCESS,
                            'text-primary' => LANG_WD_STRETCHYNAV_TEXT_COLOR_PRIMARY,
                            'text-info' => LANG_WD_STRETCHYNAV_TEXT_COLOR_INFO,
                            'text-warning' => LANG_WD_STRETCHYNAV_TEXT_COLOR_INVERSE,
                            'text-danger' => LANG_WD_STRETCHYNAV_TEXT_COLOR_DANGER,
                            'text-muted' => LANG_WD_STRETCHYNAV_TEXT_COLOR_MUTED,
                            'text-white' => LANG_WD_STRETCHYNAV_TEXT_COLOR_WHITE,
                        )
                    )),

                    new fieldList('options:trigger_color', array(
                        'title' => LANG_WD_STRETCHYNAV_TRIGGER_COLOR,
                        'default' => 'bg-faded',
                        'items' => array(
                            'bg-success' => LANG_WD_STRETCHYNAV_BG_COLOR_SUCCESS,
                            'bg-primary' => LANG_WD_STRETCHYNAV_BG_COLOR_PRIMARY,
                            'bg-info' => LANG_WD_STRETCHYNAV_BG_COLOR_INFO,
                            'bg-warning' => LANG_WD_STRETCHYNAV_BG_COLOR_WARNING,
                            'bg-danger' => LANG_WD_STRETCHYNAV_BG_COLOR_DANGER,
                            'bg-inverse' => LANG_WD_STRETCHYNAV_BG_COLOR_INVERSE,
                            'bg-faded' => LANG_WD_STRETCHYNAV_BG_COLOR_FADED,
                        )
                    )),

                    new fieldCheckbox('options:nav_posture', array(
                        'title' => LANG_WD_STRETCHYNAV_NAV_POSTURE,
                    )),
                )
            ),

        );

    }

}
