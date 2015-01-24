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
        $toUnset= [];

        foreach ($row as $i => $col) {
            if (strpos($col, ',')) {
                foreach (explode(',', $col) as $newCol) {
                    if (!trim($newCol)) {
                        continue;
                    }
                    $newRow = $row;
                    $newRow[$i] = $newCol;
                    $newSet[] = $newRow;
                }

                foreach ($newSet as $j => $newRow) {
                    $expanded = $this->expandRow($newRow);
                    if (count($expanded) > 1) {
                        $toUnset[] = $j;
                    }
                    /* @todo debug to wipe out array_unique */
                    $newSet = array_unique(array_merge($newSet, $expanded), SORT_REGULAR);
                }

                break;
            }
        }

        foreach ($toUnset as $i) {
            unset($newSet[$i]);
        }

        if (count($newSet) == 0) {
            $newSet = [$row];
        }

        return $newSet;
    }
}