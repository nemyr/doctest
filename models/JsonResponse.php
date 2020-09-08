<?php


namespace app\models;


class JsonResponse
{
    private $error = 0;
    private $message = "";
    private $data = [];

    /**
     * JsonResponse constructor.
     * @param int $error
     * @param string $message
     * @param array $data
     */
    public function __construct(int $error, string $message, array $data)
    {
        $this->error = $error;
        $this->message = $message;
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