<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*
|--------------------------------------------------------------------------
| Constants For URL
|--------------------------------------------------------------------------
|
*/
// URL Umum
define('FAQ', strtolower('frequently-asked-questions'));
define('CHECKSTATUS', strtolower('checkstatus'));

// URL Applicant (UA)
define('UA_LOGIN', strtolower('login'));
define('UA_LOGOUT', strtolower('logout'));
define('UA_REGISTRATION', strtolower('register'));
define('UA_RESETPASSWORD', strtolower('resetpassword'));
define('UA_FORGOTPASSWORD', strtolower('forgotpassword'));
define('UA_VERIFY', strtolower('verify'));
define('UA_CHANGEPASSWORD', strtolower('changepassword'));
define('UA_PROFILE', strtolower('profil'));
define('UA_EDITPROFILE', strtolower('edit-profil'));
define('UA_TRANSACTION', strtolower('form-transaksi'));
define('UA_TRANSHISTORY', strtolower('transaksi'));
define('UA_TRANSACTIONDETAIL', strtolower('detail-transaksi'));
define('UA_SCHEDULE', strtolower('form-jadwal'));
define('UA_SCHEHISTORY', strtolower('jadwal-pertemuan'));
define('UA_RATINGS', strtolower('survey-kepuasan'));
define('UA_COMPLAINT', strtolower('komplain-pelanggan'));

//URL Employee (UE)
define('UE_FOLDER', strtolower('employee'));
define('UE_ADMIN', strtolower('administrator'));
define('UE_LOGIN', strtolower(UE_ADMIN . '/login'));
define('UE_LOGOUT', strtolower(UE_ADMIN . '/logout'));
define('UE_CHANGEPASSWORD', strtolower(UE_ADMIN . '/' . 'changepassword'));
define('UE_EDITPROFILE', strtolower(UE_ADMIN . '/' . 'edit-profil'));
define('UE_EMPLOYEE', strtolower(UE_ADMIN . '/' . 'employee'));
define('UE_APPLICANT', strtolower(UE_ADMIN . '/' . 'applicant'));
define('UE_JOBCAT', strtolower(UE_ADMIN . '/' . 'jobcategory'));
define('UE_POSITION', strtolower(UE_ADMIN . '/' . 'position'));
define('UE_TRANSACTION', strtolower(UE_ADMIN . '/' . 'transaction'));
define('UE_TRANSACTIONDETAIL', strtolower(UE_ADMIN . '/' . 'detail-transaksi'));
define('UE_SCHEDULE', strtolower(UE_ADMIN . '/' . 'schedule'));
define('UE_REQTYPE', strtolower(UE_ADMIN . '/' . 'request-type'));
define('UE_REQSUBTYPE', strtolower(UE_ADMIN . '/' . 'request-subtype'));
define('UE_RATINGS', strtolower(UE_ADMIN . '/' . 'customer-ratings'));
define('UE_CANDS', strtolower(UE_ADMIN . '/' . 'kritik-saran'));
define('UE_COMPLAINT', strtolower(UE_ADMIN . '/' . 'complaint'));
define('UE_MANAGEFAQ', strtolower(UE_ADMIN . '/' . 'kelola-faq'));
define('UE_REPORTTRANSRATE', strtolower(UE_ADMIN . '/' . 'report-transaction-rates'));
define('UE_REPORTTRANSNONRATE', strtolower(UE_ADMIN . '/' . 'report-transaction-nonrates'));
define('UE_REPORTRATINGS', strtolower(UE_ADMIN . '/' . 'report-ratings'));
define('UE_ADD', strtolower('/tambah'));
define('UE_UPDATE', strtolower('/edit'));
define('UE_VERIFY', strtolower(UE_ADMIN . '/verify'));
define('UE_CONFIGURATION', strtolower(UE_ADMIN . '/' . 'konfigurasi'));
