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
class News_Disable extends BusAbstract
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
     * Call function disable() from model New
     *
     * @author AnhMH
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_New::disable($data);
            return $this->result(\Model_New::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
