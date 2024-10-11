<?php

declare(strict_types=1);

namespace PrinsFrank\PhpGeoSVG\Geometry\GeometryObject;

use PrinsFrank\PhpGeoSVG\Geometry\Position\Position;

abstract class GeometryObject
{
    protected ?string $title    = null;
    protected array $properties = [];

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setProperties(array $properties): self
    {
        $this->properties = $properties;

        return $this;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }
}
