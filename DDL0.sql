create table User
(
	ID			varchar(16), 
	Name		varchar(16),
	Descreption	text,
	Mail		varchar(16),
	Password	varchar(16),
	ProPic		varchar(32),
	primary key (ID)
);

create table Pics
(
	ID			int NOT NULL AUTO_INCREMENT,
	Title		varchar(16),
	Image 		text,
	Uploader 	varchar(16),
	Descreption	text,
	Loaction	text,
	Width		varchar(16),
	Height		varchar(16),
	AuthType	varchar(16),
	Type 		varchar(16),	
	primary key (ID),
	foreign key	(Uploader) references User(ID) on delete cascade
);

create table Collect
(
	Pic_ID			int NOT NULL,
	UserID			varchar(16)  NOT NULL,
	primary key (Pic_ID,UserID),
	foreign key	(Pic_ID) references Pics(ID) on delete cascade,
	foreign key	(UserID) references User(ID) on delete cascade
);

create table Tag
(
	Name		varchar(16) NOT NULL,
	primary key (Name)
);

create table Pic_Tag
(
	Pic_ID		int NOT NULL,
	Tag_Name	varchar(16),
	primary key (Pic_ID,Tag_Name),
	foreign key	(Pic_ID) references Pics(ID) on delete cascade,
	foreign key	(Tag_Name) references Tag(Name) on delete cascade
);
