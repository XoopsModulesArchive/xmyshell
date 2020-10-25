<?php

$xMyShellVersion = 'xMyShell 1.0 alpha';
// $Id: index.php,v 1.3 2006/03/27 08:14:51 mikhail Exp $
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

// Includes
require dirname(__DIR__, 3) . '/include/cp_header.php';
require dirname(__DIR__, 3) . '/class/xoopsmailer.php';
require __DIR__ . '/admin_header.php';

// Output header
xoops_cp_header();

// Get xMyShell configuration array
$sql_xMyShell_config = 'SELECT * FROM ' . $xoopsDB->prefix('xmyshell_config') . ' WHERE id=1';
$query_xMyShell_config = $xoopsDB->query($sql_xMyShell_config);
$xMyShell_config = $xoopsDB->fetchArray($query_xMyShell_config);
// Get admin's email address
$sql_admin_email = 'SELECT conf_value FROM ' . $xoopsDB->prefix('config') . " WHERE conf_name='adminmail'";
$query_admin_email = $xoopsDB->query($sql_admin_email);
$admin_email = $xoopsDB->fetchArray($query_admin_email);

// BGN|Admin menu|Fieldset
adminmenu(0, 'Run');
echo "<fieldset style=' background-color: #ECECEC; color: #000'><legend style='font-weight: bold; color: #900;'>" . _AM_XMYSHELL . '</legend>';

// Use self security?
$selfSecure = $xMyShell_config['selfsecure'];
$shellUser = $xMyShell_config['shelluser'];
$shellPswd = $xMyShell_config['shellpswd'];

// Set emails
$adminEmail = $admin_email['conf_value'];
$fromEmail = $adminEmail;

// Make sure that a directory limit is set, if not give it a default "safe" value.
if (!$xMyShell_config['dirlimit']) {
    $dirLimit = $_SERVER['DOCUMENT_ROOT'];
} else {
    $dirLimit = $xMyShell_config['dirlimit'];
}

// Turn error trapping on/off
$autoErrorTrap = $xMyShell_config['errortrap'];

// commands that will not be executed.
$voidCommands = ['top', 'xterm', 'su', 'vi', 'pico', 'netscape', 'mozilla'];

$TexEd = 'edit';

$editWrap = "wrap='OFF'";

$termCols = 80;            //Default width of the output text area
$termRows = 20;            //Default heght of the output text area

if (!isset($command)) {
    $command = 'ls -a';
}
if ($command && get_magic_quotes_gpc()) {
    $command = stripslashes($command);
}
if ($selfSecure) {
    if (($_SERVER['PHP_AUTH_USER'] != $shellUser) || ($_SERVER['PHP_AUTH_PW'] != $shellPswd)) {
        header('WWW-Authenticate: Basic realm="xMyShell"');

        header('HTTP/1.0 401 Unauthorized');

        echo _AM_XMYSHELL_AUTHERROR . '<HR><em>' . $xMyShellVersion . '</em>';

        $xoopsMailer = getMailer();

        $xoopsMailer->useMail();

        $xoopsMailer->setTemplateDir('../language/' . $xoopsConfig['language'] . '/mail_template');

        $xoopsMailer->setTemplate('admin_warning.php');

        $xoopsMailer->setToEmails($admin_email['conf_value']);

        $xoopsMailer->setFromEmail($admin_email['conf_value']);

        $xoopsMailer->setFromName($xMyShellVersion);

        $xoopsMailer->setSubject(_AM_XMYSHELL_MAILSUB);

        $xoopsMailer->assign('VERSION', $xMyShellVersion);

        $xoopsMailer->assign('SITE', XOOPS_URL . '/');

        $xoopsMailer->assign('DATE', date('Y-m-d H:i:s'));

        $xoopsMailer->assign('IP', $_SERVER['REMOTE_ADDR']);

        $xoopsMailer->assign('AGENT', $_SERVER['HTTP_USER_AGENT']);

        $xoopsMailer->assign('AUTH_USER', $_SERVER['PHP_AUTH_USER']);

        $xoopsMailer->assign('AUTH_PASS', $_SERVER['PHP_AUTH_PW']);

        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $xoopsMailer->send();
        }

        exit;
    }
}
// Function that validate directories
function validate_dir($dir)
{
    global $dirLimit;

    if ($dirLimit) {
        $cdPos = mb_strpos($dir, $dirLimit);

        if ('' == (string)$cdPos) {
            $dir = $dirLimit;

            $GLOBALS['shellOutput'] = sprintf(_AM_XMYSHELL_NOCHDIR, $dirLimit);
        }
    }

    return $dir;
}

