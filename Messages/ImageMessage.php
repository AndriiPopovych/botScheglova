<?php

namespace Messages;


/**
 * Class ImageMessage
 *
 * @package pimax\Messages
 */
class ImageMessage
{
    /**
     * @var integer|null
     */
    protected $recipient = null;

    /**
     * @var string
     */
    protected $text = null;


    /**
     * Message constructor.
     *
     * @param $recipient
     * @param $file Web Url or local file with @ prefix
     */
    public function __construct($recipient, $file)
    {
        $this->recipient = $recipient;
        $this->text = $file;
        $this->a23 = $a;
    }

    /**
     * Get message data
     *
     * @return array
     */
    public function getData()
    {
        $res = [
            'recipient' =>  [
                'id' => $this->recipient
            ]
        ];

        //$this->text = "https://habrastorage.org/files/639/c23/a4c/639c23a4c6594eefbb539b2c420d1e1e.jpg";
        if (strpos($this->text, 'http://') === 0 || strpos($this->text, 'https://') === 0) {

            // Url
            if (!$this->a23) {
                $res['message'] = [
                    'attachment' => [
                        'type' => 'image',
                        'payload' => [
                            'url' => $this->text
                        ]
                    ]
                ];
            }
            else {
                //$this->text = "https://hsto.org/storage/stuff/hr_prices.pdf";
                $res['message'] = [
                    'attachment' => [
                        'type' => 'file',
                        'payload' => [
                           //"title" => "1.php",
                            'url' => $this->text
                        ]
                    ]
                ];
                /* $res['message'] = [
                     'attachment' => [
                         'type' => 'file',
                         'payload' => [
                             'url' => $this->text
                         ]
                     ]
                 ];*/
            }

        } else {

            // Local file

            $res['message'] = [
                'attachment' => [
                    'type' => 'file',
                    'payload' => []
                ]

            ];

            $res['filedata'] = $this->getCurlValue($this->text, mime_content_type($this->text), basename($this->text));
        }

        return $res;
    }

    protected function getCurlValue($filename, $contentType, $postname)
    {
        // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
        // See: https://wiki.php.net/rfc/curl-file-upload
        if (function_exists('curl_file_create')) {
            return curl_file_create($filename, $contentType, $postname);
        }

        // Use the old style if using an older version of PHP
        $value = "@{$this->filename};filename=" . $postname;
        if ($contentType) {
            $value .= ';type=' . $contentType;
        }

        return $value;
    }
}