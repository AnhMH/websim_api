<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Hotlines extends \Controller_App {
    /**
     * Add/update info
     */
    public function action_addupdate() {
        return \Bus\Hotlines_AddUpdate::getInstance()->execute();
    }
    
    /**
     * Get detail
     */
    public function action_detail() {
        return \Bus\Hotlines_Detail::getInstance()->execute();
    }
    
    /**
     * Get list
     */
    public function action_list() {
        return \Bus\Hotlines_List::getInstance()->execute();
    }
    
    /**
     * Enable/Diable
     */
    public function action_disable() {
        return \Bus\Hotlines_Disable::getInstance()->execute();
    }
}