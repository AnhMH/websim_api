<?php

namespace Bus;

/**
 * Add/update info
 *
 * @package Bus
 * @created 2017-10-29
 * @version 1.0
 * @author AnhMH
 */
class Customers_AddUpdate extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'name' => array(1, 64),
        'email' => array(1, 50),
        'tel' => array(1, 20)
    );

    /** @var array $_email_format field email */
    protected $_email_format = array(
        'email'
    );

    /**
     * Call function add_update() from model Customer
     *
     * @author AnhMH
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Customer::add_update($data);
            return $this->result(\Model_Customer::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
