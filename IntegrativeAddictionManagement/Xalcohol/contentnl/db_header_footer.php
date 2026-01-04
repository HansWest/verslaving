<?php
function site_header($title)
{
  $site_header = <<< EOHEADER
<HTML>
<HEAD>
<TITLE>$title</TITLE>
</HEAD>

<BODY>
EOHEADER;
  echo $site_header;
}

function site_footer()
{
  $site_footer = <<< EOFOOTER
</BODY>
</HTML>
EOFOOTER;
  echo $site_footer;
}
?>