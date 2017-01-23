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

        );

    }

}
