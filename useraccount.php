<?php
require_once 'conn.php';

$userid = '';
$name = '';
$mail = '';
$password = '';
$accesslevel = '';
if (isset($_GET['userid'])) {
 $sql = "SELECT * FROM cms_users WHERE user_id=" . $_GET['userid'];
 $result = mysql_query($sql,$conn)
  or die('Could not look up user data; ' . mysql_error());

 $row = mysql_fetch_array($result);
 $userid = $_GET['userid'];
 $name = $row['name'];
 $mail = $row['mail'];
 $accesslevel = $row['access_level'];
}

require_once 'header.php';

echo "<form method=\"post\" action=\"transact-user.php\">\n";

if ($userid) {
 echo "<h1>Modify Account</h1>\n";
} else {
 echo "<h1>Create Account</h1>\n";
}
?>

<p>
 Full name:<br />
 <input type="text" class="txtinput" name="name" maxlength="100"
  value="<?php echo htmlspecialchars($name); ?>" />
</p>
<p>
 E-mail Address:<br />
 <input type="text" class="txtinput" name="mail" maxlength="255"
  value="<?php echo htmlspecialchars($mail); ?>" />
</p>
<?php

if (isset($_SESSION['access_level'])
  and $_SESSION['access_level'] == 3)
{
 echo "<fieldset>\n";
 echo " <legend>Access Level</legend>\n";

 $sql = "SELECT * FROM cms_access_levels ORDER BY access_level DESC";
 $result = mysql_query($sql,$conn)
  or die('Could not list access levels; ' . mysql_error());

 while ($row = mysql_fetch_array($result)) {
  echo ' <input type="radio" class="radio" id="acl_' .
     $row['access_level'] . '" name="accesslevel" value="' .
     $row['access_level'] . '" ';

  if ($row['access_level'] == $accesslevel) {
   echo 'checked="checked" ';
  }
  echo '/>' . $row['access_name'] . "<br />\n";
 }
?>
</fieldset>
<p>
 <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
 <input type="submit" class="submit" name="action"
  value="Modify Account" />
</p>
<?php } else { ?>
<p>
 Password:<br />
 <input type="password" id="password" name="password" maxlength="50" />
</p>
<p>
 Password (again):<br />
 <input type="password" id="password2" name="password2" maxlength="50" />
</p>
<p>
 <input type="submit" class="submit" name="action"
  value="Create Account" />
</p>
<?php } ?>
</form>

<?php require_once 'footer.php'; ?>