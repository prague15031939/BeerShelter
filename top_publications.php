<?php

function get_top_publications($db, $publications) {
  foreach ($publications as $publ) {
    $mid_res[$publ['publication_id']] = get_like_amount($db, $publ['publication_id']);
  }
  arsort($mid_res);
  $i = 0;
  $res = array();
  foreach ($mid_res as $k => $v) {
    if ($i == 3)
      break;
    foreach ($publications as $publ) {
      if ($publ['publication_id'] == $k)
        $res[$i] = $publ;
    }
    $i++;
  }
  return $res;
}
