<?php

/**
 * @author Yurii Savka <yurii.savka@lendico.de>
 * @created 08/02/16 14:08
 */
class Line
{
    public $x1, $y1, $x2, $y2, $square;

    /**
     * Line constructor.
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @param $square
     */
    public function __construct($x1, $y1, $x2, $y2, $square)
    {
        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x2;
        $this->y2 = $y2;
        $this->square = $square;
    }

    public function __toString()
    {
        return implode(" ", [$this->x1, $this->y1, $this->x2, $this->y2]);
    }
}
