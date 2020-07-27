<?php

function arrayToSelect(array $values, $key, $value)
{
    if(count($values) > 0) {
        $data = array();

        $data[0] = 'Selecione';
        foreach ($values as $row) {
            $data[$row[$key]] = $row[$value];
        }

        return $data;
    } else{
        return ['Selecione'];
    }
}

function moneyData($value, $show = false, $decimalCase = 2) {
    //Save
    if ($show == false){
        $value  = str_replace('.', '', $value);
        $value  = str_replace(',', '.', $value);
    }

    //Show
    if ($show == true)
        $value = number_format($value, $decimalCase, ',', '.');

    $value = ($value == "" ? null : $value);

    return $value;
}