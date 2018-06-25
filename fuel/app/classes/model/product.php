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
class Model_Product extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'name',
        'image',
        'description',
        'detail',
        'agent_price',
        'price',
        'cate_id',
        'supplier_id',
        'count_num',
        'sum_num',
        'sum_last_num',
        'created',
        'updated'
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
    protected static $_table_name = 'products';

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
        $id = !empty($param['id']) ? $param['id'] : '';
        
        // Check if exist User
        if (!empty($id)) {
            $self = self::find($id);
            if (empty($self)) {
                $self = new self;
            } else {
                $isNew = false;
            }
        } else {
            $self = new self;
        }
        
        // Upload image
        if (!empty($_FILES)) {
            $uploadResult = \Lib\Util::uploadImage(); 
            if ($uploadResult['status'] != 200) {
                self::setError($uploadResult['error']);
                return false;
            }
            $param['image'] = !empty($uploadResult['body']['image']) ? $uploadResult['body']['image'] : '';
        }
        
        // Set data
        $self->set('id', $id);
        $self->set('count_num', strlen($id));
        $sumNum = array_sum(str_split($id));
        $self->set('sum_num', $sumNum);
        $self->set('sum_last_num', substr($sumNum, -1));
        if (!empty($param['name'])) {
            $self->set('name', $param['name']);
        }
        if (!empty($param['cate_id'])) {
            $self->set('cate_id', $param['cate_id']);
        }
        if (!empty($param['supplier_id'])) {
            $self->set('supplier_id', $param['supplier_id']);
        }
        if (!empty($param['description'])) {
            $self->set('description', $param['description']);
        }
        if (!empty($param['detail'])) {
            $self->set('detail', $param['detail']);
        }
        if (!empty($param['image'])) {
            $self->set('image', $param['image']);
        }
        if (!empty($param['agent_price'])) {
            $self->set('agent_price', $param['agent_price']);
        }
        if (!empty($param['price'])) {
            $self->set('price', $param['price']);
        }
        
        // Save data
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            
            if (!empty($param['old_id']) && $isNew) {
                \DB::delete(self::$_table_name)->where('id', $param['old_id'])->execute();
            }
            
            // Reset tag
            \DB::delete('product_tags')->where('product_id', $self->id)->execute();
            if (!empty($param['tag_id'])) {
                $tagIds = explode(',', $param['tag_id']);
                $productTags = array();
                foreach ($tagIds as $v) {
                    $productTags[] = array(
                        'product_id' => $self->id,
                        'tag_id' => $v
                    );
                }
                self::batchInsert('product_tags', $productTags);
            }
            return $self->id;
        }
        
        return false;
    }
    
    /**
     * Get list
     *
     * @author AnhMH
     * @param array $param Input data
     * @return array|bool
     */
    public static function get_list($param)
    {
        // Query
        $query = DB::select(
                self::$_table_name.'.*',
                array('cates.name', 'cate_name')
            )
            ->from(self::$_table_name)
            ->join('cates')
            ->on('cates.id', '=', self::$_table_name.'.cate_id')
        ;
        
        // Filter
        if (!empty($param['cate_id'])) {
            $query->where(self::$_table_name . '.cate_id', $param['cate_id']);
        }
        if (!empty($param['price_from'])) {
            $query->where(self::$_table_name . '.price', '>=', $param['price_from']);
        }
        if (!empty($param['price_to'])) {
            $query->where(self::$_table_name . '.price', '<=', $param['price_to']);
        }
        if (!empty($param['sim'])) {
            $arr1 = array(
                '*', 'x'
            );
            $arr2 = array(
                '[0-9]+', '[0-9]'
            );
            $param['sim'] = str_replace($arr1, $arr2, $param['sim']);
            $query->where(DB::expr(self::$_table_name . ".id REGEXP '{$param['sim']}'"));
        }
        if (!empty($param['n'])) {
            if (!is_array($param['n'])) {
                $param['n'] = json_decode($param['n'], true);
            }
            foreach ($param['n'] as $n) {
                $query->where(self::$_table_name . '.id', 'NOT LIKE', "%{$n}%");
            }
        }
        if (!empty($param['sub_cate'])) {
            $query->where(self::$_table_name . '.id', 'LIKE', "{$param['sub_cate']}%");
        }
        if (!empty($param['tag_id'])) {
            $query->join('product_tags')
                    ->on(self::$_table_name . '.id', '=', 'product_tags.product_id');
            $query->where('product_tags.tag_id', $param['tag_id']);
        }
        if (!empty($param['tongdiem'])) {
            $query->where(self::$_table_name . '.sum_num', $param['tongdiem']);
        }
        if (!empty($param['tongnut'])) {
            $query->where(self::$_table_name . '.sum_last_num', $param['tongnut']);
        }
        if (!empty($param['date']) && preg_match("/^([1-9]|0[1-9]|[1-2][0-9]|3[0-1])\/([1-9]|0[1-9]|1[0-2])\/[0-9]{4}$/", $param['date'])) {
            $query->where_open();
            if (isset($param['dtp']) && ($param['dtp'] == 0 || $param['dtp'] == 2)) {
                $query->where(DB::expr("RIGHT(".self::$_table_name . ".id, 4)"), date('jny', strtotime($param['date'])));
                $query->or_where(DB::expr("RIGHT(".self::$_table_name . ".id, 6)"), date('dmy', strtotime($param['date'])));
            }
            if (isset($param['dtp']) && ($param['dtp'] == 0 || $param['dtp'] == 1)) {
                $query->or_where(DB::expr("RIGHT(".self::$_table_name . ".id, 4)"), date('Y', strtotime($param['date'])));
            }
            $query->where_close();
        }
        
        // Pagination
        if (!empty($param['page']) && $param['limit']) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        
        // Sort
        if (!empty($param['sort'])) {
            if (!self::checkSort($param['sort'])) {
                self::errorParamInvalid('sort');
                return false;
            }

            $sortExplode = explode('-', $param['sort']);
            if ($sortExplode[0] == 'created') {
                $sortExplode[0] = self::$_table_name . '.created';
            }
            $query->order_by($sortExplode[0], $sortExplode[1]);
        } else {
            $query->order_by(self::$_table_name . '.created', 'DESC');
        }
        
        // Get data
        $data = $query->execute()->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        
        return array(
            'total' => $total,
            'data' => $data
        );
    }
    
    /**
     * Get detail
     *
     * @author AnhMH
     * @param array $param Input data
     * @return array|bool
     */
    public static function get_detail($param)
    {
        $id = !empty($param['id']) ? $param['id'] : '';
        
        $data = self::find($id);
        if (empty($data)) {
            self::errorNotExist('product_id');
            return false;
        }
        $data['tag_id'] = Lib\Arr::field(Model_Product_Tag::get_all(array(
            'product_id' => $id
        )), 'tag_id');
        return $data;
    }
    
    /**
     * Enable/Disable
     *
     * @author AnhMH
     * @param array $param Input data
     * @return int|bool User ID or false if error
     */
    public static function disable($param)
    {
        $ids = !empty($param['id']) ? $param['id'] : '';
        $disable = !empty($param['disable']) ? $param['disable'] : 0;
        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }
        \DB::delete(self::$_table_name)->where('id', 'IN', $ids)->execute();
        return true;
    }
}
