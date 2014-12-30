create table user(
	uid int primary key,
	userName char(20),
	password char(64)
)Type=InnoDB DEFAULT CHARSET=utf8;

create table example(
	eid int primary key,
	example text,
	comp int,
	marked int
)Type=InnoDB DEFAULT CHARSET=utf8;

create table result(
	rid Bigint primary key,
	eid int,
	content text,
	obj int,
	subj int,
	neutral int,
	res int
)Type=InnoDB DEFAULT CHARSET=utf8;	

create table superUser(
	uid int
)Type=InnoDB DEFAULT CHARSET=utf8;

create table markRecord(
	uid int,
	eid int,
	stat text,
	time datetime,
	index(uid),
	index(eid)
)Type=InnoDB DEFAULT CHARSET=utf8;

create table system(
	item char(50),
	val text,
	index(item)
);