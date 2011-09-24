#!/usr/bin/env perl
use strict;
use warnings;
use DBI;
my $dbh;
my $i;
my $sth;
my $ref;
my $fortune = `/usr/games/fortune`;
$dbh = DBI->connect("DBI:mysql:database=junk;host=localhost", "root", "l0l", {'RaiseError' => 1});
$dbh->do("CREATE DATABASE IF NOT EXISTS junk");
$dbh->do("CREATE TABLE IF NOT EXISTS M00 (id MEDIUMINT NOT NULL AUTO_INCREMENT, quote VARCHAR(9001) NOT NULL, PRIMARY KEY (id))");
for($i=0; $i<3; $i++) {
	$dbh->do("INSERT INTO M00 (quote) VALUES(" . $dbh->quote($fortune) . ")");
$fortune = `/usr/games/fortune`;
}
$sth = $dbh->prepare("SELECT * FROM M00");
$sth->execute();
while($ref = $sth->fetchrow_hashref()) {
    print "Quote number $ref->{'id'}: $ref->{'quote'}\n";
}
$sth->finish();
$dbh->disconnect();
