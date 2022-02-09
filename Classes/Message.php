<?php
namespace NeosRulez\Neos\Mailgun;

use Neos\Flow\Annotations as Flow;
use Mailgun\Mailgun;
use Mailgun\Message\MessageBuilder;

/**
 *
 * @Flow\Scope("singleton")
 */
class Message {

    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $cc;

    /**
     * @var string
     */
    protected $bcc;

    /**
     * @var mixed|null
     */
    protected $mimeType;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $attachments;

    /**
     * @var bool
     */
    protected $clickTracking = false;

    /**
     * @var string
     */
    protected $deliveryTime;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @param array $settings
     * @return void
     */
    public function injectSettings(array $settings):void
    {
        $this->settings = $settings;
    }

    /**
     * @param string $from
     * @return void
     */
    public function setFrom(string $from):void
    {
        $this->from = $from;
    }

    /**
     * @param string $to
     * @return void
     */
    public function setTo(string $to):void
    {
        $this->to = $to;
    }

    /**
     * @param string $cc
     * @return void
     */
    public function setCc(string $cc):void
    {
        $this->cc = $cc;
    }

    /**
     * @param string $bcc
     * @return void
     */
    public function setBcc(string $bcc):void
    {
        $this->bcc = $bcc;
    }

    /**
     * @param string $body
     * @param mixed|null $mimeType
     * @return void
     */
    public function setBody(string $body, $mimeType = null):void
    {
        $this->body = $body;
        $this->mimeType = $mimeType;
    }

    /**
     * @param array $attachments
     * @return void
     */
    public function setAttachments(array $attachments):void
    {
        $this->attachments = $attachments;
    }

    /**
     * @param string $subject
     * @return void
     */
    public function setSubject(string $subject):void
    {
        $this->subject = $subject;
    }

    /**
     * @param bool|null $clickTracking
     * @return void
     */
    public function setClickTracking($clickTracking):void
    {
        $this->clickTracking = $clickTracking;
    }

    /**
     * @param string|null $deliveryTime
     * @return void
     */
    public function setDeliveryTime($deliveryTime):void
    {
        $this->deliveryTime = $deliveryTime;
    }

    /**
     * @return void
     */
    public function send():void
    {
        if(array_key_exists('server', $this->settings)) {
            $message = Mailgun::create($this->settings['apiKey'], $this->settings['server']);
        } else {
            $message = Mailgun::create($this->settings['apiKey']);
        }
        $builder = new MessageBuilder();
        $builder->setFromAddress($this->from);
        $builder->addToRecipient($this->to);
        $builder->addCcRecipient($this->cc);
        $builder->addBccRecipient($this->cc);
        $builder->setSubject($this->subject);
        if($this->mimeType === 'text/html') {
            $builder->setHtmlBody($this->body);
        } else {
            $builder->setTextBody($this->body);
        }
        if(!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $builder->addAttachment('@' . $attachment);
            }
        }
        if($this->deliveryTime !== null) {
            $builder->setDeliveryTime($this->deliveryTime);
        }
        $builder->setClickTracking($this->clickTracking);
        $message->messages()->send($this->settings['domain'], $builder->getMessage());
    }

}
