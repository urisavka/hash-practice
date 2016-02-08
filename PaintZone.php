<?php

/**
 * @author Yurii Savka <yurii.savka@lendico.de>
 * @created 08/02/16 12:21
 */
class PaintZone
{
    private $zone = [];
    private $N;
    private $M;

    public function _($x, $y, $value = null)
    {
        if ($x >= $this->M || $y >= $this->N || $x < 0 || $y < 0) {
            return null;
        }

        if ($value !== null) {
            $this->zone[$y][$x] = $value;
        }

        return $this->zone[$y][$x];
    }

    /**
     * @return array
     */
    public function getZone()
    {
        return $this->zone;
    }

    public function findAllLines()
    {
        $lines = [];
        for ($x = 0; $x < $this->M; $x++) {
            for ($y = 0; $y < $this->N; $y++) {
                $lines = array_merge($lines, $this->findLines($x, $y));
            }
        }

        return $lines;
    }

    public function findLines($x, $y)
    {
        // If left pixel is wall - return.
        // Otherwise move right
        // If next pixel is not wall, record a line and cost
        $lines = [];
        // Horizontal
        if ($this->_($x, $y) == '#' && $this->_($x - 1, $y) != '#') {
            $temp_x = $x;
            while ($this->_($temp_x + 1, $y) == '#') {
                $temp_x++;
            }
            $lines[] = new Line($x, $y, $temp_x, $y, $temp_x - $x + 1);
        }
        // No single lines for vertical alignment.
        // We already counted them for horizontal
        if ($this->_($x, $y) == '#' && $this->_($x, $y - 1) != '#' && $this->_($x, $y - 1) != '#') {
            $temp_y = $y;
            while ($this->_($x, $temp_y + 1) == '#') {
                $temp_y++;
            }
            $lines[] = new Line($x, $y, $x, $temp_y, $temp_y - $y + 1);
        }

        return $lines;
    }

    public function isSquare($x, $y, $size) {
        for ($i = $x; $i < $x + $size; $i ++) {
            for ($j = $y; $j < $y + $size; $j++) {
                if ($this->_($x, $y) != '#') {
                    return false;
                }
            }
        }
        return true;
    }
    public function findSquares($x, $y)
    {
        $squares = [];
        $size = 1;
        if ($this->_($x, $y) == '#') {
            while($this->isSquare($x, $y, $size)) {
                $size++;
            }
            if ($size > 1) {
                $squares[] = new Square($x, $y, $x + $size, $y + $size, $size*$size);
            }
        }


        return $squares;
    }

    public function applyLine(Line $l)
    {
        for ($x = $l->x1; $x <= $l->x2; $x++) {

            for ($y = $l->y1; $y <= $l->y2; $y++) {
                $this->_($x, $y, '+');
            }
        }
    }

    public function isSolved()
    {
        foreach ($this->zone as $row) {
            foreach ($row as $cell) {
                if ($cell == '#') {
                    return false;
                }
            }
        }

        return true;
    }

    public function findAllSquares()
    {
        $squares = [];
        for ($x = 0; $x < $this->M; $x++) {
            for ($y = 0; $y < $this->N; $y++) {
                $squares = array_merge($squares, $this->findSquares($x, $y));
            }
        }

        return $squares;
    }

    public function combine(PaintZone $b)
    {
        $c = clone $this;
        foreach ($c->getZone() as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($b->_($x, $y) == '+') {
                    $c->_($x, $y, '+');
                }
            }
        }

        return $c;
    }

    public function read($fileName)
    {
        $handle = fopen($fileName, "r");
        fscanf($handle, "%d %d", $this->N, $this->M);
        $a = [];
        for ($i = 0; $i < $this->N; $i++) {
            fscanf(
                $handle,
                "%s",
                $row
            );
            $a[] = str_split($row);
        }
        $this->zone = $a;
    }

    public function out()
    {
        foreach ($this->zone as $row) {
            print implode('', $row).PHP_EOL;
        }
    }
}
