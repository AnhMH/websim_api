<?php

use Fuel\Core\DB;

/**
 * Any query in Model Version
 *
 * @package Model
 * @created 2017-10-29
 * @version 1.0
 * @author AnhMH
 */
class Model_Order_Product extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'order_id',
        'product_id'
    );

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
    protected static $_table_name = 'order_products';

    /**
     * Add update info
     *
     * @author AnhMH
     * @param array $param Input data
     * @return int|bool User ID or false if error
     */
    public static function add_update($param)
    {
        $data = array();
        foreach ($param['product_ids'] as $v) {
            $data[] = array(
                'order_id' => $param['order_id'],
                'product_id' => Lib\Str::getNumber($v)
            );
        }
        self::batchInsert(self::$_table_name, $data);
        return true;
    }
    
    /**
     * Get all
     *
     * @author AnhMH
     * @param array $param Input data
     * @return array|bool
     */
    public static function get_all($param)
    {
        // Query
        $query = DB::select(
                self::$_table_name.'.*',
                array('products.name', 'product_name'),
                array('products.image', 'product_image'),
                array('products.price', 'product_price')
            )
            ->from(self::$_table_name)
            ->join('products', 'LEFT')
            ->on(self::$_table_name.'.product_id', '=', 'products.id')
        ;
        
        if (!empty($param['order_id'])) {
            $query->where('order_id', $param['order_id']);
        }
        
        // Pagination
        if (!empty($param['page']) && $param['limit']) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        
        // Get data
        $data = $query->execute()->as_array();
        
        return $data;
    }
}
