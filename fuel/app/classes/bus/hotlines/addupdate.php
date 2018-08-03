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
class Hotlines_AddUpdate extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        
    );

    /**
     * Call function add_update() from model Hotline
     *
     * @author AnhMH
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Hotline::add_update($data);
            return $this->result(\Model_Hotline::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
