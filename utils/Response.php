<?php

class Response
{
    const STATUS_OK       = 'ok';
    const STATUS_REDIRECT = 'redirect';
    const STATUS_ERROR    = 'error';
    public $status   = self::STATUS_OK;
    public $redirect = null;
    public $html     = null;
    public $message  = null;
    public $data     = null;
    public $entities = true;
    public $errors   = [];

    public function __construct($sucess = null, $message = null, $data = null)
    {
        if (isset($sucess)) {
            $this->setSuccess($sucess);
        }
        if (isset($message)) {
            $this->setMessage($message);
        }
        if (isset($data)) {
            $this->setData($data);
        }
    }
    /*==========  Setters  ==========*/
    public function setSuccess($success = true)
    {
        $this->setStatus($success ? self::STATUS_OK : self::STATUS_ERROR);
    }
    public function setStatus($status)
    {
        if (in_array($status, [self::STATUS_OK, self::STATUS_REDIRECT, self::STATUS_ERROR])) {
            $this->status = $status;
        }
        return $this;
    }
    /**
     * Redirect the user to
     *
     * @param string $url   Redirect the user to where?
     * @param int    $delay Wait x seconds before redirecting the user
     *
     * @return void
     */
    public function setRedirect($url, $delay = 0)
    {
        $this->setStatus(self::STATUS_REDIRECT);
        $this->redirect = [
            'url'   => $url,
            'delay' => abs(intval($delay, 10))
        ];
        return $this;
    }
    public function setHtml($html, $entities = true)
    {
        $this->html     = $html;
        $this->entities = (bool) $entities;
        return $this;
    }
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
    public function setContent($data)
    {
        return $this->setData($data);
    }
    /**
     * Add an error to the response
     *
     * @param  string $text  The error message
     * @param  string $about The name of the element or var this error is about. This can for example be the name of a POST var
     * @return void
     */
    public function addError($text, $about = null)
    {
        // Adding an error will automaticly set the response status to error
        // If you want to force a status ok you can use setStatus(ok) after you've added all errors
        if ($this->getStatus() != self::STATUS_ERROR) {
            $this->setStatus(self::STATUS_ERROR);
        }
        if ($about !== null) {
            $this->errors[$about] = $text;
        } else {
            $this->errors[] = $text;
        }
        return $this;
    }
    public function setErrors($errors)
    {
        if (is_array($errors)) {
            $this->errors = $errors;
        } elseif (is_scalar($errors)) {
            $this->errors = [$errors];
        }
        // Adding an error will automaticly set the response status to error
        // If you want to force a status ok you can use setStatus(ok) after you've added all errors
        if (count($this->errors) > 0 && $this->getStatus() != self::STATUS_ERROR) {
            $this->setStatus(self::STATUS_ERROR);
        }
        return $this;
    }
    /*==========  Getters  ==========*/
    public function getSuccess()
    {
        return $this->getStatus() != self::STATUS_ERROR;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getRedirectUrl()
    {
        if (!isset($this->redirect['url']) || empty($this->redirect['url'])) {
            return false;
        }
        return $this->redirect['url'];
    }
    public function getRedirectDelay()
    {
        if (!isset($this->redirect['delay']) || empty($this->redirect['delay'])) {
            return 0;
        }
        return $this->redirect['delay'];
    }
    public function getRedirect()
    {
        return $this->redirect = [
            'url'   => $this->getRedirectUrl(),
            'delay' => $this->getRedirectDelay()
        ];
    }
    public function getHtml()
    {
        if (!isset($this->html) || empty($this->html)) {
            return false;
        }
        return $this->html;
    }
    public function getMessage()
    {
        if (!isset($this->message) || empty($this->message)) {
            return false;
        }
        return $this->message;
    }
    public function getData()
    {
        return $this->data;
    }
    public function getContent()
    {
        return $this->getData();
    }
    public function getErrors()
    {
        if (count($this->errors) === 0) {
            return false;
        }
        return $this->errors;
    }
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }
    /*==========  Response  ==========*/
    private static function _utf8(&$data)
    {
        $uft8 = function (&$tem) {
            if (is_string($tem) && !mb_check_encoding($tem, 'UTF-8')) {
                $tem = utf8_encode($data);
            }
        };
        if (is_array($data)) {
            array_walk_recursive($data, $uft8);
        } else {
            $uft8($data);
        }
    }
    public function __toString()
    {
        $oResponse = new stdClass();
        // Set the response status
        $oResponse->status = $this->getStatus();
        // Set redirect to if needed
        if ($this->getStatus() == self::STATUS_REDIRECT) {
            $oResponse->redirect = $this->getRedirect();
        }
        // Set html
        // @todo check if htmlentities is enough to get html working in json
        if ($this->getHtml()) {
            if ($this->entities) {
                $oResponse->html = htmlentities($this->getHtml());
            } else {
                $oResponse->html = $this->getHtml();
            }
        }
        // Set message
        if ($this->getMessage()) {
            $oResponse->message = $this->getMessage();
        }
        // Set data
        if ($this->getData()) {
            $oResponse->data = $this->getData();
            // $this->_utf8($oResponse->data);
        }
        // Set errors
        if ($this->getErrors()) {
            $oResponse->errors = $this->getErrors();
        }
        return @json_encode($oResponse);
    }
    public function json()
    {
        return $this->__toString();
    }
    public function send()
    {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        if (isset($_GET['callback']) && !empty($_GET['callback'])) {
            echo "{$_GET['callback']}({$this->__toString()})";
        } else {
            echo $this->__toString();
        }
        exit();
    }
}