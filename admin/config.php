<?php
// $Id: config.php,v 1.2 2006/03/27 08:14:51 mikhail Exp $
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

require dirname(__DIR__, 3) . '/include/cp_header.php';
require __DIR__ . '/admin_header.php';
xoops_cp_header();

// Setup SQL
// Get xMyShell configuration array
$sql_xmyshell_config = 'SELECT * FROM ' . $xoopsDB->prefix('xmyshell_config') . ' WHERE id=1';
$query_xmyshell_config = $xoopsDB->query($sql_xmyshell_config);
$xmyshell_config = $xoopsDB->fetchArray($query_xmyshell_config);

adminmenu(0, 'Configuration');
echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_XMYSHELL_CONFIG . '</legend>';

// Setup our configuration form
$config_form = new XoopsThemeForm('xMyShell Config', 'xmyshell_config', 'update.php', 'POST');

if (0 == $xmyshell_config['selfsecure']) {
    $config_form->addElement(new XoopsFormRadioYN(_AM_XMYSHELL_SECURE, 'selfsecure', 0));
} elseif (1 == $xmyshell_config['selfsecure']) {
    $config_form->addElement(new XoopsFormRadioYN(_AM_XMYSHELL_SECURE, 'selfsecure', 1));
}
$config_form->addElement(new XoopsFormText(_AM_XMYSHELL_SECUREUSER, 'shelluser', 30, 254, $xmyshell_config['shelluser']));
$config_form->addElement(new XoopsFormPassword(_AM_XMYSHELL_SECUREOLDPSWD, 'shelloldpswd', 30, 254, ''));
$config_form->addElement(new XoopsFormPassword(_AM_XMYSHELL_SECURENEWPSWD, 'shellnewpswd', 30, 254, ''));
// Make sure that a directory limit is set, if not give it a default "safe" value.
if (!$xmyshell_config['dirlimit']) {
    $config_form->addElement(new XoopsFormText(_AM_XMYSHELL_DIRLIMIT, 'dirlimit', 30, 254, $_SERVER['DOCUMENT_ROOT']));
} else {
    $config_form->addElement(new XoopsFormText(_AM_XMYSHELL_DIRLIMIT, 'dirlimit', 30, 254, $xmyshell_config['dirlimit']));
}
if (0 == $xmyshell_config['errortrap']) {
    $config_form->addElement(new XoopsFormRadioYN(_AM_XMYSHELL_ERRORTRAP, 'errortrap', 0));
} elseif (1 == $xmyshell_config['errortrap']) {
    $config_form->addElement(new XoopsFormRadioYN(_AM_XMYSHELL_ERRORTRAP, 'errortrap', 1));
}
$config_form->addElement(new XoopsFormHidden('pass', $xmyshell_config['shellpswd']));
$config_form->addElement(new XoopsFormButton(_AM_XMYSHELL_SUBMIT, 'submit', 'submit', 'submit'));
$config_form->display();

echo '</fieldset>';
xoops_cp_footer();
