<?php

declare(strict_types=1);

namespace PrinsFrank\PhpGeoSVG\Html\Elements;

use PrinsFrank\PhpGeoSVG\Html\Elements\Definition\ForeignElement;
use PrinsFrank\PhpGeoSVG\Html\Elements\Text\TextContent;

class Element
{
    /** @var Element[] */
    protected array $childElements = [];

    /** @var array<string, string> */
    protected array $attributes = [];

    protected string $tagName = 'svg';

    private ?TextContent $textContent = null;

    public function __construct(string $tagName = null)
    {
        if ($tagName) {
            $this->tagName = $tagName;
        }
    }

    public function addChildElement(Element $childElement): self
    {
        $this->childElements[] = $childElement;

        return $this;
    }

    /**
     * @return Element[]
     */
    public function getChildElements(): array
    {
        return $this->childElements;
    }

    /**
     * @return array<string, string>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttribute(string $name, mixed $value): self
    {
        $this->attributes[$name] = (string) $value;

        return $this;
    }

    public function setTextContent(?TextContent $textContent): self
    {
        $this->textContent = $textContent;

        return $this;
    }

    public function getTextContent(): ?TextContent
    {
        return $this->textContent;
    }

    /**
     * @see https://html.spec.whatwg.org/#self-closing-start-tag-state
     *
     * Foreign elements must either have a start tag and an end tag, or a start tag that is marked as self-closing,
     * in which case they must not have an end tag.
     */
    public function canSelfClose(): bool
    {
        if (false === $this instanceof ForeignElement) {
            return false;
        }

        if ([] !== $this->childElements) {
            return false;
        }

        if (null !== $this->textContent) {
            return false;
        }

        return true;
    }

    public function getTagName(): string
    {
        return $this->tagName;
    }
}