// Set working directory.
if (isset($work_dir)) {
    // A workdir has been asked for - we chdir to that dir.

    $work_dir = validate_dir($work_dir);

    @chdir($work_dir) or ($shellOutput = sprintf(_AM_XMYSHELL_DIRDENY, $_SERVER['DOCUMENT_ROOT']));

    $work_dir = exec('pwd');
} else {
    // No work_dir - we chdir to $DOCUMENT_ROOT

    $work_dir = validate_dir($_SERVER['DOCUMENT_ROOT']);

    chdir($work_dir);

    $work_dir = exec('pwd');
}

// Now we handle files if we are in Edit Mode
if (!isset($editMode)) {
    $editMode = '';
}
if ($editMode && ($command || $editCancel)) {
    $editMode = false;
}
if ($editMode) {
    if ($editSave || $editSaveExit) {
        if (function_exists(ini_set)) {
            ini_set('track_errors', '1');
        }

        if ($fp = @fopen($file, 'wb')) {
            if (function_exists('get_magic_quotes_gpc') && @get_magic_quotes_gpc()) {
                $shellOut = stripslashes($shellOut);
            }

            fwrite($fp, $shellOut);

            fclose($fp);

            $command = $TexEd . ' ' . $file;

            if ($editSaveExit) {
                $command = '';

                $shellOutput = sprintf(_AM_XMYSHELL_FILESAVED, $file);

                $editMode = false;
            }
        } else {
            $command = '';

            $shellOutput = sprintf(_AM_XMYSHELL_SAVEERROR, $file, $php_errormsg);

            $errorSave = true;
        }
    }
}

// Separate command(s) and arguments to analyze first command
$input = explode(' ', $command);
while (list($key, $val) = each($voidCommands)) {
    if ($input[0] == $val) {
        $voidCmd = $input[0];

        $input[0] = 'void';
    }
}
switch ($input[0]) {
    case 'cd':
        $path = $input[1];
        if ('..' == $path) {
            $work_dir = strrev(mb_substr(mb_strstr(strrev($work_dir), '/'), 1));

            if ('' == $work_dir) {
                $work_dir = '/';
            }
        } elseif ('/' == mb_substr($path, 0, 1)) {
            $work_dir = $path;
        } else {
            $work_dir .= '/' . $path;
        }
        $work_dir = validate_dir($work_dir);
        @chdir($work_dir) or ($shellOutput = sprintf(_AM_XMYSHELL_OPENDIRERROR, $work_dir));
        $work_dir = exec('pwd');
        $commandBk = $command;
        $command = '';
        break;
    case 'man':
        exec($command, $man);
        if ($man) {
            $codes = '.' . chr(8);

            $manual = implode("\n", $man);

            $shellOutput = preg_replace($codes, '', $manual);

            $commandBk = $command;

            $command = '';
        } else {
            $stderr = 1;
        }
        break;
    case 'cat':
        exec($command, $cat);
        if ($cat) {
            $text = implode("\n", $cat);

            $shellOutput = htmlspecialchars($text, ENT_QUOTES | ENT_HTML5);

            $commandBk = $command;

            $command = '';
        } else {
            $stderr = 1;
        }
        break;
    case 'more':
        exec($command, $cat);
        if ($cat) {
            $text = implode("\n", $cat);

            $shellOutput = htmlspecialchars($text, ENT_QUOTES | ENT_HTML5);

            $commandBk = $command;

            $command = '';
        } else {
            $stderr = 1;
        }
        break;
    case $TexEd:
        if (file_exists($input[1])) {
            exec('cat ' . $input[1], $cat);

            $text = implode("\n", $cat);

            $shellOutput = htmlspecialchars($text, ENT_QUOTES | ENT_HTML5);

            $fileOwner = posix_getpwuid(fileowner($input[1]));

            $filePerms = sprintf('%o', (fileperms($input[1])) & 0777);

            $fileEditInfo = sprintf(_AM_XMYSHELL_FILEEDITINFO, $fileOwner['name'], $filePerms);
        } else {
            $fileEditInfo = _AM_XMYSHELL_FILEEDITINFO2;

            $currFile = $input[1];

            $editMode = true;

            $command = '';
        }
        break;
    case 'void':
        $shellOutput = sprintf(_AM_XMYSHELL_VOIDCOMMAND, $voidCmd);
        $commandBk = $command;
        $command = '';
}

