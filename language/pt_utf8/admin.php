<?php

// Menu defines
define('_AM_XMYSHELL_ADMENU1', 'xMyShell Access');
define('_AM_XMYSHELL_ADMENU2', 'xMyShell Config');
// Config defines
define('_AM_XMYSHELL_CONFIG', 'Configuration');
define('_AM_MODULEADMIN', 'Module Admin:');
define('_AM_XMYSHELL', 'xMyShell');
define('_AM_XMYSHELL_SECURE', 'Secure<br><span style="font-weight: normal;font-size: xx-small;">If this option is set you will recieve<br>email notification if someone trys<br>unsuccesfully to access xMyShell.</span>');
define('_AM_XMYSHELL_SECUREUSER', 'Secure User<br><span style="font-weight: normal;font-size: xx-small;">Should be different from admin</span>');
define('_AM_XMYSHELL_SECUREOLDPSWD', 'Old Password<br><span style="font-weight: normal;font-size: xx-small;">Only if your changing the password</span>');
define('_AM_XMYSHELL_SECURENEWPSWD', 'New Password<br><span style="font-weight: normal;font-size: xx-small;">Only if your changing the password</span>');
define('_AM_XMYSHELL_DIRLIMIT', 'Directory Limit<br><span style="font-weight: normal;font-size: xx-small;">Set with care. A value of "/" will<br>give access to your root filesystem.</span>');
define(
    '_AM_XMYSHELL_ERRORTRAP',
    'Auto Error-Trapping<br><span style="font-weight: normal;font-size: xx-small;">Enable automatic error traping if<br>command returns error. Bear in<br>mind that MyShell executes the<br>command a second time in order to<br>trap the stderr. This shouldn\'t be a<br>problem in most cases. If you turn it<br>off, you\'ll have to select either to trap<br>stderr or not for every command you<br>excecute.</span>'
);
define('_AM_XMYSHELL_SUBMIT', 'Save Settings');
// Error Messages
define('_AM_XMYSHELL_AUTHERROR', '<h1>Access denied</h1><br>A warning message has been sent to the administrator.');
define('_AM_XMYSHELL_NOCHDIR', 'You are not allowed change to directories above %s. To change this limit edit your configuration settings');
define('_AM_XMYSHELL_DIRDENY', 'xMyShell: can\'t change directory. Permission denied. Switching back to %s.');
define('_AM_XMYSHELL_FILESAVED', 'xMyShell: %s saved');
define('_AM_XMYSHELL_SAVEERROR', 'xMyShell: Error while saving %s: %s.');
define('_AM_XMYSHELL_OPENDIRERROR', 'xMyShell: can\'t change directory. %s: does not exist or permission denied.');
define('_AM_XMYSHELL_FILEEDITINFO', '::Owner::%s::Permissions::%s');
define('_AM_XMYSHELL_FILEEDITINFO2', '::<b>NEW FILE</b>');
define('_AM_XMYSHELL_VOIDCOMMAND', 'xMyShell: %s: void command for xMyShell');
define('_AM_XMYSHELL_PASSSET', 'In order to set a new password you must give the old one.');
define('_AM_XMYSHELL_DBUPDATE', 'There was an error updating the config settings in the database.');
// Email Subject
define('_AM_XMYSHELL_MAILSUB', 'xMyShell Warning - Unauthorized Access');
// General index defines
define('_AM_XMYSHELL_CURRUSER', '<b>Current User</b>::<a href="#">%1$s</a> <input type="hidden" name=whoami value="%1$s">');
define('_AM_XMYSHELL_FILEEDITOR', '<b>xMyShell File Editor</b>::<b>File</b>::%s/%s%s');
define('_AM_XMYSHELL_FILEEDITOR2', '<b>Current Working Directory</b>::');
define('_AM_XMYSHELL_ROOT', 'Root');
define('_AM_XMYSHELL_READONLY', 'Read Only');
define('_AM_XMYSHELL_AUTOERRORTRAP', 'Auto error trapping enabled');
define('_AM_XMYSHELL_STDERR', 'stderr-traping');
define('_AM_XMYSHELL_COLS', 'Cols:');
define('_AM_XMYSHELL_ROWS', 'Rows:');
define('_AM_XMYSHELL_EDITMODE', '<input type="hidden" name="work_dir" value="%s"><br><b>Save file as:</b><input type="text" name="file" value="%s"><br>');
define('_AM_XMYSHELL_CURRDIR', 'Current Directory');
define('_AM_XMYSHELL_PARENTDIR', 'Parent Directory');
define('_AM_XMYSHELL_SAVE', 'Save');
define('_AM_XMYSHELL_SAVEEXIT', 'Save &amp; Exit');
define('_AM_XMYSHELL_RESTORE', 'Restore Original');
define('_AM_XMYSHELL_CANCEL', 'Cancel/Exit');
