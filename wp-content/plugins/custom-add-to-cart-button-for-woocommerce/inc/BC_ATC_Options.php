<?php
/**
 * Created by PhpStorm.
 * User: myn
 * Date: 1/8/19
 * Time: 11:44 PM
 */
namespace BinaryCarpenter\BC_ATC;
use \BinaryCarpenter\BC_ATC\Config as Config;
class BC_ATC_Options
{
    public static function get_options()
    {
        $options = array();

        parse_str(get_option(Config::BC_ULTIMATE_ATC_BUTTON_OPTIONS, ""), $options);

        if (isset($options['options']))
            $options = $options['options'];

        return $options;
    }



    public static function bc_atc_get_option($options, $name)
    {
        if ($name == 'subtractImage' && (!isset($options['subtractImage']) || $options['subtractImage'] == '') )
        {
            return plugins_url('../bundle/css/images/subtract.png', __FILE__);
        }
        if ($name == 'addImage' && (!isset($options['addImage']) || $options['addImage'] == ''  ))
        {
            return plugins_url('../bundle/css/images/add.png', __FILE__);
        }

        return isset($options[$name]) ? ($options[$name]) : '';
    }
}