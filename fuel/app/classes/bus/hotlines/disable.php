<?php

namespace Bus;

/**
 * Enable/Disable
 *
 * @package Bus
 * @created 2017-10-29
 * @version 1.0
 * @author AnhMH
 */
class Hotlines_Disable extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'id',
        'disable'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        
    );

    /** @var array $_email_format field email */
    protected $_email_format = array(
        
    );

    /**
     * Call function disable() from model Hotline
     *
     * @author AnhMH
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Hotline::disable($data);
            return $this->result(\Model_Hotline::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
