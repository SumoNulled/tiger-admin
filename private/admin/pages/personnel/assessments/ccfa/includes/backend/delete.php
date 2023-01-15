<?php

use App\SQL;
use App\General;

if ($_GET['id'])
{
  $id = $_GET['id'];

  $sql = "DELETE FROM personnel_ccfa_scores WHERE cadet_id = ?";
  App\SQL::query($sql, $id);
  App\General::redirect($_SERVER['HTTP_REFERER']);
}
?>
