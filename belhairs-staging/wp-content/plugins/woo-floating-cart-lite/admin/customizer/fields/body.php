<?php

$fields[] = array(
    'id'      => 'list_features',
    'section' => 'body',
    'type'    => 'xt-premium',
    'default' => array(
    'type'  => 'image',
    'value' => $this->core->plugin_url() . 'admin/customizer/assets/images/body.png',
    'link'  => $this->core->plugin_upgrade_url(),
),
);