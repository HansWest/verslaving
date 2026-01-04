<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="2"><p align="right"><span class="smakopje2">menu</span></td>
	<hr size="1" align="right" width="50%">
    <!--                  voorbereiding<P>&nbsp;</P></td>
td colspan="2"><p align="right"><span class="smakopje2"><font size="+1">menu</font><br>
                    <i>voorbereiding</i></span--->
     </tr>
<?php
$hiero3="";
$hiero2="verslaving";
echo (menue("verslaving menu", "versl_aaa_menu", "menu","het menu over verslavingsitems in engere zin"));

switch ($_SESSION['strategie']) {
			case 3:
				echo (menue("hoofd menu", "abstin_aaa_menu", "menu", "naar het abstinentie hoofdmenu"));
			    break;
			case 2:
				echo (menue("hoofd menu", "control_aaa_menu", "menu", "naar het gecontroleerd drinken hoofdmenu"));
			    break;
			case 1:
				echo (menue("hoofd menu", "voorb_aaa_menu", "menu", "naar het inname-analyse hoofdmenu"));
			    break;
			default:
				echo (menue("hoofd menu", "uitgl_aaa_menu", "menu", "naar het uitlij-analyse hoofdmenu"));
		}
 ?></td>
  </tr>
<tr> 
    <td valign="top">&nbsp;</td>
    <td valign="top" align="right"><hr size="1" align="right" width="50"><span class="smakopje4">valkuilen</span> 
	  </td>
  </tr>
  <?php
echo (menue("valkuil(waar)", "versl_valkuilwaar", dbcheck(), "inventariseer WAAR de valkuilen liggen"));
echo (menue("valkuil(wanneer)", "versl_valkuilwanneer", dbcheck(), "inventariseer WANNEER er valkuilen liggen"));
if ($_SESSION['strategie']>0)
{
	echo (menue("smoezen", "versl_smoezen", dbcheck(), "@@@ nog ***"));
///	echo (menue("prodromen", "versl_prodromen", dbcheck(), "@@@ nog ***"));
}else
{
	echo (menue("redenaties", "versl_redenaties", dbcheck(), "@@@ nog ***"));
}

///
///@@@echo (menue("familiair", "versl_familiair", dbcheck(), "@@@ nog ***"));
///@@@echo (menue("fysiek", "versl_fysiek", dbcheck(), "@@@ nog ***"));
echo (menue("ontkenning", "versl_ontkenning", dbcheck(), "@@@ nog ***"));
?>
<tr> 
    <td valign="top">&nbsp;</td>
    <td valign="top" align="right"><hr size="1" align="right" width="50"><span class="smakopje4">geschiedenis</span> 
	  </td>
  </tr>
<?php
echo (menue("de start", "versl_gesch1", dbcheck(), "het eerste begin van jouw alcoholisme"));
?>
  <tr> 
    <td valign="top">&nbsp;</td>
    <td valign="top" align="right"><hr size="1" align="right" width="50"><span class="smakopje4">andere menu's</span></td>
  </tr>
<?php
echo (menue("tools menu", "tools_aaa_menu", "menu","het hoofdmenu van de toolbox"));
?>
<tr><td valign="top">&nbsp;</td>
<td valign="top" align="right"><hr size="1" align="right" width="50"><span class="smakopje4">algemeen</span></td>
</tr>
<tr> 
<td valign="top">&nbsp;</td>
<td valign="top" align="right">
<a href="javascript:popUpWindow('notes.php', 'AlcoholClipBoard', 55, 35, 300, 275);" class="menubutton">notities</a></td>
</tr>
<tr> 
<td valign="top">&nbsp;</td>
<td valign="top" align="right"><a href="info_contact.php" target="_self" class="menubutton">contact opnemen</a></td>
</tr>
<tr><td valign="top">&nbsp;</td>
<td valign="top" align="right"><hr size="1" align="right" width="50"><span class="smakopje4">help</span></td>
</tr>
<?php
echo (menue("algemeen", "info_help_alg", dbcheck(), "een hulppagina over de algemene opzet van deze site"));
helppagina($hierorichting);
?>

 </table>
