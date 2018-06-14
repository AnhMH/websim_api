<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Pages extends \Controller_App {
    /**
     * Add/update info
     */
    public function action_addupdate() {
        return \Bus\Pages_AddUpdate::getInstance()->execute();
    }
    
    /**
     * Get detail
     */
    public function action_detail() {
        return \Bus\Pages_Detail::getInstance()->execute();
    }
    
    /**
     * Get list
     */
    public function action_list() {
        return \Bus\Pages_List::getInstance()->execute();
    }
    
    /**
     * Get list
     */
    public function action_all() {
        return \Bus\Pages_All::getInstance()->execute();
    }
    
    /**
     * Enable/Diable
     */
    public function action_disable() {
        return \Bus\Pages_Disable::getInstance()->execute();
    }
}