<?php

/**
 * @author Yurii Savka <yurii.savka@lendico.de>
 * @created 08/02/16 13:59
 */
class Painter
{
    /** @var  PaintZone */
    private $basicZone;

    public function __construct(PaintZone $zone)
    {
        $this->basicZone = $zone;
    }

    public function work()
    {
        $lines = $this->basicZone->findAllLines();
        $lines = array_merge($lines, $this->basicZone->findAllSquares());
        usort(
            $lines,
            function ($l1, $l2) {
                $a = $l1->square;
                $b = $l2->square;
                if ($a == $b) {
                    return 0;
                }

                return ($a > $b) ? -1 : 1;
            }
        );
        $zone = $this->basicZone;
        $n = 0;
        foreach ($lines as $line) {
            $n++;
            //print $line . PHP_EOL;
            $zone->applyLine($line);
            //$zone->out();
            if ($zone->isSolved()) {
                break;
            }
        }
        print $n.PHP_EOL;
        for ($i = 0; $i < $n; $i++) {
            print $lines[$i].PHP_EOL;
        }
    }
}
