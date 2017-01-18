<?php $core = cmsCore::getInstance(); ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php $this->title(); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?php $this->addMainCSS("templates/{$this->name}/css/system.css"); ?>
    <?php $this->addMainCSS("templates/{$this->name}/css/theme.css"); ?>
    <?php $this->addMainCSS("templates/{$this->name}/css/gray.css"); ?>
    <?php $this->addMainCSS("templates/{$this->name}/css/example.css"); ?>
    <?php $this->addMainJS("templates/{$this->name}/js/jquery.js"); ?>
    <?php $this->addMainJS("templates/{$this->name}/js/jquery-modal.js"); ?>
    <?php $this->addMainJS("templates/{$this->name}/js/core.js"); ?>
    <?php $this->addMainJS("templates/{$this->name}/js/modal.js"); ?>
    <?php if (cmsUser::isLogged()){ ?>
        <?php $this->addMainJS("templates/{$this->name}/js/messages.js"); ?>
    <?php } ?>
    <?php $this->addMainJS("templates/{$this->name}/addons/tether/tether.min.js"); ?>
    <?php $this->addMainJS("templates/{$this->name}/addons/bootstrap/bootstrap.min.js"); ?>
    <?php $this->addMainJS("templates/{$this->name}/addons/setting.js"); ?>
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    <script>
        function loadFont(a, b, c, d) {
            function e() {
                if (!window.FontFace) return !1;
                var a = new FontFace("t", 'url("data:application/font-woff2,") format("woff2")', {}),
                    b = a.load();
                try {
                    b.then(null, function () {
                    })
                } catch (c) {
                }
                return "loading" === a.status
            }

            var f = navigator.userAgent,
                g = !window.addEventListener || f.match(/(Android (2|3|4.0|4.1|4.2|4.3))|(Opera (Mini|Mobi))/) && !f.match(/Chrome/);
            if (!g) {
                var h = {};
                try {
                    h = localStorage || {}
                } catch (i) {
                }
                var j = "x-font-" + a,
                    k = j + "url",
                    l = j + "css",
                    m = h[k],
                    n = h[l],
                    o = document.createElement("style");
                if (o.rel = "stylesheet", document.head.appendChild(o), !n || m !== b && m !== c) {
                    var p = c && e() ? c : b,
                        q = new XMLHttpRequest;
                    q.open("GET", p), q.onload = function () {
                        q.status >= 200 && q.status < 400 && (h[k] = p, h[l] = q.responseText, d || (o.textContent = q.responseText))
                    }, q.send()
                } else o.textContent = n
            }
        }
        ;
    </script>
    <script>loadFont('Roboto', '/templates/<?php echo $this->name; ?>/fonts/roboto.css', '/templates/<?php echo $this->name; ?>/fonts/roboto_woff2.css'); </script>
    <?php $this->head(); ?>
    <style><?php include('options.css.php'); ?></style>
</head>

