<?php if (!empty($this->options['logo'])){ ?>
#layout header #logo a {
    background-image: url("<?php echo $config->upload_root . $this->options['logo']['original']; ?>") !important;
}
<?php } ?>