<?php

class formWidgetKitdeveloperKitowlcarouselOptions extends cmsForm {

    public function init($options=false) {

		$cats_list = array();
		$datasets_list = array('0'=>'');
		$fields_list = array(''=>'');

		if (!empty($options['ctype_id'])){
			$content_model = cmsCore::getModel('content');
			$ctype = $content_model->getContentType($options['ctype_id']);
			$cats = $content_model->getCategoriesTree($ctype['name']);

			if ($cats){
				foreach($cats as $cat){
					if ($cat['ns_level'] > 1){
						$cat['title'] = str_repeat('-', $cat['ns_level']) . ' ' . $cat['title'];
					}
					$cats_list[$cat['id']] = $cat['title'];

				}
			}

			$datasets = $content_model->getContentDatasets($options['ctype_id']);
			if ($datasets){ $datasets_list = array('0'=>'') + array_collection_to_list($datasets, 'id', 'title'); }

			$fields = $content_model->getContentFields($ctype['name']);
			if ($fields){ $fields_list = array(''=>'') + array_collection_to_list($fields, 'name', 'title'); }

		}

        return array(

            array(
                'type' => 'fieldset',
                'title' => LANG_OPTIONS,
                'childs' => array(

                    new fieldList('options:widget_type', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_CONTENT_TYPE,
                        'default' => 'list',
                        'items' => array(
                            'list'    => LANG_WD_KITOWLCAROUSEL_CONTENT_TYPE1,
                            'related' => LANG_WD_KITOWLCAROUSEL_CONTENT_TYPE2
                        )
                    )),

                    new fieldList('options:ctype_id', array(
                        'title' => LANG_CONTENT_TYPE,
                        'generator' => function($item) {

                            $model = cmsCore::getModel('content');
                            $tree = $model->getContentTypes();

                            $items = array();

                            if ($tree) {
                                foreach ($tree as $item) {
                                    $items[$item['id']] = $item['title'];
                                }
                            }

                            return $items;

                        },
                    )),

					new fieldList('options:category_id', array(
						'title' => LANG_CATEGORY,
						'parent' => array(
							'list' => 'options:ctype_id',
							'url' => href_to('content', 'widget_cats_ajax')
						),
						'items' => $cats_list
					)),

                    new fieldList('options:dataset', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_DATASET,
						'parent' => array(
							'list' => 'options:ctype_id',
							'url' => href_to('content', 'widget_datasets_ajax')
						),
						'items' => $datasets_list
                    )),

                    new fieldList('options:image_field', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_IMAGE,
						'parent' => array(
							'list' => 'options:ctype_id',
							'url' => href_to('content', 'widget_fields_ajax')
						),
						'items' => $fields_list
                    )),

                    new fieldList('options:teaser_field', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_TEASER,
						'parent' => array(
							'list' => 'options:ctype_id',
							'url' => href_to('content', 'widget_fields_ajax')
						),
						'items' => $fields_list
                    )),

