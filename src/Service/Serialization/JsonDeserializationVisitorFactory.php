<?php

declare(strict_types=1);

namespace App\Service\Serialization;

use JMS\Serializer\Visitor\DeserializationVisitorInterface;
use JMS\Serializer\Visitor\Factory\DeserializationVisitorFactory;
use JMS\Serializer\Visitor\Factory\JsonDeserializationVisitorFactory as JMSJsonDeserializationVisitorFactory;

class JsonDeserializationVisitorFactory implements DeserializationVisitorFactory
{
    private JMSJsonDeserializationVisitorFactory $innerFactory;
    /**
     * @var string[]
     */
    private array $nullAwareTypes = [];

    public function __construct(JMSJsonDeserializationVisitorFactory $innerFactory)
    {
        $this->innerFactory = $innerFactory;
    }

    /**
     * @param string[] $nullAwareTypes
     */
    public function setNullAwareTypes(array $nullAwareTypes): void
    {
        $this->nullAwareTypes = $nullAwareTypes;
    }

    public function getVisitor(): DeserializationVisitorInterface
    {
        return new JsonDeserializationVisitor($this->innerFactory->getVisitor(), $this->nullAwareTypes);
    }
}
