<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Orders extends \Controller_App {
    /**
     * Add/update info
     */
    public function action_addupdate() {
        return \Bus\Orders_AddUpdate::getInstance()->execute();
    }
    
    /**
     * Get list
     */
    public function action_list() {
        return \Bus\Orders_List::getInstance()->execute();
    }
    
    /**
     * Get detail
     */
    public function action_detail() {
        return \Bus\Orders_Detail::getInstance()->execute();
    }
}