// Now we prepare the webpage
if (!isset($oCols)) {
    $oCols = $termCols;
}
if (!isset($oRows)) {
    $oRows = $termRows;
}
if ($editMode) {
    $focus = 'shellOut.focus()';
} else {
    $focus = 'command.select()';
}

// WhoamI
if (!isset($whoami)) {
    $whoami = exec('whoami');
}
?>
    <style>
        input, select, option {
            background-color: #000000;
            color: #FFFFFF;
            border-style: none;
            font-size: 10px;
        }

        textarea {
            background-color: #000000;
            color: #FFFFFF;
            border-style: none;
        }
    </style>
    <form name="shell" method="post">
        <?php
        echo sprintf(_AM_XMYSHELL_CURRUSER, $whoami);

        if (!isset($url)) {
            $url = '';
        }
        if ($editMode) {
            echo sprintf(_AM_XMYSHELL_FILEEDITOR, $work_dir, $currFile, $fileEditInfo);
        } else {
            echo _AM_XMYSHELL_FILEEDITOR2;

            $work_dir_splitted = explode('/', mb_substr($work_dir, 1));

            echo '<a href="' . $_SERVER['PHP_SELF'] . '?work_dir=' . urlencode($url) . '/&command=' . urlencode($command) . '">' . _AM_XMYSHELL_ROOT . '</a>/';

            if ('' == $work_dir_splitted[0]) {
                $work_dir = '/';  /* Root directory. */
            } else {
                for ($i = 0, $iMax = count($work_dir_splitted); $i < $iMax; $i++) {
                    $url .= '/' . $work_dir_splitted[$i];

                    echo '<a href="' . $_SERVER['PHP_SELF'] . '?work_dir=' . urlencode($url) . '&command=' . urlencode($command) . '">' . $work_dir_splitted[$i] . '</a>/</strong>';
                }
            }
        }
        ?>
        <table width="100%" cellpadding="0" cellspacing="2" border="0">
            <tr>
                <td valign="top" width="58%">
                    <br>
                    <textarea name="shellOut" cols=<?php echo $oCols; ?> rows=<?php echo $oRows . '"';
                    if (!$editMode) {
                        echo _AM_XMYSHELL_READONLY;
                    } else {
                        echo $editWrap;
                    }
                    ?>
		>
<?php
if (!isset($shellOutput)) {
                        $shellOutput = '';
                    }
