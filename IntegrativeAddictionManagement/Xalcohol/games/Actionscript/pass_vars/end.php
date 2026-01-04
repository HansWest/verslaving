<title>Passed Value <?php echo $value; ?></title>
<body bgcolor="#FFFFFF" text="#000000">
<table width="100%" border="0" height="100%">
  <tr>
    <td align="center" valign="middle"> 
      <p><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0"
 width=150 height=100>
          <param name=movie value="end.swf?value=<?php echo $value; ?>">
          <param name=quality value=high>
          <param name=bgcolor value=#FFFFFF>
          <embed src="end.swf?value=<?php echo $value; ?>" quality=high bgcolor=#FFFFFF  width=150 height=100 type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">
          </embed> 
        </object></p>
      </td>
  </tr>
</table>
