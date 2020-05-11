<?php

function get_medium_text($src) {
  if (strlen($src) > 1100) {
    $src = wordwrap($src, 1100, '@&#', false);
    $arr = explode('@&#', $src);
    return $arr[0] . ' ...';
  }
  else {
    return $src;
  }
}
