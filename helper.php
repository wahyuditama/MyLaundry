<!-- untuk mengubah Status dengan function -->
<?php
function changeStatus($status)
{
    switch ($status) {
        case '1':
            $badge = "<span class='badge bg-success'> sudah dikembalikan</span>";
            break;
        default:
            $badge = "<span class='badge bg-warning'> Baru</span>";
            break;
    }
    return $badge;
}