if (!isset($stderr)) {
    $stderr = '';
}
echo $shellOutput;
if ($command) {
    if ($stderr) {
        system($command . ' 1> /tmp/output.txt 2>&1; cat /tmp/output.txt; rm /tmp/output.txt');
    } else {
        $ok = system($command, $status);

        if (false === $ok && $status && $autoErrorTrap) {
            system($command . ' 1> /tmp/output.txt 2>&1; cat /tmp/output.txt; rm /tmp/output.txt');
        }
    }
}
if (!isset($commandBk)) {
    $commandBk = '';
}
if ($commandBk) {
    $command = $commandBk;
}
?>
</textarea>
                    <br>
                    <input type="text" name="command" size="80"
                        <?php
                        if (!isset($echoCommand)) {
                            $echoCommand = '';
                        }
                        if ($command && $echoCommand) {
                            echo "value=`$command`";
                        }
                        ?>>
                    <input name="submit_btn" type="submit" value="Go!">
                </td>
                <td valign="top" align="center">
                    <?php
                    if ($autoErrorTrap) {
                        echo '<br><strong>' . _AM_XMYSHELL_AUTOERRORTRAP . '</strong><br><br>';
                    } else {
                        echo '<input type="checkbox" name="stderr">' . _AM_XMYSHELL_STDERR . '<br><br>';
                    }
                    ?>
                    <strong>Echo Commands:</strong><input type="checkbox" name="echoCommand"
                        <?php
                        if ($echoCommand) {
                            echo ' checked';
                        }
                        ?>>
                    <br><br>
                    <strong><?php echo _AM_XMYSHELL_COLS ?></strong><input type="text" name="oCols" size=3 value=<?php echo $oCols; ?>>&nbsp;<strong><?php echo _AM_XMYSHELL_ROWS ?></strong><input type="text" name="oRows" size=2 value=<?php echo $oRows; ?>>

                    <?php
                    if ($editMode) {
                        echo sprintf(_AM_XMYSHELL_EDITMODE, $work_dir, $currFile);
                    } else {
                        echo '<br><br><strong>' . _AM_XMYSHELL_FILEEDITOR2 . '</strong><br><select name="work_dir" onChange="this.form.submit()">';

                        // List of directories.

                        $dir_handle = opendir($work_dir);

                        while ($dir = readdir($dir_handle)) {
                            if (is_dir($dir)) {
                                if ('.' == $dir) {
                                    echo '<option value="' . $work_dir . '" selected>' . _AM_XMYSHELL_CURRDIR . '</option>' . "\n" . '';
                                } elseif ('..' == $dir) {
                                    // Parent Dir. This might be server's root directory

                                    if (1 == mb_strlen($work_dir)) {
                                        // work_dir is only 1 charecter - it can only be / so don't output anything
                                    } elseif (0 == mb_strrpos($work_dir, '/')) {
                                        // we have a top-level directory eg. /bin or /home etc...

                                        echo '<option value="/">' . _AM_XMYSHELL_PARENTDIR . '</option>' . "\n" . '';
                                    } else {
                                        // String-manipulation to find the parent directory... Trust me - it works :-)

                                        echo '<option value="' . strrev(mb_substr(mb_strstr(strrev($work_dir), '/'), 1)) . '">' . _AM_XMYSHELL_PARENTDIR . '</option>' . "\n" . '';
                                    }
                                } else {
                                    if ('/' == $work_dir) {
                                        echo '<option value="' . $work_dir . '' . $dir . '">' . $dir . '</option>' . "\n" . '';
                                    } else {
                                        echo '<option value="' . $work_dir . '/' . $dir . '">' . $dir . '</option>' . "\n" . '';
                                    }
                                }
                            }
                        }

                        closedir($dir_handle);

                        echo '</select>';
                    }

                    if ($editMode) {
                        echo '
		<input type="submit" name="editSave" value="' . _AM_XMYSHELL_SAVE . '">&nbsp;
 		<input type="submit" name="editSaveExit" value="' . _AM_XMYSHELL_SAVEEXIT . '"><br>
 		<input type="reset" value="' . _AM_XMYSHELL_RESTORE . '">&nbsp;
 		<input type="submit" name="editCancel" value="' . _AM_XMYSHELL_CANCEL . '"><br>
 		<input type="hidden" name="editMode" value="true"><br>';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </form>
<?php
// END|Admin Menu|Fieldset
echo '</fieldset>';

// Output footer
xoops_cp_footer();
?>
