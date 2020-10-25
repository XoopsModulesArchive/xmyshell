<?php
// $Id: functions.php,v 1.2 2006/03/27 08:14:51 mikhail Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2006 xoopscube.org                       //
//                       < http://xoops.eti.br >                             //
//  ------------------------------------------------------------------------ //
//	This module is based upon MyShell information on contacts for the				 //
//	original file below. xMyShell is copyright 2004 David Wagner						 //
//	<dave@nixpert.com>																											 //
//																																					 //
//	Below is the original owners information--															 //
//	An interactive PHP-page that will execute any command entered.					 //
//  See the files README and INSTALL or http://www.digitart.net  for				 //
//  further information.																										 //
//	Copyright ©2001 Alejandro Vasquez <admin@digitart.com.mx>								 //
//  based on the original program phpShell by Martin Geisler								 //
//																																					 //
//																																					 //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

function adminmenu($currentoption, $breadcrumb)
{
    global $xoopsModule, $xoopsConfig;

    $tblColors = [];

    $tblColors[0] = $tblColors[1] = $tblColors[2] = $tblColors[3] = $tblColors[4] = $tblColors[5] = $tblColors[6] = $tblColors[7] = '#DDE';

    $tblColors[$currentoption] = 'white';

    echo "<table width=100% class='outer'><tr><td align=right><strong> 
          <font size=2>" . _AM_MODULEADMIN . '' . $xoopsModule->name() . ':' . $breadcrumb . '</font></strong></td></tr></table><br>';

    echo '<div id="navcontainer"><ul style="padding: 3px 0; margin-left: 0; font: bold 12px Verdana, sans-serif; ">';

    echo '<li style="list-style: none; margin: 0; display: inline; "> 
    <a href="index.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[0] . '; 
     text-decoration: none; ">' . _AM_XMYSHELL . '</a></li>';

    echo '<li style="list-style: none; margin: 0; display: inline; "> 
    <a href="config.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[1] . '; 
     text-decoration: none; ">' . _AM_XMYSHELL_CONFIG . '</a></li>';

    echo '</div></ul>';

    echo '<br><br>';
}
