<?php
/**
 * Выводит тег <a>
 * @param string $title Название
 * @param string $href Ссылка
 */

function html_link($title, $href){
	echo '<a href="'.htmlspecialchars($href).'">'.htmlspecialchars($title).'</a>';
}

/**
 * Возвращает панель со страницами
 *
 * @param int $page Текущая страница
 * @param int $perpage Записей на одной странице
 * @param int $total Количество записей
 * @param str $base_uri Базовый URL, может быть массивом из элементов first и base
 * @param str $query Массив параметров запроса
 */
function html_pagebar($page, $perpage, $total, $base_uri=false, $query=array()){

	if (!$total){ return; }

    $pages = ceil($total / $perpage);
    if($pages<=1) { return; }

    $core = cmsCore::getInstance();

    $anchor = '';

    if (is_string($base_uri) && mb_strstr($base_uri, '#')){
        list($base_uri, $anchor) = explode('#', $base_uri);
    }

    if ($anchor) { $anchor = '#' . $anchor; }

    if (!$base_uri) { $base_uri = $core->uri_absolute; }

    if (!is_array($base_uri)){
        $base_uri = array(
            'first'=>$base_uri,
            'base'=>$base_uri
        );
    }

    if (!is_array($query)){
        parse_str($query, $query);
    }

    $html   = '';

    $html .= '<ul class="pagination">';

	if (($page > 1) || ($page < $pages)) {

		// $html .= '<span class="pagebar_nav">';

		if ($page > 1){
			$query['page'] = ($page-1);
			$uri = ($query['page']==1 ? $base_uri['first'] : $base_uri['base']);
			$sep = mb_strstr($uri, '?') ? '&' : '?';
			if ($query['page'] == 1) { unset($query['page']); }
			$html .= ' <li class="page-item"><a href="'. $uri . ($query ? $sep .http_build_query($query) : '') . $anchor . '" class="page-link">&larr; '.LANG_PAGE_PREV.'</a> </li>';
		} else {
			$html .= '<li class="page-item disabled"> <span class="page-link ">&larr; '.LANG_PAGE_PREV.'</span></li> ';
		}

		if ($page < $pages){
			$query['page'] = ($page+1);
			$uri = ($query['page']==1 ? $base_uri['first'] : $base_uri['base']);
			$sep = mb_strstr($uri, '?') ? '&' : '?';
			if ($query['page'] == 1) { unset($query['page']); }
			$html .= ' <li class="page-item"> <a href="'. $uri . ($query ? $sep.http_build_query($query) : '') . $anchor . '" class="page-link">'.LANG_PAGE_NEXT.' &rarr;</a> </li>';
		} else {
			$html .= ' <li class="page-item disabled"><span class="page-link">'.LANG_PAGE_NEXT.' &rarr;</span></li> ';
		}

		// $html .= '</span>';

	}

	$span = 3;
	if ($page - $span < 1) { $p_start = 1; } else { $p_start = $page - $span; }
	if ($page + $span > $pages) { $p_end = $pages; } else { $p_end = $page + $span; }

	// $html .= '<span class="pagebar_pages">';

	if ($page > $span+1){
        $query['page'] = 1;
        $uri = ($query['page']==1 ? $base_uri['first'] : $base_uri['base']);
        $sep = mb_strstr($uri, '?') ? '&' : '?';
        if ($query['page'] == 1) { unset($query['page']); }
        $html .= ' <li class="page-item"><a href="'. $uri . ($query ? $sep.http_build_query($query) : '') . $anchor . '" class="page-link">'.LANG_PAGE_FIRST.'</a></li> ';
	}

    for ($p=$p_start; $p<=$p_end; $p++){
        if ($p != $page) {
            $query['page'] = $p;
            $uri = ($query['page']==1 ? $base_uri['first'] : $base_uri['base']);
            $sep = mb_strstr($uri, '?') ? '&' : '?';
            if ($query['page'] == 1) { unset($query['page']); }
            $html .= ' <li class="page-item"><a href="'. $uri . ($query ? $sep.http_build_query($query) : '') . $anchor . '" class="page-link">'.$p.'</a></li> ';
        } else {
            $html .= '<li class="page-item disabled"><span class="page-link">'.$p.'</span></li>';
        }
    }

	if ($page < $pages - $span){
        $query['page'] = $pages;
        $uri = ($query['page']==1 ? $base_uri['first'] : $base_uri['base']);
        $sep = mb_strstr($uri, '?') ? '&' : '?';
        if ($query['page'] == 1) { unset($query['page']); }
        $html .= ' <li class="page-item"><a href="'. $uri . ($query ? $sep.http_build_query($query) : '') . $anchor . '" class="page-link">'.LANG_PAGE_LAST.'</a></li> ';
	}

	// $html .= '</span>';

     $html .= '</ul>';

    $from   = $page * $perpage - $perpage + 1;
    $to     = $page * $perpage; if ($to>$total) { $to = $total; }

    $html  .= '<p class="text-muted">'.sprintf(LANG_PAGES_SHOWN, $from, $to, $total).'</p>';

	return $html;

}

