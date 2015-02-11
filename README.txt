eStudio Scheduling App - READ ME

Tutor Login
Default Email: tutor@tutor.com
password: mypassword

Admin Login
Default Email: admin@admin.com
password: mypassword

Installation Guide
1.	Where Do I put the webpages?
To simply put the webpages on the server of your choice. For the beta-testing phase of this project we used the following 
Server: scheduling.engr.uky.edu
Username: beta
Password: Riio$_284x
Login and put all of the php, css, html, and images contained on the CD on this, or another server of your choice. (For separate testing and modification, we recommend keeping a backup of the original working code for beta-testing on that server and using a multilab machine for the new testing. 


2.	Where Do I put the backend PHP?
As mentioned above all of the PHP also goes in the same spot on the server. 

3.Setup MySQL Database
To setup the MySQL database login to the server and start MySQL, using 
mysql –h localhost –u beta –p estudio_beta
database Name: estudio_beta
Input the password: MV.gVfRNzc
*Note all mysql commands must be terminated by a semicolon.*
 To then setup the tables, use the create tables code, from the data structure section above (listed again below), or load all of that code into a build_tables.sql, which then you can create by using mysql –h mysql –p < build_tables.sql . 

//Create the Client Table
CREATE TABLE Client (
	LastName varchar(30) NOT NULL,
	FirstName varchar(30) NOT NULL, 
	StudentID varchar(10) NOT NULL,
	Major varchar(30) NOT NULL, 
	Year varchar(30) NOT NULL,
	English boolean,
	EmailAddress varchar(40) NOT NULL, 
	Password varchar(30) NOT NULL,
	PRIMARY KEY(StudentID) );
	
//Create the Tutor Table	
CREATE TABLE Tutor (
	tLastName varchar(30) NOT NULL,
	tFirstName varchar(30) NOT NULL,
	Email varchar(40) NOT NULL,
	Password varchar(30) NOT NULL,
	IsAdmin boolean,
	PRIMARY KEY(Email) );

//Create the Appointment Table
CREATE TABLE Appointment(
	Email varchar(40),
	StudentID varchar(10),
	StartTime DATETIME,
	Duration int, 
	GroupSize int, 
	FirstTimeVisit tinyint,
	Comment varchar(120),
	HelpService varchar(35),
	FOREIGN KEY (StudentID) references Client(StudentID), 
	FOREIGN KEY (Email) references Tutor(Email) );


//Create The Times Table
CREATE TABLE Times (
	StartTime TIME,
	EndTime TIME, 
	WeekDay TINYINT,
	TutorEmail varchar(40), 
	FOREIGN KEY (TutorEmail) REFERENCES Tutor(Email) ); 
	
4.	Permissions to View
Finally all of the php, html, and image files must have permissions set on the server. 
To do this simply use chmod 755 * to change the permissions to 755, which is the code for anyone to read the file. 

