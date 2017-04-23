<?php

class formWidgetStretchynavOptions extends cmsForm {

    public function init() {

        return array(

            array(
                'type' => 'fieldset',
                'title' => LANG_OPTIONS_DESKTOP_AND_TABLET,
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
                        'default' => 'sn-b-right',
                        'items' => array(
                            'sn-t-left' => LANG_WD_STRETCHYNAV_POSITION_TOP_LEFT,
                            'sn-t-center' => LANG_WD_STRETCHYNAV_POSITION_TOP_CENTER,
                            'sn-t-right' => LANG_WD_STRETCHYNAV_POSITION_TOP_RIGHT,
                            'sn-c-left' => LANG_WD_STRETCHYNAV_POSITION_CENTER_LEFT,
                            'sn-c-right' => LANG_WD_STRETCHYNAV_POSITION_CENTER_RIGHT,
                            'sn-b-left' => LANG_WD_STRETCHYNAV_POSITION_BOTTOM_LEFT,
                            'sn-b-center' => LANG_WD_STRETCHYNAV_POSITION_BOTTOM_CENTER,
                            'sn-b-right' => LANG_WD_STRETCHYNAV_POSITION_BOTTOM_RIGHT,
                            'left-top-bottom' => LANG_WD_STRETCHYNAV_POSITION_LEFT_TOP_BOTTOM,
                            'right-top-bottom' => LANG_WD_STRETCHYNAV_POSITION_RIGHT_TOP_BOTTOM,
                            'top-left-right' => LANG_WD_STRETCHYNAV_POSITION_TOP_LEFT_RIGHT,
                            'bottom-left-right' => LANG_WD_STRETCHYNAV_POSITION_BOTTOM_LEFT_RIGHT,
                        )
                    )),

                    new fieldList('options:direction', array(
                        'title' => LANG_WD_STRETCHYNAV_DIRECTION_TITLE,
                        'default' => 'right',
                        'items' => array(
                            'direction-top'=>LANG_WD_STRETCHYNAV_DIRECTION_TOP,
                            'direction-bottom'=>LANG_WD_STRETCHYNAV_DIRECTION_BOTTOM,
                            'direction-left'=>LANG_WD_STRETCHYNAV_DIRECTION_LEFT,
                            'direction-right'=>LANG_WD_STRETCHYNAV_DIRECTION_RIGHT,
                            'direction-center direction-top-bottom'=>LANG_WD_STRETCHYNAV_DIRECTION_TOP_BOTTOM,
                            'direction-center direction-left-right'=>LANG_WD_STRETCHYNAV_DIRECTION_LEFT_RIGHT,
                        )
                    )),

                    new fieldHidden('options:sett_hint', array(
                        'hint'  => LANG_WD_STRETCHYNAV_ADVANCED_SETTINGS_HINT,
                    )),

                    new fieldString('options:top', array(
                        'title' => LANG_WD_STRETCHYNAV_MARGIN_TOP,
                    )),

                    new fieldString('options:right', array(
                        'title' => LANG_WD_STRETCHYNAV_MARGIN_RIGHT,
                    )),

                    new fieldString('options:bottom', array(
                        'title' => LANG_WD_STRETCHYNAV_MARGIN_BOTTOM,
                    )),

                    new fieldString('options:left', array(
                        'title' => LANG_WD_STRETCHYNAV_MARGIN_LEFT,
                    )),

                    new fieldList('options:tooltip', array(
                        'title' => LANG_WD_STRETCHYNAV_TOOLTIP_TITLE,
                        'default' => 'top',
                        'items' => array(
                            'top'=>LANG_WD_STRETCHYNAV_TOOLTIP_TOP,
                            'bottom'=>LANG_WD_STRETCHYNAV_TOOLTIP_BOTTOM,
                            'left'=>LANG_WD_STRETCHYNAV_TOOLTIP_LEFT,
                            'right'=>LANG_WD_STRETCHYNAV_TOOLTIP_RIGHT,
                        )
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
                            'text-warning' => LANG_WD_STRETCHYNAV_TEXT_COLOR_WARNING,
                            'text-danger' => LANG_WD_STRETCHYNAV_TEXT_COLOR_DANGER,
                            'text-muted' => LANG_WD_STRETCHYNAV_TEXT_COLOR_MUTED,
                            'text-white' => LANG_WD_STRETCHYNAV_TEXT_COLOR_WHITE,
                            'text-gray-dark' => LANG_WD_STRETCHYNAV_TEXT_COLOR_DARK,
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

            array(
                'type' => 'fieldset',
                'title' => LANG_OPTIONS_MOBILE,
                'childs' => array(
                    new fieldList('options:position_mobile', array(
                        'title' => LANG_WD_STRETCHYNAV_POSITION,
                        'default' => 'sn-b-right',
                        'items' => array(
                            'sn-t-left' => LANG_WD_STRETCHYNAV_POSITION_TOP_LEFT,
                            'sn-t-center' => LANG_WD_STRETCHYNAV_POSITION_TOP_CENTER,
                            'sn-t-right' => LANG_WD_STRETCHYNAV_POSITION_TOP_RIGHT,
                            'sn-c-left' => LANG_WD_STRETCHYNAV_POSITION_CENTER_LEFT,
                            'sn-c-right' => LANG_WD_STRETCHYNAV_POSITION_CENTER_RIGHT,
                            'sn-b-left' => LANG_WD_STRETCHYNAV_POSITION_BOTTOM_LEFT,
                            'sn-b-center' => LANG_WD_STRETCHYNAV_POSITION_BOTTOM_CENTER,
                            'sn-b-right' => LANG_WD_STRETCHYNAV_POSITION_BOTTOM_RIGHT,
                            'left-top-bottom' => LANG_WD_STRETCHYNAV_POSITION_LEFT_TOP_BOTTOM,
                            'right-top-bottom' => LANG_WD_STRETCHYNAV_POSITION_RIGHT_TOP_BOTTOM,
                            'top-left-right' => LANG_WD_STRETCHYNAV_POSITION_TOP_LEFT_RIGHT,
                            'bottom-left-right' => LANG_WD_STRETCHYNAV_POSITION_BOTTOM_LEFT_RIGHT,
                        )
                    )),

                    new fieldList('options:direction_mobile', array(
                        'title' => LANG_WD_STRETCHYNAV_DIRECTION_TITLE,
                        'default' => 'right',
                        'items' => array(
                            'direction-top'=>LANG_WD_STRETCHYNAV_DIRECTION_TOP,
                            'direction-bottom'=>LANG_WD_STRETCHYNAV_DIRECTION_BOTTOM,
                            'direction-left'=>LANG_WD_STRETCHYNAV_DIRECTION_LEFT,
                            'direction-right'=>LANG_WD_STRETCHYNAV_DIRECTION_RIGHT,
                            'direction-center direction-top-bottom'=>LANG_WD_STRETCHYNAV_DIRECTION_TOP_BOTTOM,
                            'direction-center direction-left-right'=>LANG_WD_STRETCHYNAV_DIRECTION_LEFT_RIGHT,
                        )
                    )),

                    new fieldHidden('options:sett_hint_mobile', array(
                        'hint'  => LANG_WD_STRETCHYNAV_ADVANCED_SETTINGS_HINT,
                    )),

                    new fieldString('options:top_mobile', array(
                        'title' => LANG_WD_STRETCHYNAV_MARGIN_TOP,
                    )),

                    new fieldString('options:right_mobile', array(
                        'title' => LANG_WD_STRETCHYNAV_MARGIN_RIGHT,
                    )),

                    new fieldString('options:bottom_mobile', array(
                        'title' => LANG_WD_STRETCHYNAV_MARGIN_BOTTOM,
                    )),

                    new fieldString('options:left_mobile', array(
                        'title' => LANG_WD_STRETCHYNAV_MARGIN_LEFT,
                    )),

                    new fieldList('options:tooltip_mobile', array(
                        'title' => LANG_WD_STRETCHYNAV_TOOLTIP_TITLE,
                        'default' => 'top',
                        'items' => array(
                            'top'=>LANG_WD_STRETCHYNAV_TOOLTIP_TOP,
                            'bottom'=>LANG_WD_STRETCHYNAV_TOOLTIP_BOTTOM,
                            'left'=>LANG_WD_STRETCHYNAV_TOOLTIP_LEFT,
                            'right'=>LANG_WD_STRETCHYNAV_TOOLTIP_RIGHT,
                        )
                    )),

                    new fieldList('options:border_mobile', array(
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

                    new fieldList('options:bg_color_mobile', array(
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

                    new fieldList('options:text_color_mobile', array(
                        'title' => LANG_WD_STRETCHYNAV_TEXT_COLOR,
                        'default' => 'text-white',
                        'items' => array(
                            'text-success' => LANG_WD_STRETCHYNAV_TEXT_COLOR_SUCCESS,
                            'text-primary' => LANG_WD_STRETCHYNAV_TEXT_COLOR_PRIMARY,
                            'text-info' => LANG_WD_STRETCHYNAV_TEXT_COLOR_INFO,
                            'text-warning' => LANG_WD_STRETCHYNAV_TEXT_COLOR_WARNING,
                            'text-danger' => LANG_WD_STRETCHYNAV_TEXT_COLOR_DANGER,
                            'text-muted' => LANG_WD_STRETCHYNAV_TEXT_COLOR_MUTED,
                            'text-white' => LANG_WD_STRETCHYNAV_TEXT_COLOR_WHITE,
                            'text-gray-dark' => LANG_WD_STRETCHYNAV_TEXT_COLOR_DARK,
                        )
                    )),

                    new fieldList('options:trigger_color_mobile', array(
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

                    new fieldCheckbox('options:nav_posture_mobile', array(
                        'title' => LANG_WD_STRETCHYNAV_NAV_POSTURE,
                    )),
                )
            ),

        );

    }

}
