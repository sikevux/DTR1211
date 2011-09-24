#!/usr/bin/env python2.7
# Kopimi license
# Created by Sikevux

from sqlite3 import *

connection = connect('skapaEnDatabas.db')
cursor = connection.cursor()

cursor.execute('''create table budbilar (regnr varchar(10) primary key unique not null, marke varchar(30) not null, modell varchar(30) not null, arsmodell varchar(6) not null, farg varchar(20) not null, metalic boolean default false)''')

cursor.execute('''create table bud (budnr int primary key unique, fornamn varchar(30) not null, efternamn varchar(30) not null, gatuadress varchar(30) not null, postnr varchar(6) not null, ort varchar(30) not null, telefon varchar(30) not null, anstalld date, check )budnr>100), check (budnr<200))''')

cursor.execute('''create table ordermottagare (omnr int primary keyunique, check (omnr>300), check(omnr<400))''')

cursor.execute('''create table kunder(kundnr int primary key unique, fax varchar(30) not null, kmrpris int notnull, check(kundnr>300), check(kundnr<400))''')

cursor.execute('''create table destinationer(destnr int primary key unique, fax varchar(30) not null, check(destnr>400), check(destnr<500))''')

""" Todo:
	Table Order
		omnr
		kundnr
		destnr
		budnr
		regnr
		ordernr - int autoincrement
		orderdatum - date notnull
		leverans - date notnull
	Data
		10 bilar
			cursor.execute('''insert into budbilar values('XXX 666', 'BMW', 'X6', '2009', 'Blue', 'true')''')
		5 bud
		3 ordermottagare
		10 företagskunder
		10 destinationer
		20 order

"""
