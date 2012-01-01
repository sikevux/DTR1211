<?php
require_once 'conn.php';
require_once 'http.php';

if (isset($_REQUEST['action'])) {
 switch ($_REQUEST['action']) {
  case 'Login':
   if (isset($_POST['mail'])
     and isset($_POST['password']))
   {
    $sql = "SELECT user_id,access_level,name " .
        "FROM cms_users " .
        "WHERE mail='" . $_POST['mail'] . "' " .
        "AND password='" . hash_password($_POST['password'], $_POST['mail']) . "'";
    $result = mysql_query($sql,$conn)
     or die('Could not look up user information; ' . mysql_error());

    if ($row = mysql_fetch_array($result)) {
     session_start();
     $_SESSION['user_id'] = $row['user_id'];
     $_SESSION['access_level'] = $row['access_level'];
     $_SESSION['name'] = $row['name'];
    }
   }
   redirect('index.php');
   break;

  case 'Logout':
   session_start();
   session_unset();
   session_destroy();

   redirect('index.php');
   break;

  case 'Create Account':
   if (isset($_POST['name'])
     and isset($_POST['mail'])
     and isset($_POST['password'])
     and isset($_POST['password2'])
     and $_POST['password'] == $_POST['password2'])
   {
    $sql = "INSERT INTO cms_users (mail,name,password) " .
        "VALUES ('" . $_POST['mail'] . "','" .
        $_POST['name'] . "','" . hash_password($_POST['password'], $_POST['mail']) . "')";

    mysql_query($sql,$conn)
     or die('Could not create user account; ' . mysql_error());

    session_start();
    $_SESSION['user_id'] = mysql_insert_id($conn);
    $_SESSION['access_level'] = 1;
    $_SESSION['name'] = $_POST['name'];
   }
   redirect('index.php');
   break;

  case 'Modify Account':
   if (isset($_POST['name'])
     and isset($_POST['mail'])
     and isset($_POST['accesslevel'])
     and isset($_POST['userid']))
   {
    $sql = "UPDATE cms_users " .
        "SET mail='" . $_POST['mail'] .
        "', name='" . $_POST['name'] .
        "', access_level=" . $_POST['accesslevel'] . " " .
        " WHERE user_id=" . $_POST['userid'];

    mysql_query($sql,$conn)
     or die('Could not update user account; ' . mysql_error());
   }
   redirect('admin.php');
   break;

  case 'Send my reminder!':
   if (isset($_POST['mail'])) {
    $sql = "SELECT password FROM cms_users " .
        "WHERE mail='" . $_POST['mail'] . "'";

    $result = mysql_query($sql,$conn)
     or die('Could not look up password; ' . mysql_error());

    if (mysql_num_rows($result)) {
     $row = mysql_fetch_array($result);

     $subject = 'Password reminder';
     $body = "Just a reminder, your password for the " .
         "No. No. No\n\nYou can use this to log in at http://" .
         $_SERVER['HTTP_HOST'] .
         dirname($_SERVER['PHP_SELF']) . '/';

     mail($_POST['mail'],$subject,$body)
      or die('Could not send reminder mail.');
    }
   }
   redirect('login.php');
   break;

  case 'Change my info':
   session_start();

   if (isset($_POST['name'])
     and isset($_POST['mail'])
     and isset($_SESSION['user_id']))
   {
    $sql = "UPDATE cms_users " .
        "SET mail='" . $_POST['mail'] .
        "', name='" . $_POST['name'] . "' " .
        "WHERE user_id=" . $_SESSION['user_id'];

    mysql_query($sql,$conn)
     or die('Could not update user account; ' . mysql_error());
   }
   redirect('cpanel.php');
   break;
 }
}
?>