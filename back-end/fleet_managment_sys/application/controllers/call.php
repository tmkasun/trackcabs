<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Call extends CI_Controller
{

    public function index()
    {

    }


    function getLiveCalls()
    {

        $calls = $this->call_dao->getLiveCalls();
        $this->output->set_output(json_encode($calls));

    }

    function pabxData()
    {
        $postData = $this->input->post();
        $state = array_keys($postData)[0];

        $today = date("Y-m-d h:ia");

        $csvCallArray = str_getcsv($postData[$state]);
//        var_dump($csvCallArray);

        $callInfo = array(
            "state" => $state,
            "phone_number" => trim($csvCallArray[7]),
            "date" => new MongoDate(strtotime($today)),
            "parameter1" => $csvCallArray[2],
            "extension_number" => trim($csvCallArray[6]),
            "raw_data" => $postData[$state]
        );

        $webSocket = new Websocket('localhost', '5555', 'pabx');
        $webSocket->send($callInfo, 'cro1');

        $this->call_dao->createCall($callInfo);


    }

    function getCallsInLastSeconds(){

        $calls = $this->call_dao->getCallsInLastSeconds();
        $this->output->set_output(json_encode($calls));

    }
}