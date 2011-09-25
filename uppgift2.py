#!/usr/bin/env python2.7

# Uppgift 2
# Written by Sikevux
# Kopimi license

# Hämta in sqlite
from sqlite3 import *

# Skapa databasen och anslut till den
connection = connect('skapaEnDatabas.db')
cursor = connection.cursor()


# Skapa tables med specificerad SQL
cursor.execute('''create table budbilar (regnr varchar(10) primary key unique not null, marke varchar(30) not null, modell varchar(30) not null, arsmodell varchar(6) not null, farg varchar(20) not null, metalic boolean default false)''')

cursor.execute('''create table bud (budnr int primary key unique, fornamn varchar(30) not null, efternamn varchar(30) not null, gatuadress varchar(30) not null, postnr varchar(6) not null, ort varchar(30) not null, telefon varchar(30) not null, anstalld date, check (budnr>100), check (budnr<200))''')

cursor.execute('''create table ordermottagare (omnr int primary key unique, check (omnr>300), check(omnr<400))''')

cursor.execute('''create table kunder(kundnr int primary key unique, fax varchar(30) not null, kmrpris int not null, check(kundnr>300), check(kundnr<400))''')

cursor.execute('''create table destinationer(destnr int primary key unique, fax varchar(30) not null, check(destnr>400), check(destnr<500))''')

# Denna biten av kod funkar inte, men borde inte finnas heller.
# Borde användas ett gäng SELECTs istället.
# Bara för att man kan spara i databasen så måste man ju inte göra det.
cursor.execute('''create table order(omnr int primary key, kundnr int, destnr int, budnr int, regnr varchar(10), ordernr int autoincrement, orderdatum date not null, leverans date not null, foreign key(omnr) references ordermottagare(omnr), foreign key(kundnr) references kunder(kundnr), foreign key(destnr) references destinationer(destnr), foreign key(budnr) references bud(budnr), foreign key(regnr) references budbilar(regnr))''')

# Fyll tabels med data
for x in range(0,9):
	cursor.execute('''insert into budbilar values('XXX 6'''(x)'''6', 'BMW', 'X'''(x)'''', '2009', 'Blue', 'true')''')
cursor.execute('''insert into budbilar values('XXX 610', 'DERP', 'HD', '2100', 'Pink', 'false')''')

for x in range(1,6):
	cursor.execute('''insert into bud values('10'''(x)'''', "Herp", "Derp", "Somestreet", "66666", "Derptown", "1234567890", "1970-01-01")''')

for x in range(1,4):
	cursor.execute('''insert into ordermottagare values("30'''(x)'''", "1234567890", "9")''')

for x in range(1,10):
	cursor.execute('''insert into kunder values("30'''(x)'''", "1234567890", "9")''')
cursor.execute('''insert into kunder values("310", "1234567890", "99")''')

for x in range(1,10):
	cursor.execute('''insert into destinationer values("40'''(x)'''", "1234567890")''')
cursor.execute('''insert into destinationer values("410", "999999999")''')
#		20 order
#			cursor.execute('''insert into order values(

# Som en sista säkerhetsåtgärd, se till att commita alla ändringar till databasen
connection.commit()
