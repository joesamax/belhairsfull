<?php

if (!class_exists('WP_Customize_Control')) {
    return null;
}

class Mobile_Menu_Builder_Heading_Control extends WP_Customize_Control{

    public function render_content(){ ?>
        <h3 class="mobile-menu-builder-heading-control"><?php echo esc_html( $this->label ); ?></h3>
        <span class="description customize-control-description"><?php echo $this->description; ?></span>  
    <?php
    }
}
?>