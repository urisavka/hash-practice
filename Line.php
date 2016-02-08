<?php

/**
 * @author Yurii Savka <yurii.savka@lendico.de>
 * @created 08/02/16 14:08
 */
class Line extends Shape
{

    public function __toString()
    {
        return implode(" ", [$this->x1, $this->y1, $this->x2, $this->y2]);
    }
}
