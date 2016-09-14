<?php




class FbBotApp
{
    /**
     * Request type GET
     */
    const TYPE_GET = "get";
    
    /**
     * Request type POST
     */
    const TYPE_POST = "post";
    
    /**
     * FB Messenger API Url
     *
     * @var string
     */
    protected $apiUrl = 'https://graph.facebook.com/v2.6/';
    
    /**
     * BOT username
     *
     * @var string|null
     */
    protected $token = null;
    
    public function __construct($token)
    {
        $this->token = $token;
    }
    /**
     * Send Message
     *
     * @param Message $message
     * @return mixed
     */
    public function send($message)
    {
        return $this->call('me/messages', $message->getData());
    }

    /**
     * Get User Profile Info
     *
     * @param $id
     * @return array[first_name] First Name
     * @return array[last_name] Last Name
     * @return array[profile_pic] Profile Picture Url
     */
    public function userProfile($id)
    {
        return new UserProfile($this->call($id, [
            'fields' => 'first_name,last_name,profile_pic'
        ], self::TYPE_GET));
    }

    /**
     * Request to API
     *
     * @param $url Url
     * @param $data Data
     * @param string $type Type of request (GET|POST)
     * @return array
     */
    protected function call($url, $data, $type = self::TYPE_POST)
    {
        $data['recipient']['id'] = (string) strval($data['recipient']['id']); 
        $data['access_token'] = $this->token;

        $headers = [
            'Content-Type: application/json',
        ];

        if ($type == self::TYPE_GET) {
            $url .= '?'.http_build_query($data);
        }

        $process = curl_init($this->apiUrl.$url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($process, CURLOPT_HEADER, false);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        
//curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);

        if($type == self::TYPE_POST) {
            curl_setopt($process, CURLOPT_POST, 1);
            curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, true);
        $return = curl_exec($process);

//file_put_contents("1.txt", "aaa23a1".json_decode($bot->userProfile($message['sender']['id'])));  
file_put_contents("error.txt", "eeee".json_encode(curl_error($process)));
file_put_contents("result.txt", "eeee".json_encode($return));  
file_put_contents("data.txt", "data1".json_encode($data));     
curl_close($process);
        return json_decode($return, true);
    }
}