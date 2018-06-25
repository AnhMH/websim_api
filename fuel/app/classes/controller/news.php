<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_News extends \Controller_App {
    /**
     * Add/update info
     */
    public function action_addupdate() {
        return \Bus\News_AddUpdate::getInstance()->execute();
    }
    
    /**
     * Get detail
     */
    public function action_detail() {
        return \Bus\News_Detail::getInstance()->execute();
    }
    
    /**
     * Get list
     */
    public function action_list() {
        return \Bus\News_List::getInstance()->execute();
    }
    
    /**
     * Enable/Diable
     */
    public function action_disable() {
        return \Bus\News_Disable::getInstance()->execute();
    }
}