<?php

use Davaxi\AllMySMS\Model\Email as Email;

/**
 * Class EmailMockup
 */
class EmailMockup extends Email
{
    /**
     * @param $attribute
     * @return mixed
     */
    public function getAttribute($attribute)
    {
        return $this->$attribute;
    }
}

class EmailTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EmailMockup
     */
    protected $email;

    public function setUp()
    {
        parent::setUp();
        $this->email = new EmailMockup();
    }

    public function testSetFrom_withoutAlias()
    {
        $from = $this->email->getAttribute('from');
        $this->assertEmpty($from);
        $alias = $this->email->getAttribute('alias');
        $this->assertEmpty($alias);

        $this->email->setFrom('FromMe');
        $from = $this->email->getAttribute('from');
        $this->assertEquals('FromMe', $from);
        $alias = $this->email->getAttribute('alias');
        $this->assertEmpty($alias);
    }

    public function testSetFrom_withAlias()
    {
        $from = $this->email->getAttribute('from');
        $this->assertEmpty($from);
        $alias = $this->email->getAttribute('alias');
        $this->assertEmpty($alias);

        $this->email->setFrom('FromMe', 'FromAlias');
        $from = $this->email->getAttribute('from');
        $this->assertEquals('FromMe', $from);
        $alias = $this->email->getAttribute('alias');
        $this->assertEquals('FromAlias', $alias);
    }

    public function testSetAlias()
    {
        $alias = $this->email->getAttribute('alias');
        $this->assertEmpty($alias);

        $this->email->setAlias('FromAlias');
        $alias = $this->email->getAttribute('alias');
        $this->assertEquals('FromAlias', $alias);
    }

    public function testSetTo()
    {
        $to = $this->email->getAttribute('to');
        $this->assertEmpty($to);

        $this->email->setTo('FromTo');
        $to = $this->email->getAttribute('to');
        $this->assertEquals('FromTo', $to);
    }

    public function testSetSubject()
    {
        $subject = $this->email->getAttribute('subject');
        $this->assertEmpty($subject);

        $this->email->setSubject('Subject');
        $subject = $this->email->getAttribute('subject');
        $this->assertEquals('Subject', $subject);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetDate_Invalid()
    {
        $date = $this->email->getAttribute('date');
        $this->assertEmpty($date);

        $this->email->setDate('invalid date');
    }

    public function testSetDate_System()
    {
        $date = $this->email->getAttribute('date');
        $this->assertEmpty($date);

        $this->email->setDate('2017-09-18 00:00:00');
        $date = $this->email->getAttribute('date');
        $this->assertEquals('2017-09-18 00:00:00', $date);
    }

    public function testSetContentHTML()
    {
        $contentHTML = $this->email->getAttribute('contentHTML');
        $this->assertEmpty($contentHTML);

        $this->email->setContentHtml('MyHTMLContent');
        $contentHTML = $this->email->getAttribute('contentHTML');
        $this->assertEquals('MyHTMLContent', $contentHTML);
    }

    public function testSetContentText()
    {
        $contentText = $this->email->getAttribute('contentText');
        $this->assertEmpty($contentText);

        $this->email->setContentText('MyTextContent');
        $contentText = $this->email->getAttribute('contentText');
        $this->assertEquals('MyTextContent', $contentText);
    }

    public function testSetCampaignName()
    {
        $campaignName = $this->email->getAttribute('campaignName');
        $this->assertEmpty($campaignName);

        $this->email->setCampaignName('MyCampaign');
        $campaignName = $this->email->getAttribute('campaignName');
        $this->assertEquals('MyCampaign', $campaignName);
    }

    public function testSetReplyTo()
    {
        $replyTo = $this->email->getAttribute('replyTo');
        $this->assertEmpty($replyTo);

        $this->email->setReplyTo('MyReplyEmail');
        $replyTo = $this->email->getAttribute('replyTo');
        $this->assertEquals('MyReplyEmail', $replyTo);
    }

}