                    new fieldList('options:style', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_STYLE,
                        'default' => 'basic',
                        'items' => array(
                            'basic'       => LANG_WD_KITOWLCAROUSEL_STYLE_BASIC,
                            ''            => LANG_WD_KITOWLCAROUSEL_STYLE_CUSTOM
                        )
                    )),

                    new fieldCheckbox('options:show_details', array(
                       'title' =>  LANG_WD_KITOWLCAROUSEL_DETAILS,
                    )),

                    new fieldNumber('options:teaser_len', array(
                        'title' => LANG_PARSER_HTML_TEASER_LEN,
                        'hint' => LANG_PARSER_HTML_TEASER_LEN_HINT,
                    )),

                    new fieldNumber('options:limit', array(
                        'title' => LANG_LIST_LIMIT,
                        'default' => 10,
                        'rules' => array(
                            array('required')
                        )
                    )),

                )
            ),

            array(
                'type' => 'fieldset',
                'title' => LANG_WD_KITOWLCAROUSEL_DESIGN,
                'childs' => array(

                    new fieldCheckbox('options:show_img_overlay', array(
                        'title' =>  LANG_WD_KITOWLCAROUSEL_SHOW_IMG_OVERLAY,
                    )),

                    new fieldList('options:p_overlay', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_PADDING_OVERLAY,
                        'default' => 'p-3',
                        'items' => array(
                            'p-0' => LANG_WD_KITOWLCAROUSEL_PADDING_0,
                            'p-1' => LANG_WD_KITOWLCAROUSEL_PADDING_1,
                            'p-2' => LANG_WD_KITOWLCAROUSEL_PADDING_2,
                            'p-3' => LANG_WD_KITOWLCAROUSEL_PADDING_3,
                            'p-4' => LANG_WD_KITOWLCAROUSEL_PADDING_4,
                            'p-5' => LANG_WD_KITOWLCAROUSEL_PADDING_5,
                        )
                    )),

                    new fieldList('options:bg_title', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_BG_TITLE,
                        'default' => 'bg-inverse',
                        'items' => array(
                            'bg-faded' => LANG_WD_KITOWLCAROUSEL_BG_FADED,
                            'bg-inverse' => LANG_WD_KITOWLCAROUSEL_BG_INVERSE,
                            'bg-danger' => LANG_WD_KITOWLCAROUSEL_BG_DANGER,
                            'bg-warning' => LANG_WD_KITOWLCAROUSEL_BG_WARNING,
                            'bg-info' => LANG_WD_KITOWLCAROUSEL_BG_INFO,
                            'bg-success' => LANG_WD_KITOWLCAROUSEL_BG_SUCCESS,
                            'bg-primary' => LANG_WD_KITOWLCAROUSEL_BG_PRIMARY,
                        )
                    )),

                    new fieldList('options:color_title', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_COLOR_TITLE,
                        'default' => 'text-inverse',
                        'items' => array(
                            'text-white' => LANG_WD_KITOWLCAROUSEL_TEXT_WHITE,
                            'text-gray-dark' => LANG_WD_KITOWLCAROUSEL_TEXT_GRAY_DARK,
                            'text-muted' => LANG_WD_KITOWLCAROUSEL_TEXT_MUTED,
                            'text-danger' => LANG_WD_KITOWLCAROUSEL_TEXT_DANGER,
                            'text-warning' => LANG_WD_KITOWLCAROUSEL_TEXT_WARNING,
                            'text-info' => LANG_WD_KITOWLCAROUSEL_TEXT_INFO,
                            'text-success' => LANG_WD_KITOWLCAROUSEL_TEXT_SUCCESS,
                            'text-primary' => LANG_WD_KITOWLCAROUSEL_TEXT_PRIMARY,
                        )
                    )),

                    new fieldList('options:p_y_title', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_PADDING_TITLE_Y,
                        'default' => 'py-2',
                        'items' => array(
                            'py-0' => LANG_WD_KITOWLCAROUSEL_PADDING_Y_0,
                            'py-1' => LANG_WD_KITOWLCAROUSEL_PADDING_Y_1,
                            'py-2' => LANG_WD_KITOWLCAROUSEL_PADDING_Y_2,
                            'py-3' => LANG_WD_KITOWLCAROUSEL_PADDING_Y_3,
                            'py-4' => LANG_WD_KITOWLCAROUSEL_PADDING_Y_4,
                            'py-5' => LANG_WD_KITOWLCAROUSEL_PADDING_Y_5,
                        )

                    )),

                    new fieldList('options:p_x_title', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_PADDING_TITLE_X,
                        'default' => 'px-3',
                        'items' => array(
                            'px-0' => LANG_WD_KITOWLCAROUSEL_PADDING_X_0,
                            'px-1' => LANG_WD_KITOWLCAROUSEL_PADDING_X_1,
                            'px-2' => LANG_WD_KITOWLCAROUSEL_PADDING_X_2,
                            'px-3' => LANG_WD_KITOWLCAROUSEL_PADDING_X_3,
                            'px-4' => LANG_WD_KITOWLCAROUSEL_PADDING_X_4,
                            'px-5' => LANG_WD_KITOWLCAROUSEL_PADDING_X_5,
                        )

                    )),

                    new fieldList('options:font_size_title', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_FONT_SIZE_TITLE,
                        'default' => 'h5',
                        'items' => array(
                            'h1' => LANG_WD_KITOWLCAROUSEL_H1,
                            'h2' => LANG_WD_KITOWLCAROUSEL_H2,
                            'h3' => LANG_WD_KITOWLCAROUSEL_H3,
                            'h4' => LANG_WD_KITOWLCAROUSEL_H4,
                            'h5' => LANG_WD_KITOWLCAROUSEL_H5,
                            'h6' => LANG_WD_KITOWLCAROUSEL_H6,
                            ''   => LANG_WD_KITOWLCAROUSEL_BASE,
                        )

                    )),

                    new fieldList('options:bg_details', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_BG_DETAILS,
                        'default' => 'bg-inverse',
                        'items' => array(
                            'bg-faded' => LANG_WD_KITOWLCAROUSEL_BG_FADED,
                            'bg-inverse' => LANG_WD_KITOWLCAROUSEL_BG_INVERSE,
                            'bg-danger' => LANG_WD_KITOWLCAROUSEL_BG_DANGER,
                            'bg-warning' => LANG_WD_KITOWLCAROUSEL_BG_WARNING,
                            'bg-info' => LANG_WD_KITOWLCAROUSEL_BG_INFO,
                            'bg-success' => LANG_WD_KITOWLCAROUSEL_BG_SUCCESS,
                            'bg-primary' => LANG_WD_KITOWLCAROUSEL_BG_PRIMARY,
                        )
                    )),

                    new fieldList('options:color_details', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_COLOR_DETAILS,
                        'default' => 'text-inverse',
                        'items' => array(
                            'text-white' => LANG_WD_KITOWLCAROUSEL_TEXT_WHITE,
                            'text-gray-dark' => LANG_WD_KITOWLCAROUSEL_TEXT_GRAY_DARK,
                            'text-muted' => LANG_WD_KITOWLCAROUSEL_TEXT_MUTED,
                            'text-danger' => LANG_WD_KITOWLCAROUSEL_TEXT_DANGER,
                            'text-warning' => LANG_WD_KITOWLCAROUSEL_TEXT_WARNING,
                            'text-info' => LANG_WD_KITOWLCAROUSEL_TEXT_INFO,
                            'text-success' => LANG_WD_KITOWLCAROUSEL_TEXT_SUCCESS,
                            'text-primary' => LANG_WD_KITOWLCAROUSEL_TEXT_PRIMARY,
                        )
                    )),

                    new fieldList('options:p_y_details', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_PADDING_DETAILS_Y,
                        'default' => 'py-2',
                        'items' => array(
                            'py-0' => LANG_WD_KITOWLCAROUSEL_PADDING_Y_0,
                            'py-1' => LANG_WD_KITOWLCAROUSEL_PADDING_Y_1,
                            'py-2' => LANG_WD_KITOWLCAROUSEL_PADDING_Y_2,
                            'py-3' => LANG_WD_KITOWLCAROUSEL_PADDING_Y_3,
                            'py-4' => LANG_WD_KITOWLCAROUSEL_PADDING_Y_4,
                            'py-5' => LANG_WD_KITOWLCAROUSEL_PADDING_Y_5,
                        )

                    )),

                    new fieldList('options:p_x_details', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_PADDING_DETAILS_X,
                        'default' => 'px-3',
                        'items' => array(
                            'px-0' => LANG_WD_KITOWLCAROUSEL_PADDING_X_0,
                            'px-1' => LANG_WD_KITOWLCAROUSEL_PADDING_X_1,
                            'px-2' => LANG_WD_KITOWLCAROUSEL_PADDING_X_2,
                            'px-3' => LANG_WD_KITOWLCAROUSEL_PADDING_X_3,
                            'px-4' => LANG_WD_KITOWLCAROUSEL_PADDING_X_4,
                            'px-5' => LANG_WD_KITOWLCAROUSEL_PADDING_X_5,
                        )

                    )),

                    new fieldList('options:details_self', array(
                        'title' => LANG_WD_KITOWLCAROUSEL_DETAILS_SELF_X,
                        'default' => 'align-self-start',
                        'items' => array(
                            'align-self-start' => LANG_WD_KITOWLCAROUSEL_DETAILS_SELF_START,
                            'align-self-end' => LANG_WD_KITOWLCAROUSEL_DETAILS_SELF_END,
                            'align-self-center' => LANG_WD_KITOWLCAROUSEL_DETAILS_SELF_CENTER,
                            'align-self-stretch' => LANG_WD_KITOWLCAROUSEL_DETAILS_SELF_STRETCH,
                        )

                    )),

                )
            ),

            array(
                'type' => 'fieldset',
                'title' => LANG_WD_KITOWLCAROUSEL_SCRIPT,
                'childs' => array(
                    new fieldCheckbox('options:show_control', array(
                        'title' =>  LANG_WD_KITOWLCAROUSEL_CONTROL,
                    )),
                )
            ),

        );

    }

}
