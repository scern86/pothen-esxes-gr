<?php

namespace PothenEsxes;

use GuzzleHttp\Client;

use PothenEsxes\Messages\Messages;
use PothenEsxes\AuditRecord;
class PothenEsxes{
    const TEST_ENDPOINT = 'https://test.gsis.gr/esbpilot/pothenDataRestService/';
    const PROD_ENDPOINT = 'https://ked.gsis.gr/esb/pothenDataRestService/';
    private string $currentEndpoint;

    /* Responses for sendPothenAithma from XO-PI */
    const XO_PI_STATUS_0_SUCCESS = 0; /*return-data*/
    const XO_PI_STATUS_1_ALREADY_RECEIVED = 1; /*return-data*/
    const XO_PI_STATUS_3_DONE = 3;
    const XO_PI_STATUS_9_NOT_FOUND = 9;
    const XO_PI_STATUS_10_INVALID_DATA = 10;
    const XO_PI_STATUS_90_TEMPORARY_UNAVAILABLE = 90;
    const XO_PI_STATUS_99_SERVER_ERROR = 99;

    /*Responses for getPothenData from KED*/
    const KED_STATUS_0_SUCCESS = 0;
    const KED_STATUS_1_ALREADY_RECEIVED = 1;
    const KED_STATUS_2_REQUEST_NOT_FOUND = 2;
    const KED_STATUS_3_ENCRYPTION_ERROR = 3;
    const KED_STATUS_4_INVALID_DATA = 4;
    const KED_STATUS_99_SERVER_ERROR = 99;

    public function __construct(protected Security $security,protected Messages $messages,bool $testMode=false){
        $this->currentEndpoint = $testMode ? self::TEST_ENDPOINT : self::PROD_ENDPOINT;
    }


    /* Receive request from PothenEsxes */
    /*public function getPothenAithma(): array
    {
        return [1,2,3];
    }*/

    /* Answer to PothenEsxes */
    public function responsePothenAithma(int $code): array
    {
        if(in_array($code,[self::XO_PI_STATUS_0_SUCCESS,self::XO_PI_STATUS_1_ALREADY_RECEIVED])){
            $replyDate = ['replyDate'=>date('Y-m-d')]; /* +1 workday 17:00 */
        }
        $outputRecord = $this->_createOutputRecord($code,$replyDate);

        $result = [
            'sendPothenAithmaOutputRecord'=>$outputRecord,
            'callSequenceId'=>time(),
            'callSequenceDate'=>gmdate("Y-m-d\TH:i:s\Z"), /*ISO 8601*/
            'errorRecord'=>$this->_createErrorRecord(),
        ];

        return $result;
    }

    private function _createOutputRecord(int $code,array $data=[]): array
    {
        return [
            'code'=>strval($code),
            'message'=>$this->messages->getMessageByCode($code),
            ...$data,
        ];
    }

    private function _createErrorRecord(array $data=[]): array
    {
        return [];
        /*return [
            'errorCode'=>'GEN_COMMUNICATION_ERROR',
            'errorDescr'=>'string'
        ];*/
    }


    /*Get encryption information to send a response*/
    public function getEncryptionInfo(AuditRecord $auditRecord): object
    {
        $client = new Client(
            [
                'base_uri' => $this->currentEndpoint,
                'verify' => true,
                'curl' => [
                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                ],
            ]
        );


        $headers = $this->_createHeaders();

        $data = [
            "auditRecord" => (array) $auditRecord,
            "getEncryptionInfoInputRecord"=>[]
        ];

        $body = json_encode($data,JSON_FORCE_OBJECT);

        $response = $client->request(
            'POST',
            'getEncryptionInfo',
            [
                'headers' => $headers,
                'body' => $body
            ]
        );

        return $response;
    }

    /* Send response data from XO-PI to ked../getPothenData */
    public function sendPothenData()
    {
        return 'SendPothenData';
    }

    private function _createHeaders(array $headers=[]): array
    {
        return [
            "Content-type: application/json; charset=utf-8",
            $this->security->authorization->createAuthorizationHeader(),
            ...$headers
        ];
    }
}