/**
 * Возвращает тег <input>
 * @param string $type Тип поля
 * @param string $name Имя поля
 * @param string $value Значение по-умолчанию
 * @param array $attributes Атрибуты тега название=>значение
 * @return html
 */
function html_input($type='text', $name='', $value='', $attributes=array()){
    if ($type=='password'){ $attributes['autocomplete'] = 'off'; }
    $attr_str = html_attr_str($attributes);
    $class = 'input form-control';
    if (isset($attributes['class'])) { $class .= ' '.$attributes['class']; }
	return '<input type="'.$type.'" class="'.$class.'" name="'.$name.'" value="'.htmlspecialchars($value).'" '.$attr_str.'/>';
}

function html_file_input($name, $attributes=array()){
    $attr_str = html_attr_str($attributes);
    $class = 'file-input';
    if (isset($attributes['class'])) { $class .= ' '.$attributes['class']; }
	return '<input type="file" class="'.$class.'" name="'.$name.'" '.$attr_str.'/>';
}

function html_textarea($name='', $value='', $attributes=array()){
    $attr_str = html_attr_str($attributes);
    $class = 'textarea form-control';
    if (isset($attributes['class'])) { $class .= ' '.$attributes['class']; }
	$html = '<textarea name="'.$name.'" class="'.$class.'" '.$attr_str.'>'.htmlspecialchars($value).'</textarea>';
	return $html;
}

function html_back_button(){
	return '<div class="back_button"><a href="javascript:window.history.go(-1);">'.LANG_BACK.'</a></div>';
}

function html_checkbox($name, $checked=false, $value=1, $attributes=array()){
    if ($checked) { $attributes['checked'] = 'checked'; }
    $attr_str = html_attr_str($attributes);
    $class = 'form-check-input';
    if (isset($attributes['class'])) { $class .= ' '.$attributes['class']; }
	return '<input type="checkbox" class="'.$class.'" name="'.$name.'" value="'.$value.'" '.$attr_str.'/>';
}

function html_radio($name, $checked=false, $value=1, $attributes=array()){
    if ($checked) { $attributes['checked'] = 'checked'; }
    $attr_str = html_attr_str($attributes);
	return '<input type="radio" class="input_radio" name="'.$name.'" value="'.$value.'" '.$attr_str.'/>';
}

function html_date($date=false, $is_time=false){
    $timestamp = $date ? strtotime($date) : time();
    $date = '<time datetime="'.date('c', $timestamp).'">'.htmlspecialchars(date(cmsConfig::get('date_format'), $timestamp)).'</time>';
    if ($is_time){ $date .= ' <span class="time">' . date('H:i', $timestamp). '</span>'; }
    return $date;
}

function html_time($date=false){
    $timestamp = $date ? strtotime($date) : time();
    return date('H:i', $timestamp);
}

function html_date_time($date=false){
    return html_date($date, true);
}

