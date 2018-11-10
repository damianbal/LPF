<?php

namespace LPF\Framework\Http;

/**
 * Simple Response
 */
class Response
{
    protected $body = "";
    protected $code = 200;
    protected $isRedirect = false;
    protected $redirectUrl = "";

    /**
     * Construct Response
     *
     * @param string $body
     * @param integer $code
     */
    public function __construct($body = "", $code = 200)
    {
        $this->body = $body;
        $this->code = $code;
    }

    /**
     * Create redirect response
     *
     * @param [type] $url
     * @return void
     */
    public static function redirect($url)
    {
        $response = new Response;
        $response->setRedirectUrl($url);
        return $response;
    }

    /**
     * Set redirect url
     *
     * @param string $url
     * @return void
     */
    public function setRedirectUrl($url)
    {
        $this->redirectUrl = $url;
        $this->isRedirect = true;
    }

    /**
     * Get response body
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Respond with response
     *
     * @return void
     */
    public function respond()
    {
        http_response_code($this->code); // response 

        if($this->isRedirect) {
            header('Location: ' . $this->redirectUrl, true, 303);
        }
        else if(is_array($this->body)) {
            echo json_encode($this->getBody());
        }
        else {
            echo $this->getBody(); // render the body
        }
    }
}
