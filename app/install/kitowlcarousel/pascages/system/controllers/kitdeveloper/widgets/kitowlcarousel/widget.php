<?php
class widgetKitdeveloperKitowlcarousel extends cmsWidget {

    public function run(){

        $ctype_id        = $this->getOption('ctype_id');
        $dataset_id      = $this->getOption('dataset');
        $cat_id          = $this->getOption('category_id');
        $image_field     = $this->getOption('image_field');
        $teaser_field    = $this->getOption('teaser_field');
        $is_show_details = $this->getOption('show_details');
        $style           = $this->getOption('style', 'basic');
        $limit           = $this->getOption('limit', 10);
        $teaser_len      = $this->getOption('teaser_len', 100);

        // design
        $show_img_overlay = $this->getOption('show_img_overlay');
        $p_overlay  = $this->getOption('p_overlay', 'p-3');

        $title_bg = $this->getOption('bg_title', 'bg-inverse');
        $title_color = $this->getOption('color_title', 'text-white');
        $p_y_title = $this->getOption('p_y_title', 'py-2');
        $p_x_title = $this->getOption('p_x_title', 'px-3');
        $font_size_title = $this->getOption('font_size_title', 'h5');

        $details_bg = $this->getOption('bg_details', 'bg-inverse');
        $details_color = $this->getOption('color_details', 'text-white');
        $p_y_details = $this->getOption('p_y_details', 'py-2');
        $p_x_details = $this->getOption('p_x_details', 'px-3');
        $details_self = $this->getOption('details_self', 'align-self-start');

        // options script
        $show_control = $this->getOption('show_control');


        $title_class = array(
            'title_bg'          => $title_bg,
            'title_color'       => $title_color,
            'p_y_title'         => $p_y_title,
            'p_x_title'         => $p_x_title,
            'font_size_title'   => $font_size_title,
        );

        $details_class = array(
            'details_bg'          => $details_bg,
            'details_color'       => $details_color,
            'p_y_details'         => $p_y_details,
            'p_x_details'         => $p_x_details,
            'details_self'        => $details_self,
        );

        $this->css_class_title = "owl_nav_$this->id";

        $model = cmsCore::getModel('content');

        $ctype = $model->getContentType($ctype_id);
        if (!$ctype) { return false; }

		if ($cat_id){
			$category = $model->getCategory($ctype['name'], $cat_id);
		} else {
			$category = false;
		}

        if ($dataset_id){

            $dataset = $model->getContentDataset($dataset_id);

            if ($dataset){
                $model->applyDatasetFilters($dataset);
            } else {
                $dataset_id = false;
            }

        }

		if ($category){
			$model->filterCategory($ctype['name'], $category, true);
		}

        // Приватность
        // флаг показа только названий
        $hide_except_title = (!empty($ctype['options']['privacy_type']) && $ctype['options']['privacy_type'] == 'show_title');

        // Сначала проверяем настройки типа контента
        if (!empty($ctype['options']['privacy_type']) && in_array($ctype['options']['privacy_type'], array('show_title', 'show_all'), true)) {
            $model->disablePrivacyFilter();
            if($ctype['options']['privacy_type'] != 'show_title'){
                $hide_except_title = false;
            }
        }

        // А потом, если разрешено правами доступа, отключаем фильтр приватности
        if (cmsUser::isAllowed($ctype['name'], 'view_all')) {
            $model->disablePrivacyFilter(); $hide_except_title = false;
        }

        // Скрываем записи из скрытых родителей (приватных групп и т.п.)
        $model->filterHiddenParents();

        if($this->getOption('widget_type') == 'related'){
            // мы на странице записи типа контента?
            $current_ctype_item = cmsModel::getCachedResult('current_ctype_item');
            if($current_ctype_item){

                $this->disableCache();

                $model->filterRelated('title', $current_ctype_item['title']);

                if($current_ctype_item['ctype_name'] == $ctype['name']){
                    $model->filterNotEqual('id', $current_ctype_item['id']);
                }


            } else {
                return false;
            }
        }

		list($ctype, $model) = cmsEventsManager::hook("content_list_filter", array($ctype, $model));
		list($ctype, $model) = cmsEventsManager::hook("content_{$ctype['name']}_list_filter", array($ctype, $model));

        $items = $model->
                    limit($limit)->
                    getContentItems($ctype['name']);
        if (!$items) { return false; }

        list($ctype, $items) = cmsEventsManager::hook("content_before_list", array($ctype, $items));
        list($ctype, $items) = cmsEventsManager::hook("content_{$ctype['name']}_before_list", array($ctype, $items));

        if($style){
            $this->setTemplate('list_'.$style);
        } else {
            $this->setTemplate($this->tpl_body);
        }

        return array(
            'ctype'             => $ctype,
            'hide_except_title' => $hide_except_title,
            'teaser_len'        => $teaser_len,
            'image_field'       => $image_field,
            'teaser_field'      => $teaser_field,
            'show_img_overlay'  => $show_img_overlay,
            'is_show_details'   => $is_show_details,
            'style'             => $style,
            'title_class'       => $title_class,
            'p_overlay'         => $p_overlay,
            'details_class'     => $details_class,
            'show_control'      => $show_control,
            'items'             => $items
        );

    }

}
