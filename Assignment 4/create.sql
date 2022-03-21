# Initializes the TA portal tables
DROP DATABASE portal;
CREATE DATABASE portal;

use portal;

CREATE TABLE Users(
    uid INT NOT NULL AUTO_INCREMENT,
    firstname CHAR(255) NOT NULL,
    lastname CHAR(255) NOT NULL,
    email CHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY(uid)
);

CREATE TABLE TAStudents(
    uid INT NOT NULL AUTO_INCREMENT,
    mnum CHAR(255) NOT NULL,
    semester INT NOT NULL,
    major CHAR(255) NOT NULL,
    PRIMARY KEY(mnum),
    FOREIGN KEY(uid) REFERENCES Users(uid)
    ON DELETE CASCADE
);

CREATE TABLE Professors(
    uid INT NOT NULL AUTO_INCREMENT,
    profid CHAR(255),
    faculty CHAR(255),
    PRIMARY KEY(profid),
    FOREIGN KEY(uid) REFERENCES Users(uid)
    ON DELETE CASCADE
);

CREATE TABLE Contracts(
    contractid CHAR(255) NOT NULL,
    startdate DATE NOT NULL,
    enddate DATE NOT NULL,
    mnum CHAR(255) NOT NULL,
    PRIMARY KEY(contractid, mnum),
    FOREIGN KEY(mnum) REFERENCES TAStudents(mnum)
);

CREATE TABLE Courses(
    courseid INT NOT NULL AUTO_INCREMENT,
    shortname CHAR(100) NOT NULL,
    longname CHAR(255) NOT NULL,
    PRIMARY KEY(courseid)
);

CREATE TABLE Tasks(
    tid INT NOT NULL AUTO_INCREMENT,
    title CHAR(100),
    description CHAR(255),
    completed BOOL DEFAULT FALSE,
    PRIMARY KEY(tid)
);

CREATE TABLE Homeworks(
    tid INT NOT NULL AUTO_INCREMENT,
    deadline DATE NOT NULL,
    PRIMARY KEY(tid),
    FOREIGN KEY(tid) REFERENCES Tasks(tid)
    ON DELETE CASCADE
);

CREATE TABLE Tutorials(
    tid INT NOT NULL AUTO_INCREMENT,
    date DATE NOT NULL,
    starttime TIME NOT NULL,
    endtime TIME NOT NULL,
    PRIMARY KEY(tid),
    FOREIGN KEY(tid) REFERENCES Tasks(tid)
    ON DELETE CASCADE
);

CREATE TABLE Created(
    profid CHAR(255),
    tid INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (profid, tid),
    FOREIGN KEY(profid)
        REFERENCES Professors(profid)
        ON DELETE CASCADE,
    FOREIGN KEY(tid)
        REFERENCES Tasks(tid)
        ON DELETE CASCADE
);

CREATE TABLE Assigned_To(
	mnum CHAR(255) NOT NULL,
	tid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(mnum, tid),
	FOREIGN KEY(mnum) REFERENCES TAStudents(mnum) ON DELETE CASCADE,
	FOREIGN KEY(tid) REFERENCES Tasks(tid) ON DELETE CASCADE
);

CREATE TABLE Teaches(
	profid CHAR(255) NOT NULL,
	courseid INT NOT NULL,
	PRIMARY KEY(profid, courseid),
	FOREIGN KEY(profid) REFERENCES Professors(profid) ON DELETE CASCADE,
	FOREIGN KEY(courseid) REFERENCES Courses(courseid) ON DELETE CASCADE
);

CREATE TABLE TA_For(
	mnum CHAR(255) NOT NULL,
	courseid INT NOT NULL,
	contractid CHAR(255) NOT NULL,
	PRIMARY KEY(mnum, courseid),
	FOREIGN KEY(mnum) REFERENCES TAStudents(mnum) ON DELETE CASCADE,
	FOREIGN KEY(courseid) REFERENCES Courses(courseid) ON DELETE CASCADE,
	FOREIGN KEY(contractid) REFERENCES Contracts(contractid) ON DELETE CASCADE
);

CREATE TABLE Belongs_To(
	tid INT NOT NULL AUTO_INCREMENT,
	courseid INT NOT NULL,
	PRIMARY KEY(tid, courseid),
	FOREIGN KEY(tid) REFERENCES Tasks(tid) ON DELETE CASCADE,
	FOREIGN KEY(courseid) REFERENCES Courses(courseid) ON DELETE CASCADE
);

CREATE TABLE Admins(
    aid INT NOT NULL AUTO_INCREMENT,
    username CHAR(255) NOT NULL,
    pass CHAR(255) NOT NULL,
    PRIMARY KEY(aid)
);