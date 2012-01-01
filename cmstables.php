<?php
require_once 'conn.php';

$sql = <<<EOS
CREATE TABLE IF NOT EXISTS cms_access_levels (
 access_level tinyint(4) NOT NULL auto_increment,
 access_name varchar(50) NOT NULL default '',
 PRIMARY KEY (access_level)
)
EOS;
$result = mysql_query($sql) or die(mysql_error());

$sql = "INSERT IGNORE INTO cms_access_levels
 VALUES (1,'User')";
$result = mysql_query($sql) or die(mysql_error());
$sql = "INSERT IGNORE INTO cms_access_levels
 VALUES (2,'Moderator')";
$result = mysql_query($sql) or die(mysql_error());
$sql = "INSERT IGNORE INTO cms_access_levels
 VALUES (3,'Administrator')";
$result = mysql_query($sql) or die(mysql_error());

$sql = <<<EOS
CREATE TABLE IF NOT EXISTS cms_articles (
 article_id int(11) NOT NULL auto_increment,
 author_id int(11) NOT NULL default '0',
 is_published tinyint(1) NOT NULL default '0',
 date_submitted datetime NOT NULL default '0000-00-00 00:00:00',
 date_published datetime NOT NULL default '0000-00-00 00:00:00',
 title varchar(255) NOT NULL default '',
 body mediumtext NOT NULL,
 PRIMARY KEY (article_id),
 KEY IdxArticle (author_id,date_submitted),
 FULLTEXT KEY IdxText (title,body)
)
EOS;
$result = mysql_query($sql) or die(mysql_error());

$sql = <<<EOS
CREATE TABLE IF NOT EXISTS cms_comments (
 comment_id int(11) NOT NULL auto_increment,
 article_id int(11) NOT NULL default '0',
 comment_date datetime NOT NULL default '0000-00-00 00:00:00',
 comment_user int(11) NOT NULL default '0',
 comment text NOT NULL,
 PRIMARY KEY (comment_id),
 KEY IdxComment (article_id)
)
EOS;
$result = mysql_query($sql) or die(mysql_error());

$sql = <<<EOS
CREATE TABLE IF NOT EXISTS cms_users (
 user_id int(11) NOT NULL auto_increment,
 mail varchar(255) NOT NULL default '',
 password varchar(50) NOT NULL default '',
 name varchar(100) NOT NULL default '',
 access_level tinyint(4) NOT NULL default '1',
 PRIMARY KEY (user_id),
 UNIQUE KEY uniq_mail (mail)
)
EOS;
$result = mysql_query($sql) or die(mysql_error());

$adminmail = "sikevux@sikevux.se";
$adminpass = "admin";
$adminname = "Admin";

$sql = "INSERT IGNORE INTO cms_users VALUES (NULL,
 '$adminmail', '". hash_password($adminpass, $adminmail). "', '$adminname', 3)";
$result = mysql_query($sql) or die(mysql_error());

echo "<html><head><title>CMS Tables Created</title></head><body>";
echo "CMS Tables created. Here is your initial login information:\n";
echo "<ul><li><strong>login</strong>: " . $adminmail . "</li>\n";
echo "<li><strong>password</strong>: " . $adminpass . "</li></ul>\n";
echo "<a href='login.php'>Login</a> to the site now.";
echo "</body></html>"
?>