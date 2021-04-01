<?php 


class Statuses {
        private $_httpStatusCode;
        private $_messages = [];
        private $_responseData = [];
        private $_data;

        public function setHttpStatusCode($httpstatuscode){
            //Using status codes from httpsstatuscode.com
            $this->_httpStatusCode = $httpstatuscode;
        }

        public function addMessage($message){
            $this->_messages[] = $message;

            //this is the message that goes in the error codes
        }

        public function setData($data){
            $this->_data = $data;
        }

        public function send(){
            
            header('Content-type: application/json;charset=utf-8');

                http_response_code($this->_httpStatusCode);
                $this->_responseData['statusCode'] = $this->_httpStatusCode;
                $this->_responseData['messages'] = $this->_messages;
                $this->_responseData['data'] = $this->_data;

            echo json_encode($this->_responseData);
        }
    }