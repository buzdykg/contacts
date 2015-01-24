<?php
namespace Contact;

use Contact\Validator;
use Contact\Normilizer;
use Dictionary\States;

class Processor
{
    protected $validator;

    protected $normilizer;

    public function __construct(Validator $validator, Normilizer $normilizer, States $states)
    {
        $normilizer->setDictionary('states', $states);
        $this->normilizer = $normilizer;

        $validator->setDictionary('states', $states);
        $this->validator = $validator;
    }

    public function process(array $dataset)
    {
        $dataset = $this->expandDataset($dataset);
        $backup  = $dataset;

        $dataset = $this->normilizer->normilize($dataset);
        $dataset = $this->validator->validate($dataset);

        foreach ($dataset as $i => $row) {
            if (isset($row[11]) && is_array($row[11])) {
                foreach ($row[11] as $hard_failure) {
                    $dataset[$i][$hard_failure] = $backup[$i][$hard_failure];
                }
            }
        }
        return $dataset;
    }

    /*
     * 1;John,Steven;Cleaning,Drinking
     *
     * 1;John;Cleaning
     *
     */

    //any field contains any commas expands one row into num
    protected function expandDataset($dataset)
    {
        $result = [];

        foreach ($dataset as $row) {
            $result = array_merge($result, $this->expandRow($row));
        }

        return $result;
    }

    /*
     * gets a row with commas
     * on comma return array of arrays X number of commas
     */
    protected function expandRow($row)
    {
        $newSet = [];

        if (strpos($row[7], ',')) {
            $jobServices = explode(',', $row[7]);

            for ($i=0; $i<count($jobServices); $i++) {
                $newCol = $jobServices[$i];
                if (!trim($newCol)) {
                    continue;
                }

                $newRow = $row;
                $newRow[7] = $newCol;

                if (count($newSet) > 0) {
                    for ($j=8; $j<=10; $j++) {
                        unset($newRow[$j]);
                    }
                }

                $newSet[] = $newRow;
            }
        } else {
            $newSet[] = $row;
        }

        return $newSet;
    }
}