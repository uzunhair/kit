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
                'title' => LANG_ADMIN_CONTROLLER,
                'childs' => array(

                    new fieldCheckbox('disable_help_anim', array(
                        'title' => LANG_THEME_KIT_DISABLE_HELP_ANIM,
                        'default' => 0
                    ))

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

                    new fieldString('header_nav_class', array(
                        'title' => LANG_THEME_KIT_HEADER_NAV_CLASS,
                        'default' => 'navbar navbar-inverse bg-inverse',
                    )),

                    new fieldNumber('body_padding_top', array(
                        'title' => LANG_THEME_KIT_BODY_PADDING_TOP,
                        'default' => '0',
                    )),

                    new fieldNumber('body_padding_bottom', array(
                        'title' => LANG_THEME_KIT_BODY_PADDING_BOTTOM,
                        'default' => '0',
                    )),

                    new fieldList('header_nav_width', array(
                        'title' => LANG_THEME_KIT_HEADER_NAV_WIDTH,
                        'default' => 1,
                        'items' => array(
                            1 => LANG_YES,
                            0 => LANG_NO
                        )
                    )),

                    new fieldList('btn_class', array(
                        'title' => LANG_THEME_KIT_BTN_CLASS,
                        'default' => 'btn-primary',
                        'items' => array(
                            'btn-primary' => LANG_THEME_KIT_BTN_PRIMARY,
                            'btn-secondary' => LANG_THEME_KIT_BTN_SECONDARY,
                            'btn-success' => LANG_THEME_KIT_BTN_SUCCESS,
                            'btn-info' => LANG_THEME_KIT_BTN_INFO,
                            'btn-warning' => LANG_THEME_KIT_BTN_WARNING,
                            'btn-danger' => LANG_THEME_KIT_BTN_DANGER,
                            'btn-link' => LANG_THEME_KIT_BTN_LINK,
                            'btn-outline-primary' => LANG_THEME_KIT_BTN_OUTLINE_PRIMARY,
                            'btn-outline-secondary' => LANG_THEME_KIT_BTN_OUTLINE_SECONDARY,
                            'btn-outline-success' => LANG_THEME_KIT_BTN_OUTLINE_SUCCESS,
                            'btn-outline-info' => LANG_THEME_KIT_BTN_OUTLINE_INFO,
                            'btn-outline-warning' => LANG_THEME_KIT_BTN_OUTLINE_WARNING,
                            'btn-outline-danger' => LANG_THEME_KIT_BTN_OUTLINE_DANGER,
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
