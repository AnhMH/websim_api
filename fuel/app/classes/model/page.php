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
class Model_Page extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'name',
        'content',
        'is_main_menu',
        'footer_menu_type',
        'order',
        'url'
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
    protected static $_table_name = 'pages';

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
        
        // Check if exist User
        if (!empty($param['id'])) {
            $self = self::find($param['id']);
            if (empty($self)) {
                self::errorNotExist('page_id');
            }
        } else {
            $self = new self;
        }
        
        // Set data
        if (!empty($param['name'])) {
            $self->set('name', $param['name']);
            $self->set('url', Lib\Str::convertURL($param['name']));
        }
        if (!empty($param['content'])) {
            $self->set('content', $param['content']);
        }
        if (!empty($param['order'])) {
            $self->set('order', $param['order']);
        }
        if (isset($param['is_main_menu']) && $param['is_main_menu'] != '') {
            $self->set('is_main_menu', $param['is_main_menu']);
        }
        if (!empty($param['footer_menu_type'])) {
            $self->set('footer_menu_type', $param['footer_menu_type']);
        }
        
        // Save data
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
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
                self::$_table_name.'.*'
            )
            ->from(self::$_table_name)
        ;
        
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
            $query->order_by(self::$_table_name . '.id', 'DESC');
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
                self::$_table_name.'.*'
            )
            ->from(self::$_table_name)
        ;
        
        // Filter
        if (isset($param['is_main_menu']) && $param['is_main_menu'] != '') {
            $query->where(self::$_table_name . '.is_main_menu', $param['is_main_menu']);
        }
        if (!empty($param['is_footer_menu'])) {
            $query->where(self::$_table_name . '.footer_menu_type', '!=', 0);
            $query->where(self::$_table_name . '.footer_menu_type', 'IS NOT', null);
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
            $query->order_by(self::$_table_name . '.order', 'ASC');
            $query->order_by(self::$_table_name . '.footer_menu_type', 'ASC');
        }
        
        // Get data
        $data = $query->execute()->as_array();
        
        return $data;
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
        $url = !empty($param['url']) ? $param['url'] : '';
        $data = array();
        
        if (!empty($id)) {
            $data = self::find($id);
        } elseif (!empty($url)) {
            $data = self::find('first', array(
                'where' => array(
                    'url' => $url
                )
            ));
        }
        
        if (empty($data)) {
            self::errorNotExist('page_id');
            return false;
        }
        
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
        foreach ($ids as $id) {
            $self = self::find($id);
            if (!empty($self)) {
                $self->set('disable', $disable);
                $self->save();
            }
        }
        return true;
    }
}