function html_datepicker($name='', $value='', $attributes=array(), $datepicker = array()){
    if (isset($attributes['id'])){
        $id = $attributes['id'];
        unset($attributes['id']);
    } else {
        $id = $name;
    }
    $datepicker_default = array(
        'showStatus' => true,
        'changeYear' => true,
        'yearRange'  => '1976:'.date('Y', strtotime('+5 year')),
        'dateFormat' => cmsConfig::get('date_format_js')
    );
    if($datepicker){
        $datepicker_default = array_merge($datepicker_default, $datepicker);
    }
    $attr_str = html_attr_str($attributes);
	$html  = '<input type="text" placeholder="'.LANG_SELECT.'" name="'.$name.'" value="'.htmlspecialchars($value).'" class="date-input form-control"  id="'.$id.'" '.$attr_str.'/>';
    $html .= '<script type="text/javascript">';
    $html .= 'var datepicker_params = '.json_encode($datepicker_default).';datepicker_params.onSelect = datepickerSelected;';
    $html .= '$(function(){ $("#'.$id.'").datepicker(datepicker_params); });function datepickerSelected(dateText,inst){icms.events.run("icms_datepicker_selected_'.$name.'", inst);}';
    $html .= '</script>';
    return $html;
}

/**
 * Возвращает кнопку "Отправить" <input type="submit">
 * @param string $caption
 * @return html
 */
function html_submit($caption=LANG_SUBMIT, $name='submit', $attributes=array()){
    $attr_str = html_attr_str($attributes);
    $class = 'button-submit btn btn-primary';
    if (isset($attributes['class'])) { $class .= ' '.$attributes['class']; }
	return '<input class="'.$class.'" type="submit" name="'.$name.'" value="'.htmlspecialchars($caption).'" '.$attr_str.'/>';
}

/**
 * Возвращает html-код кнопки
 * @param str $caption Заголовок
 * @param str $name Название кнопки
 * @param str $onclick Содержимое аттрибута onclick (javascript)
 * @return html
 */
function html_button($caption, $name, $onclick='', $attributes=array()){
    $attr_str = html_attr_str($attributes);
    $class = 'button btn btn-secondary';
    if (isset($attributes['class'])) { $class .= ' '.$attributes['class']; }
	return '<input type="button" class="'.$class.'" name="'.$name.'" value="'.htmlspecialchars($caption).'" onclick="'.$onclick.'" '.$attr_str.'/>';
}

/**
 * Возвращает тег <img> аватара пользователя
 * @param array|yaml $avatars Все изображения аватара
 * @param string $size_preset Название пресета
 * @param string $alt Замещающий текст изображения
 * @param bool $is_html_empty_avatar Вместо дефолтных изображений показывать цветной блок с буквой
 * @return string
 */
function html_avatar_image($avatars, $size_preset='small', $alt='', $is_html_empty_avatar=false){

    $src = html_avatar_image_src($avatars, $size_preset);

	$size = $size_preset == 'micro' ? 'width="32" height="32"' : '';

    $img = '<img src="'.$src.'" '.$size.' alt="'.htmlspecialchars($alt).'" title="'.htmlspecialchars($alt).'" />';

    if(empty($avatars) && !empty($alt) && $is_html_empty_avatar){

        $iparams = get_image_block_param_by_title($alt);

        $img = '<div class="default_avatar '.$iparams['class'].'" style="'.$iparams['style'].'" data-letter="'.htmlspecialchars(mb_substr($alt, 0, 1)).'">'.$img.'</div>';

    }

    return $img;

}

function get_image_block_param_by_title($title) {

    static $image_block_params = null;
    if(isset($image_block_params[$title])){
        return $image_block_params[$title];
    }

    $bg_color = substr(dechex(crc32($title)), 0, 6);

    // выбираем контрастный цвет для текста
    $r = max( hexdec( substr($bg_color, 0, 2) ), 90);
    $g = max( hexdec( substr($bg_color, 2, 2) ), 90);
    $b = max( hexdec( substr($bg_color, 4, 2) ), 90);
    $yiq = (($r*299)+($g*587)+($b*114)) / 1000;
    $txt_color = ($yiq >= 140) ? 'black' : 'white';

    $image_block_params[$title] = array(
        'style' => "background-color: rgba({$r}, {$g}, {$b}, .9); color: {$txt_color};",
        'class' => $txt_color.'_avatar_text'
    );

    return $image_block_params[$title];

}

