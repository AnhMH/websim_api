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
        
        return $data;
    }
}