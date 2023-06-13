<?php
if (!function_exists('formatTransactionId')) {
    function formatTransactionId($id)
    {
        return 'TRK' . $id;
    }
}