/**
 * Возвращает тег <img>
 * @param array|yaml $image Все размеры заданного изображения
 * @param string $size_preset Название пресета
 * @param string $alt Замещающий текст изображения
 * @param array $attributes Массив аттрибутов тега
 * @return string
 */
function html_image($image, $size_preset='small', $alt='', $attributes = array()){

    if(is_array($size_preset)){
        list($small_preset, $modal_preset) = $size_preset;
    } else {
        $small_preset = $size_preset;
        $modal_preset = false;
    }

	$src = html_image_src($image, $small_preset, true);
	if (!$src) { return ''; }

	$size = $small_preset == 'micro' ? 'width="32" height="32"' : '';

    $title = htmlspecialchars(isset($attributes['title']) ? $attributes['title'] : $alt); unset($attributes['title']);

    $attr_str = html_attr_str($attributes);
    $class = isset($attributes['class']) ? ' class="'.$attributes['class'].'"' : '';

    $image_html = '<img src="'.$src.'" '.$size.' title="'.$title.'" alt="'.htmlspecialchars($alt).'" '.$attr_str.$class.' />';

    if($modal_preset){
        $modal_src = html_image_src($image, $modal_preset, true);
        if ($modal_src) {
            return '<a title="'.$title.'" class="ajax-modal modal_image hover_image" href="'.$modal_src.'">'.$image_html.'</a>';
        }
    }

    return $image_html;

}

/**
 * Возвращает тег HTML gif изображения
 * @param array|yaml $image Все размеры заданного изображения
 * @param string $size_preset Название пресета
 * @param string $alt Замещающий текст изображения
 * @param array $attributes Массив аттрибутов тега
 * @return string
 */
function html_gif_image($image, $size_preset='small', $alt='', $attributes = array()){

    $class = isset($attributes['class']) ? $attributes['class'] : '';
    if($size_preset == 'micro'){
        $class .= ' micro_image';
    }

    $original_src = html_image_src($image, 'original', true);
    $preview_src  = html_image_src($image, $size_preset, true);

    if (!$preview_src) { return ''; }

    return '<a class="ajax-modal gif_image '.$class.'" href="'.$original_src.'" '.html_attr_str($attributes).'>
                <span class="background_overlay"></span>
                <span class="image_label">gif</span>
                <img src="'.$preview_src.'" alt="'.htmlspecialchars($alt).'" />
            </a>';

}

/**
 * Генерирует список опций
 * @param string $name Имя списка
 * @param array $items Массив элементов списка (значение => заголовок)
 * @param string $selected Значение выбранного элемента
 * @param array $attributes Массив аттрибутов тега
 * @return html
 */
function html_select($name, $items, $selected = '', $attributes = array()){

    $attr_str = html_attr_str($attributes);
    $class = isset($attributes['class']) ? ' class="form-control '.$attributes['class'].'"' : ' class="form-control"';
    $html = '<select name="'.$name.'" '.$attr_str.$class.'>'."\n";

    $optgroup = false;

    if($items && is_array($items)){
        foreach($items as $value => $title){

            if(is_array($title)){
                if($optgroup !== false){
                    $html .= "\t".'</optgroup>'."\n";
                    $optgroup = false;
                }
                $optgroup = true;
                $html .= "\t".'<optgroup label="'.htmlspecialchars($title[0]).'">'."\n";
                continue;
            }

            $sel = ((string) $selected === (string) $value) ? 'selected' : '';
            $html .= "\t".'<option value="'.htmlspecialchars($value).'" '.$sel.'>'.htmlspecialchars($title).'</option>'."\n";
        }
    }

    if($optgroup !== false){
        $html .= "\t".'</optgroup>'."\n";
    }

    $html .= '</select>'."\n";
    return $html;

}

