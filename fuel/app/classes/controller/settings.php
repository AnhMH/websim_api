<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Settings extends \Controller_App {
    /**
     * Get general data
     */
    public function action_general() {
        return \Bus\Settings_General::getInstance()->execute();
    }
}