<body id="<?php echo $device_type; ?>_device_type" <?php if($body_padding) {?>style="<?php echo $body_padding; ?>"<?php } ?>>
    <div id="layout">
        <header>
            <?php if($this->hasWidgetsOn('top')) { ?>
                <?php if ($header_nav_width) { ?>
                    <div id="widget_pos_top" class="container">
                <?php } ?>
                <nav class="<?php echo $header_nav_class; ?> navbar-toggleable-md">
                    <?php if (!$header_nav_width) { ?><div id="widget_pos_top" class="container"><?php } ?>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                            <?php $this->widgets('top'); ?>
                        </div>
                    <?php if (!$header_nav_width) { ?></div><?php } ?>
                </nav>
                <?php if ($header_nav_width) { ?>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="container">
                <div id="logo">
                    <?php if($core->uri) { ?>
                        <a href="<?php echo href_to_home(); ?>"></a>
                    <?php } else { ?>
                        <span></span>
                    <?php } ?>
                </div>
            </div>
        </header>

        <div class="container">

            <div class="widget_ajax_wrap" id="widget_pos_header"><?php $this->widgets('header', false, 'wrapper_plain'); ?></div>



        <div id="body" class="row">

            <?php
                $is_sidebar = $this->hasWidgetsOn('right-top', 'right-center', 'right-bottom');
                $section_width = $is_sidebar ? 'col-9' : 'col-12';
            ?>

            <section class="<?php echo $section_width; ?> section-content">
                <?php if ($config->show_breadcrumbs && $this->isBreadcrumbs()){ ?>
                    <div id="breadcrumbs">
                        <?php $this->breadcrumbs(array('strip_last'=>false)); ?>
                    </div>
                <?php } ?>
                
                <?php
                $messages = cmsUser::getSessionMessages();
                if ($messages){
                    ?>
                    <div class="alert alert-info alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php
                        foreach($messages as $message){
                            echo $message;
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <div class="widget_ajax_wrap" id="widget_pos_left-top"><?php $this->widgets('left-top'); ?></div>

                <?php if ($this->isBody()){ ?>
                    <article>
                        <div id="controller_wrap"><?php $this->body(); ?></div>
                    </article>
                <?php } ?>

                <div class="widget_ajax_wrap" id="widget_pos_left-bottom"><?php $this->widgets('left-bottom'); ?></div>

            </section>

            <?php if($is_sidebar){ ?>
                <aside class="col-3">
                    <div class="widget_ajax_wrap" id="widget_pos_right-top"><?php $this->widgets('right-top'); ?></div>
                    <div class="widget_ajax_wrap" id="widget_pos_right-center"><?php $this->widgets('right-center'); ?></div>
                    <div class="widget_ajax_wrap" id="widget_pos_right-bottom"><?php $this->widgets('right-bottom'); ?></div>
                </aside>
            <?php } ?>

        </div>

        <?php if ($config->debug && cmsUser::isAdmin()){ ?>
            <div id="sql_debug" style="display:none">
                <div id="sql_queries">
                    <div id="sql_stat"><?php echo $core->db->getStat(); ?></div>
                    <?php foreach($core->db->query_list as $sql) { ?>
                        <div class="query">
                            <div class="src"><?php echo $sql['src']; ?></div>
                            <?php echo nl2br(htmlspecialchars($sql['sql'])); ?>
                            <div class="query_time"><?php echo LANG_DEBUG_QUERY_TIME; ?> <span class="<?php echo (($sql['time']>=0.1) ? 'red_query' : 'green_query'); ?>"><?php echo number_format($sql['time'], 5); ?></span> <?php echo LANG_SECOND10 ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        </div>
        <footer class="mt-2">
            <div class="navbar navbar-light bg-faded">
                <div class="container navbar-toggleable-md">
                    <ul class="nav navbar-nav">
                        <li class="nav-item" id="copyright">
                            <a class="nav-link" href="<?php echo $this->options['owner_url'] ? $this->options['owner_url'] : href_to_home(); ?>">
                                <?php html($this->options['owner_name'] ? $this->options['owner_name'] : cmsConfig::get('sitename')); ?>
                                &copy;
                                <?php echo $this->options['owner_year'] ? $this->options['owner_year'] : date('Y'); ?>
                            </a>
                        </li>
                        <li class="nav-item" id="info">
                            <span class="item navbar-text">
                                <?php echo LANG_POWERED_BY_INSTANTCMS; ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="item navbar-text">
                                <?php echo LANG_ICONS_BY_FONTAWESOME; ?>
                            </span>
                        </li>
                            <?php if ($config->debug && cmsUser::isAdmin()){ ?>
                                <li class="nav-item">
                                <span class="item navbar-text">
                                    SQL: <a href="#sql_debug" title="SQL dump" class="ajax-modal"><?php echo $core->db->query_count; ?></a>
                                </span>
                                <?php if ($config->cache_enabled){ ?>
                                    <span class="item navbar-text">
                                        Cache: <a href="<?php echo href_to('admin', 'cache_delete', $config->cache_method);?>" title="Clear cache"><?php echo cmsCache::getInstance()->query_count; ?></a>
                                    </span>
                                <?php } ?>
                                <span class="item navbar-text">
                                    Mem: <?php echo round(memory_get_usage()/1024/1024, 2); ?> Mb
                                </span>
                                <span class="item navbar-text">
                                    Time: <?php echo number_format(cmsCore::getTime(), 4); ?> s
                                </span>
                                </li>
                            <?php } ?>
                        <li class="nav-item float-lg-right" id="nav">
                            <?php $this->widgets('footer', false, 'wrapper_plain'); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
        <?php if (!$config->is_site_on){ ?>
            <div id="site_off_notice"><?php printf(ERR_SITE_OFFLINE_FULL, href_to('admin', 'settings', 'siteon')); ?></div>
        <?php } ?>
</body>
</html>
