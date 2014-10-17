<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_retriever extends CI_Controller
{

    public function index()
    {

    }

    public function createCustomer(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->createCustomer($input_data);
        if($result == true)
            $this->output->set_output(json_encode(array("statusMsg" => "success","data" => "customer created successfully ")));
        else
            $this->output->set_output(json_encode(array("statusMsg" => "fail","data" => "customer already exists")));
    }

    public function getSimilar(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getSimilar($input_data["tp"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => $result)));

    }

    public function getCustomer(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getCustomer($input_data["tp"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success" , "data" => $result )));

    }

    public function updateCustomer(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->updateCustomer($input_data["tp"],$input_data["data"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));

    }

    public function addBooking(){
        $statusMsg = 'success';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $input_data["data"]["refId"]=$this->ref_dao->getRefId();
        /* set the timezone for the call time */
        $callDT = new DateTime(date('Y-m-d'). ''.date('H:i:s'), new DateTimeZone('UTC'));
        $callTS = $callDT->getTimestamp();
        $input_data["data"]["callTime"]=new MongoDate($callTS);

        /* set the timezone for the call time */
        $bookDT = new DateTime(date($input_data["data"]["bDate"]). ''.date($input_data["data"]['bTime']), new DateTimeZone('UTC'));
        $bookTS = $bookDT->getTimestamp();
        $input_data["data"]["bookTime"]=new MongoDate($bookTS);

        /* Unset the values of bDate and bTime */
        unset($input_data['data']['bTime']);
        unset($input_data['data']['bDate']);

        /* Add the booking array to the customer collection */
        $result = $this->customer_dao->addBooking($input_data["tp"],$input_data["data"]);

        /* If customer collection insertion successful insert to live collection */
        if($result) {
            $input_data["data"]["tp"] = $input_data["tp"];
            $this->live_dao->createBooking($input_data["data"]);
        }
        else $statusMsg = 'fail';

        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg)));

    }

    public function canceled(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getStatus($input_data["tp"] , $input_data["refId"]);

        if($result == ("onDaWay") || $result ==("msgCopied") || $result ==("atDaPlace") || $result ==("pob")) {

            $this->customer_dao->addCanceledDispatch($input_data["tp"]);
            $this->customer_dao->addCanceledTotal($input_data["tp"]);
            $this->customer_dao->updateStatus($input_data["tp"], $input_data["refId"], "cancelDis");

        }else{
            $this->customer_dao->updateStatus($input_data["tp"], $input_data["refId"], "cancel");
        }

        /* Adds +1 to the tot_cancel in customers collection */
        $this->customer_dao->addCanceledTotal($input_data["tp"]);
        /* Remove the record from live collection and add it to the history */
        $this->live_dao->deleteBooking($input_data["refId"]);
        /* Get the recent booking record from customers collection and add it to history collection */
        $data = $this->customer_dao->getBooking($input_data["tp"], $input_data["refId"]);

        /* add tp number for booking for easy access and add it to history collection */
        $data["tp"]=$input_data["tp"];
        $this->history_dao->createBooking($data);
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));
    }

    public function updateBooking(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->updateBooking($input_data["tp"],$input_data["refId"],$input_data["data"]);

        $this->live_dao->updateBooking($input_data["refId"] , $input_data["data"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));

    }

    public function updateFee(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->updateBooking($input_data["tp"],$input_data["refId"],$input_data["data"]);

        $this->live_dao->updateBooking($input_data["refId"] , $input_data["data"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));

    }

    public function addCanceledDispatch(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->addCanceledDispatch($input_data["tp"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));

    }

    public function addCanceledTotal(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->addCanceledTotal($input_data["tp"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));

    }

    public function getStatus(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getStatus($input_data["tp"] , $input_data["refId"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => $result  )));

    }

    public function getBooking(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getBooking($input_data["tp"] , $input_data["refId"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => $result  )));

    }

    public function addInquireCall(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->addInquireCall($input_data["tp"] , $input_data["refId"]);
        $this->live_dao->addInquireCall($input_data["refId"]);
        
        /* TODO INFORM THROUGH WEB SOCKETS CHANGE HAS HAPPENED */
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));
    }

}