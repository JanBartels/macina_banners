#
# Table structure for table 'tt_content'
#
# medialights: changed type of placement
# old setting: "tx_macinabanners_placement varchar(50) DEFAULT '' NOT NULL,"
CREATE TABLE tt_content (
	tx_macinabanners_placement blob NOT NULL,
	tx_macinabanners_mode varchar(10) DEFAULT '' NOT NULL
);

#
# Table structure for table 'tx_macinabanners_banners'
#
# medialights: changed type of placement
# old setting: "placement varchar(50) DEFAULT '' NOT NULL,"
CREATE TABLE tx_macinabanners_banners (
	uid int(11) DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(10) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	t3ver_oid int(11) unsigned DEFAULT '0' NOT NULL,
	t3ver_id int(11) unsigned DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	customer tinytext NOT NULL,
	bannertype int(11) unsigned DEFAULT '0' NOT NULL,
	image blob NOT NULL,
	maxw int(11) DEFAULT '0' NOT NULL,
	alttext tinytext NOT NULL,
	url tinytext NOT NULL,
	swf blob NOT NULL,
	flash_width int(11) DEFAULT '0' NOT NULL,
	flash_height int(11) DEFAULT '0' NOT NULL,
	html text NOT NULL,
	placement blob NOT NULL,
	border_top int(11) DEFAULT '0' NOT NULL,
	border_right int(11) DEFAULT '0' NOT NULL,
	border_bottom int(11) DEFAULT '0' NOT NULL,
	border_left int(11) DEFAULT '0' NOT NULL,
	pages blob NOT NULL,
	recursiv tinyint(4) unsigned DEFAULT '0' NOT NULL,
	excludepages blob NOT NULL,
	impressions tinytext NOT NULL,
	clicks tinytext NOT NULL,
	parameters text NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_macinabanners_categories'
#
# medialights: new table for banner categories
CREATE TABLE tx_macinabanners_categories (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	description varchar(255) DEFAULT '' NOT NULL,
	icon blob NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);