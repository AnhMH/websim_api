<?php

use Fuel\Core\DB;

/**
 * Any query in Model Setting
 *
 * @package Model
 * @created 2017-07-03
 * @version 1.0
 * @author AnhMH
 * @copyright Oceanize INC
 */
class Model_Setting extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array();

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events'          => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events'          => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );

    /** @var array $_table_name name of table */
    protected static $_table_name = '';
    
    /**
     * Get general data
     * @param type $param
     * @return boolean
     */
    public static function get_general_data($param) {
        // Init
        $data = array();
        
        // Get categories
        $data['cates'] = Model_Cate::get_all(array());
        
        // Get tags
        $data['tags'] = Model_Tag::get_all(array());
        
        // Get sub cate
        $data['sub_cates'] = Model_Sub_Cate::get_all(array());
        
        // Get main menu
        $data['main_menu'] = Model_Page::get_all(array(
            'is_main_menu' => 1
        ));
        
        // Get footer menu
        $data['footer_menu'] = Model_Page::get_all(array(
            'is_footer_menu' => 1
        ));
        
        // Get news
        $data['news'] = Model_New::get_all(array(
            'page' => 1,
            'limit' => 10
        ));
        
        // Get address
        if (!empty($param['get_address'])) {
            $data['provinces'] = Model_Province::get_all(array());
        }
        
        // Get hotlines
        $data['hotlines'] = Model_Hotline::get_all(array());
        
        // Get admin setting
        $data['admin'] = Model_Admin::get_master_info(array());
        
        return $data;
    }
    
    /**
     * Get general data
     * @param type $param
     * @return boolean
     */
    public static function get_address_data($param) {
        // Init
        $data = array();
        
        if (!empty($param['type'])) {
            if ($param['type'] == 'district') {
                $data = Model_District::get_all($param);
            } else {
                $data = Model_Ward::get_all($param);
            }
        }
        
        return $data;
    }
}
