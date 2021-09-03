<?php

class Response
{    
   static public function send($status = 200, $data = null) {
        $send = ['status' => $status];
        if(!empty($data)) {
            $send['data'] = $data;
        }
        echo json_encode($send);exit;
   }
}
