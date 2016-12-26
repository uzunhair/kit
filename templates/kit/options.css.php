<?php

    $header_nav_class = $this->options['header_nav_class'];

    $body_padding = array();
    $navbar_fixed_top = 'navbar-fixed-top';
    $navbar_fixed_bottom = 'navbar-fixed-bottom';

    if (strrpos($header_nav_class, $navbar_fixed_top)) {
        $body_padding_top = "padding-top: {$this->options['body_padding_top']}px;";
        $body_padding[] = $body_padding_top;
    }
    if (strrpos($header_nav_class, $navbar_fixed_bottom)) {
        $body_padding_bottom = "padding-bottom: {$this->options['body_padding_bottom']}px;";
        $body_padding[] = $body_padding_bottom;
    }
    $body_padding = implode(' ', $body_padding);
    
    $header_nav_width = $this->options['header_nav_width'];

    $btn_class = $this->options['btn_class'];

?>


<?php if (!empty($this->options['logo'])){ ?>
#layout header #logo a {
    background-image: url("<?php echo $config->upload_root . $this->options['logo']['original']; ?>") !important;
}
<?php } ?>