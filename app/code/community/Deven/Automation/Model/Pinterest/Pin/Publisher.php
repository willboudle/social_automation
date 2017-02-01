<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/6/2015
 * Time: 9:11 PM
 */

class Deven_Automation_Model_Pinterest_Pin_Publisher extends Deven_Automation_Model_Pinterest_Client {

    public function pinOnBoards($boards, $message, $url, $image)
    {
        foreach($boards as $board) {
            $this->api('/pins/'
                , 'POST',
                array(
                    'board' => $board,
                    'note' => $message,
                    'link' => $url,
                    'image_url' => $image
                ));
        }
    }

} 