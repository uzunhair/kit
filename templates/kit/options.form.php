<?php

class formKitTemplateOptions extends cmsForm {

    public $is_tabbed = true;

    public function init() {

        return array(

            array(
                'type' => 'fieldset',
                'title' => LANG_PAGE_LOGO,
                'childs' => array(
                    new fieldImage('logo', array(
                        'options' => array(
                            'sizes' => array('small', 'original')
                        )
                    )),
                )
            ),

            array(
                'type' => 'fieldset',
                'title' => LANG_THEME_KIT_COPYRIGHT,
                'childs' => array(

                    new fieldString('owner_name', array(
                        'title' => LANG_TITLE
                    )),

                    new fieldString('owner_url', array(
                        'title' => LANG_THEME_KIT_COPYRIGHT_URL,
                        'hint' => LANG_THEME_KIT_COPYRIGHT_URL_HINT
                    )),

                    new fieldString('owner_year', array(
                        'title' => LANG_THEME_KIT_COPYRIGHT_YEAR,
                        'hint' => LANG_THEME_KIT_COPYRIGHT_YEAR_HINT
                    )),

                )
            ),
            
            array(
                'type' => 'fieldset',
                'title' => LANG_THEME_KIT_OTHER,
                'childs' => array(

                    new fieldString('site_languages', array(
                        'title' => LANG_THEME_KIT_SITE_LANGUAGES,
                        'default' => 'ru',
                        'hint' => LANG_THEME_KIT_SITE_LANGUAGES_HINT,
                    )),

                )
            ),

            array(
                'type' => 'fieldset',
                'title' => LANG_PAGE_CSS_SETTING,
                'childs' => array(

                    new fieldList('color_scheme', array(
                        'title' => LANG_THEME_KIT_COLOR_SCHEME,
                        'default' => 'deep_forest',
                        'items' => array(
                            'deep_forest' => LANG_THEME_KIT_COLOR_SCHEME_DEEP_FOREST,
                            'deep_sea' => LANG_THEME_KIT_COLOR_SCHEME_DEEP_SEA,
                            'deep_sun' => LANG_THEME_KIT_COLOR_SCHEME_DEEP_SUN
                        ),
                    )),

                    new fieldString('btn_secondary', array(
                        'title' => LANG_THEME_KIT_BTN_MAIN,
                        'default' => 'btn btn-secondary',
                        'hint'  =>  LANG_THEME_KIT_BTN_MAIN_HINT,
                    )),

                    new fieldList('messages_alert_in', array(
                        'title' => LANG_THEME_KIT_MESSAGES_ALERT_IN,
                        'default' => 'fadeIn',
                        'items' => array(
                            'bounce' => LANG_THEME_KIT_BOUNCE,
                            'flash' => LANG_THEME_KIT_FLASH,
                            'pulse' => LANG_THEME_KIT_PULSE,
                            'rubberBand' => LANG_THEME_KIT_RUBBERBAND,
                            'shake' => LANG_THEME_KIT_SHAKE,
                            'swing' => LANG_THEME_KIT_SWING,
                            'tada' => LANG_THEME_KIT_TADA,
                            'wobble' => LANG_THEME_KIT_WOBBLE,
                            'jello' => LANG_THEME_KIT_JELLO,
                            'bounceIn' => LANG_THEME_KIT_BOUNCEIN,
                            'bounceInDown' => LANG_THEME_KIT_BOUNCEINDOWN,
                            'bounceInLeft' => LANG_THEME_KIT_BOUNCEINLEFT,
                            'bounceInRight' => LANG_THEME_KIT_BOUNCEINRIGHT,
                            'bounceInUp' => LANG_THEME_KIT_BOUNCEINUP,
                            'fadeIn' => LANG_THEME_KIT_FADEIN,
                            'fadeInDown' => LANG_THEME_KIT_FADEINDOWN,
                            'fadeInDownBig' => LANG_THEME_KIT_FADEINDOWNBIG,
                            'fadeInLeft' => LANG_THEME_KIT_FADEINLEFT,
                            'fadeInLeftBig' => LANG_THEME_KIT_FADEINLEFTBIG,
                            'fadeInRight' => LANG_THEME_KIT_FADEINRIGHT,
                            'fadeInRightBig' => LANG_THEME_KIT_FADEINRIGHTBIG,
                            'fadeInUp' => LANG_THEME_KIT_FADEINUP,
                            'fadeInUpBig' => LANG_THEME_KIT_FADEINUPBIG,
                            'flip' => LANG_THEME_KIT_FLIP,
                            'flipInX' => LANG_THEME_KIT_FLIPINX,
                            'flipInY' => LANG_THEME_KIT_FLIPINY,
                            'lightSpeedIn' => LANG_THEME_KIT_LIGHTSPEEDIN,
                            'rotateIn' => LANG_THEME_KIT_ROTATEIN,
                            'rotateInDownLeft' => LANG_THEME_KIT_ROTATEINDOWNLEFT,
                            'rotateInDownRight' => LANG_THEME_KIT_ROTATEINDOWNRIGHT,
                            'rotateInUpLeft' => LANG_THEME_KIT_ROTATEINUPLEFT,
                            'rotateInUpRight' => LANG_THEME_KIT_ROTATEINUPRIGHT,
                            'slideInUp' => LANG_THEME_KIT_SLIDEINUP,
                            'slideInDown' => LANG_THEME_KIT_SLIDEINDOWN,
                            'slideInLeft' => LANG_THEME_KIT_SLIDEINLEFT,
                            'slideInRight' => LANG_THEME_KIT_SLIDEINRIGHT,
                            'zoomIn' => LANG_THEME_KIT_ZOOMIN,
                            'zoomInDown' => LANG_THEME_KIT_ZOOMINDOWN,
                            'zoomInLeft' => LANG_THEME_KIT_ZOOMINLEFT,
                            'zoomInRight' => LANG_THEME_KIT_ZOOMINRIGHT,
                            'zoomInUp' => LANG_THEME_KIT_ZOOMINUP,
                            'rollIn' => LANG_THEME_KIT_ROLLIN,
                        )
                    )),
                    new fieldList('messages_alert_out', array(
                        'title' => LANG_THEME_KIT_MESSAGES_ALERT_OUT,
                        'hint'  =>  LANG_THEME_KIT_MESSAGES_ALERT_OUT_HINT,
                        'default' => 'fadeOut',
                        'items' => array(
                            'bounce' => LANG_THEME_KIT_BOUNCE,
                            'flash' => LANG_THEME_KIT_FLASH,
                            'pulse' => LANG_THEME_KIT_PULSE,
                            'rubberBand' => LANG_THEME_KIT_RUBBERBAND,
                            'shake' => LANG_THEME_KIT_SHAKE,
                            'swing' => LANG_THEME_KIT_SWING,
                            'tada' => LANG_THEME_KIT_TADA,
                            'wobble' => LANG_THEME_KIT_WOBBLE,
                            'jello' => LANG_THEME_KIT_JELLO,
                            'bounceOut' => LANG_THEME_KIT_BOUNCEOUT,
                            'bounceOutDown' => LANG_THEME_KIT_BOUNCEOUTDOWN,
                            'bounceOutLeft' => LANG_THEME_KIT_BOUNCEOUTLEFT,
                            'bounceOutRight' => LANG_THEME_KIT_BOUNCEOUTRIGHT,
                            'bounceOutUp' => LANG_THEME_KIT_BOUNCEOUTUP,
                            'fadeOut' => LANG_THEME_KIT_FADEOUT,
                            'fadeOutDown' => LANG_THEME_KIT_FADEOUTDOWN,
                            'fadeOutDownBig' => LANG_THEME_KIT_FADEOUTDOWNBIG,
                            'fadeOutLeft' => LANG_THEME_KIT_FADEOUTLEFT,
                            'fadeOutLeftBig' => LANG_THEME_KIT_FADEOUTLEFTBIG,
                            'fadeOutRight' => LANG_THEME_KIT_FADEOUTRIGHT,
                            'fadeOutRightBig' => LANG_THEME_KIT_FADEOUTRIGHTBIG,
                            'fadeOutUp' => LANG_THEME_KIT_FADEOUTUP,
                            'fadeOutUpBig' => LANG_THEME_KIT_FADEOUTUPBIG,
                            'flip' => LANG_THEME_KIT_FLIP,
                            'flipOutX' => LANG_THEME_KIT_FLIPOUTX,
                            'flipOutY' => LANG_THEME_KIT_FLIPOUTY,
                            'lightSpeedOut' => LANG_THEME_KIT_LIGHTSPEEDOUT,
                            'rotateOut' => LANG_THEME_KIT_ROTATEOUT,
                            'rotateOutDownLeft' => LANG_THEME_KIT_ROTATEOUTDOWNLEFT,
                            'rotateOutDownRight' => LANG_THEME_KIT_ROTATEOUTDOWNRIGHT,
                            'rotateOutUpLeft' => LANG_THEME_KIT_ROTATEOUTUPLEFT,
                            'rotateOutUpRight' => LANG_THEME_KIT_ROTATEOUTUPRIGHT,
                            'slideOutUp' => LANG_THEME_KIT_SLIDEOUTUP,
                            'slideOutDown' => LANG_THEME_KIT_SLIDEOUTDOWN,
                            'slideOutLeft' => LANG_THEME_KIT_SLIDEOUTLEFT,
                            'slideOutRight' => LANG_THEME_KIT_SLIDEOUTRIGHT,
                            'zoomOut' => LANG_THEME_KIT_ZOOMOUT,
                            'zoomOutDown' => LANG_THEME_KIT_ZOOMOUTDOWN,
                            'zoomOutLeft' => LANG_THEME_KIT_ZOOMOUTLEFT,
                            'zoomOutRight' => LANG_THEME_KIT_ZOOMOUTRIGHT,
                            'zoomOutUp' => LANG_THEME_KIT_ZOOMOUTUP,
                            'hinge' => LANG_THEME_KIT_HINGE,
                            'rollOut' => LANG_THEME_KIT_ROLLOUT,
                        )
                    )),

                )
            ),

            array(
                'type' => 'fieldset',
                'title' => LANG_THEME_KIT_CTYPES,
                'childs' => array(
                    new fieldCheckbox('scroll_to_photo', array(
                            'title' => LANG_THEME_KIT_PHOTOS_SCROLL_TO_PHOTO,
                    )),

                )
            ),

            array(
                'type' => 'fieldset',
                'title' => LANG_THEME_KIT_HTML,
                'childs' => array(

                    new fieldText('counter', array(
                        'title'     => LANG_THEME_KIT_COUNTER,
                    )),

                )
            ),

        );

    }

}
