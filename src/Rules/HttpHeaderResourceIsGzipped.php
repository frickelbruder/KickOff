<?php
namespace Frickelbruder\KickOff\Rules;

use Frickelbruder\KickOff\Rules\Exceptions\HeaderNotFoundException;
use Frickelbruder\KickOff\Rules\Interfaces\RequiresHeaderInterface;

class HttpHeaderResourceIsGzipped extends RuleBase implements RequiresHeaderInterface {

    public $name = 'HTTP header resource is flagged "gzipped"';

    protected $errorMessage =  'The "Content-Encoding" HTTP header was found but had an unexpected value';

    public function getRequiredHeaders() {
        return array('Accept-Encoding' => 'gzip, deflate');
    }

    public function validate() {
        try {
            $contentEncoding = $this->findNormalizedHeader( 'Content-Encoding' );
            return $contentEncoding == 'gzip';
        } catch(HeaderNotFoundException $e) {
            $this->errorMessage = 'The "Content-Encoding" HTTP header was not found.';
        }
        return false;
    }


}