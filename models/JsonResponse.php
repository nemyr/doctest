<?php


namespace app\models;


class JsonResponse
{
    private $error;
    private $message;
    private $data;

    /**
     * JsonResponse constructor.
     * @param int $error
     * @param string $message
     * @param array $data
     */
    public function __construct(int $error = 0, string $message = "", array $data = [])
    {
        $this->error = $error;
        $this->message = $message;
        $this->data = $data;
    }

    public function setError($error){
        $this->error = $error;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function setData(array $data){
        $this->data = $data;
    }

    public function getJson(){
        return json_encode([
            'error' => $this->error,
            'message' => $this->message,
            'data' => $this->data
        ]);
    }
}