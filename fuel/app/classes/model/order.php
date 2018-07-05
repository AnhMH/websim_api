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
class Model_Order extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'name',
        'address',
        'ward',
        'district',
        'province',
        'phone',
        'note',
        'total_price'
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
    protected static $_table_name = 'orders';

    /**
     * Add update info
     *
     * @author AnhMH
     * @param array $param Input data
     * @return int|bool User ID or false if error
     */
    public static function add_update($param)
    {
        $self = array();
        $isNew = true;
        $products = array();
        $productIds = array();
        $productData = array();
        $totalPrice = 0;
        $id = !empty($param['id']) ? $param['id'] : '';
        
        // Check if exist User
        if (!empty($id)) {
            $isNew = false;
            $self = self::find($id);
            if (empty($self)) {
                self::errorNotExist('order_id');
                return false;
            }
        } else {
            $self = new self;
        }
        
        // Set data
        if (!empty($param['fullname'])) {
            $self->set('name', $param['fullname']);
        }
        if (!empty($param['address'])) {
            $self->set('address', $param['address']);
        }
        if (!empty($param['ward'])) {
            $self->set('ward', $param['ward']);
        }
        if (!empty($param['district'])) {
            $self->set('district', $param['district']);
        }
        if (!empty($param['city'])) {
            $self->set('province', $param['city']);
        }
        if (!empty($param['phone'])) {
            $self->set('phone', $param['phone']);
        }
        if (!empty($param['note'])) {
            $self->set('note', $param['note']);
        }
        if (!empty($param['products'])) {
            $products = json_decode($param['products'], true);
            foreach ($products as $k => $v) {
                $productIds[] = $k;
            }
            $productData = Model_Product::find('all', array(
                'where' => array(
                    array('name', 'IN', $productIds)
                )
            ));
            if (!empty($productData)) {
                foreach ($productData as $v) {
                    $totalPrice += $v['price'];
                }
            }
        }
        
        $self->set('total_price', $totalPrice);
        
        // Save data
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            // Reset order products
            \DB::delete('order_products')->where('order_id', $self->id)->execute();
            if (!empty($productIds)) {
                Model_Order_Product::add_update(array(
                    'product_ids' => $productIds,
                    'order_id' => $self->id,
                ));
            }
            return $self->id;
        }
        
        return false;
    }
}
