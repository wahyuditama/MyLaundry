<?php

function nameOfPage()
{
    if (isset($_GET['edit'])) {
        $label = "Edit";
    } else {
        $label = "Tambah";
    }
    return $label;
}