/**
 * Генерирует список опций с множественным выбором
 * @param string $name Имя списка
 * @param array $items Массив элементов списка (значение => заголовок)
 * @param string $selected Массив значений выбранных элементов
 * @param array $attributes Массив аттрибутов тега
 * @return html
 */
function html_select_multiple($name, $items, $selected=array(), $attributes=array(), $is_tree=false){
    $attr_str = html_attr_str($attributes);
	$html = '<div class="input_checkbox_list" '.$attr_str.'>'."\n";
    $start_level = false;
    if(is_array($selected) && $selected){
        foreach ($selected as $k => $v) {
            if(is_numeric($v)){ $selected[$k] = (int)$v; }
        }
    }
    foreach ($items as $value=>$title){

        $checked = is_array($selected) && in_array($value, $selected, true);

        if ($is_tree){

            $level = mb_strlen(str_replace(' ', '', $title)) - mb_strlen(ltrim(str_replace(' ', '', $title), '-'));

            if ($start_level === false) { $start_level = $level; }

            $level = $level - $start_level;

            $title = ltrim($title, '- ');

            $html .= "\t" . '<label class="form-check-inline" '. ($level>0 ? 'style="margin-left:'.($level*20).'px"' : ''). '>' .
                    html_checkbox($name.'[]', $checked, $value) . ' ' .
                    htmlspecialchars($title) . '</label><br>' . "\n";

        } else {

            $html .= "\t" . '<label class="form-check-inline">' .
                    html_checkbox($name.'[]', $checked, $value) . ' ' .
                    htmlspecialchars($title) . '</label>' . "\n";

        }

	}
	$html .= '</div>'."\n";
	return $html;
}

/**
 * Генерирует и возвращает дерево категорий в виде комбо-бокса
 * @param array $tree Массив с элементами дерева NS
 * @param int $selected_id ID выбранного элемента
 * @return html
 */
function html_category_list($tree, $selected_id=0){
	$html = '<select name="category_id" id="category_id" class="combobox">'."\n";
	foreach ($tree as $cat){
		$padding = str_repeat('---', $cat['ns_level']).' ';
		if ($selected_id == $cat['id']) { $selected = 'selected'; } else { $selected = ''; }
		$html .= "\t" . '<option value="'.$cat['id'].'" '.$selected.'>'.$padding.' '.htmlspecialchars($cat['title']).'</option>' . "\n";
	}
    $html .= '</select>'."\n";
	return $html;
}

/**
 * Генерирует две радио-кнопки ВКЛ и ВЫКЛ
 * @param string $name
 * @param bool $active
 * @return html
 */
function html_switch($name, $active){
	$html = '';
	$html .= '<label><input type="radio" name="'.$name.'" value="1" '. ($active ? 'checked' : '') .'/> ' . LANG_ON . "</label> \n";
	$html .= '<label><input type="radio" name="'.$name.'" value="0" '. (!$active ? 'checked' : '') .'/> ' . LANG_OFF . "</label> \n";
	return $html;
}

function html_bool_span($value, $condition){
    if ($condition){
        return '<span class="positive">' . $value . '</span>';
    } else {
        return '<span class="negative">' . $value . '</span>';
    }
}

/**
 * Строит рекурсивно список UL из массива
 * @author acmol
 * @param array $array
 * @return string
 */
function html_array_to_list($array){

    $html = '<ul>' . "\n";

    foreach($array as $key => $elem){

        if(!is_array($elem)){
            $html = $html . '<li>'.$elem.'</li>' . "\n";
        }
        else {
            $html = $html . '<li class="folder">'.$key.' '.html_array_to_list($elem).'</li>' . "\n";
        }

    }

    $html = $html . "</ul>" . "\n";

    return $html;

}

function html_tags_bar($tags){

    if (!$tags) { return ''; }

    if (!is_array($tags)){
        $tags = explode(',', $tags);
    }

    foreach($tags as $id=>$tag){
        $tag = trim($tag);
        $tags[$id] = '<a href="'.href_to('tags', 'search').'?q='.urlencode($tag).'">'.$tag.'</a>';
    }

    $tags_bar = implode(', ', $tags);

    return $tags_bar;

}
