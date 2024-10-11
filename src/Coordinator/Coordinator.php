<?php

declare(strict_types=1);

namespace PrinsFrank\PhpGeoSVG\Coordinator;

use PrinsFrank\PhpGeoSVG\Geometry\BoundingBox\BoundingBox;
use PrinsFrank\PhpGeoSVG\Geometry\Position\Position;
use PrinsFrank\PhpGeoSVG\Projection\Projection;
use PrinsFrank\PhpGeoSVG\Scale\Scale;

class Coordinator
{
    public const BASE_SCALE_FACTOR = 2;

    public $north = NULL;
    public $south = NULL;
    public $east = NULL;
    public $west = NULL;

    public function __construct(private Projection $projection, private BoundingBox $boundingBox, private Scale $scale, private float $offsetX = 0, private float $offsetY = 0)
    {
    }

    public function getWidth(): float
    {
        return ($this->boundingBox->getWidth() / Position::TOTAL_LONGITUDE * $this->projection->getMaxX()) * $this->scale->getFactorX() * self::BASE_SCALE_FACTOR;
    }

    public function getHeight(): float
    {
        return ($this->boundingBox->getHeight() / Position::TOTAL_LATITUDE * $this->projection->getMaxY()) * $this->scale->getFactorY() * self::BASE_SCALE_FACTOR;
    }

    public function getX(Position $position): float
    {
        $position->longitude += $this->offsetX;

        if ($position->longitude > 180) {
            $position->longitude = -180 + ($position->longitude - 180);
        }

        if ($position->longitude < -180) {
            $position->longitude = 180 - ($position->longitude + 180);
        }

        $pos = $this->boundingBox->boundX($position, $this->projection) * $this->scale->getFactorX() * self::BASE_SCALE_FACTOR;

        if ($this->east === NULL || $pos > $this->east) {
            $this->east = $pos;
        }

        if ($this->west === NULL || $pos < $this->west) {
            $this->west = $pos;
        }

        return $pos;
    }

    public function getY(Position $position): float
    {
        $position->latitude += $this->offsetY;

        if ($position->latitude > 180) {
            $position->latitude = -180 + ($position->latitude - 180);
        }

        if ($position->latitude < -180) {
            $position->latitude = 180 - ($position->latitude + 180);
        }

        $pos = $this->boundingBox->boundY($position, $this->projection) * $this->scale->getFactorY() * self::BASE_SCALE_FACTOR;

        if ($this->north === NULL || $pos > $this->north) {
            $this->north = $pos;
        }

        if ($this->south === NULL || $pos < $this->south) {
            $this->south = $pos;
        }

        return $pos;
    }
}
