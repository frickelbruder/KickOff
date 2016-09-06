<?php
namespace Frickelbruder\Kickoff\Tests\Rules;

use Frickelbruder\KickOff\Http\HttpResponse;
use Frickelbruder\KickOff\Rules\MetaDescriptionLength;


class MetaDescriptionLengthTest extends \PHPUnit_Framework_TestCase {

    public function testValidate() {
        $response = new HttpResponse();
        $response->setBody('<!DOCTYPE html><html><head><meta name="description" content="This is a test with the desired length of a mediocre title"></head></html>');

        $rule = new MetaDescriptionLength();
        $rule->setHttpResponse($response);
        $rule->setMinLength(10);
        $rule->setMaxLength(300);

        $result = $rule->validate();
        $this->assertTrue($result);
    }

    public function testValidateWithTooShortTitle() {
        $response = new HttpResponse();
        $response->setBody('<!DOCTYPE html><html><head><meta name="description" content="Short"></head></html>');

        $rule = new MetaDescriptionLength();
        $rule->setMinLength(100);
        $rule->setHttpResponse($response);

        $result = $rule->validate();
        $this->assertFalse($result);
    }

    public function testValidateWithTooLongTitle() {
        $response = new HttpResponse();
        $response->setBody('<!DOCTYPE html><html><head><meta name="description" content="REALY LONG"></head></html>');

        $rule = new MetaDescriptionLength();
        $rule->setMaxLength(3);
        $rule->setHttpResponse($response);

        $result = $rule->validate();
        $this->assertFalse($result);
    }

    public function testValidateWithMissingTitle() {
        $response = new HttpResponse();
        $response->setBody('<!DOCTYPE html><html><head></head></html>');

        $rule = new MetaDescriptionLength();
        $rule->setHttpResponse($response);

        $result = $rule->validate();
        $this->assertFalse($result);
    }

    public function testValidateWithMultipleTitleTakesFirst() {
        $response = new HttpResponse();
        $response->setBody('<!DOCTYPE html><html><head><meta name="description" content="123456"><meta name="description" content="123"></head></html>');

        $rule = new MetaDescriptionLength();
        $rule->setMinLength(6);
        $rule->setHttpResponse($response);

        $result = $rule->validate();
        $this->assertTrue($result);
    }

    public function testValidateAsUtf8() {
        $response = new HttpResponse();
        $response->setBody('<!DOCTYPE html><html><head><meta name="description" content="äöü"></head></html>');

        $rule = new MetaDescriptionLength();
        $rule->setMinLength(2);
        $rule->setMaxLength(3);
        $rule->setHttpResponse($response);

        $result = $rule->validate();
        $this->assertTrue($result);
    }

}
