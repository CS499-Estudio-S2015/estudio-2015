# estudio-2015
To prevent recoding, we should probably create a list of To-Do's and individually mark what they are doing.  We can populate this list as needed.  Hopefully this can keep us organized over the next month.  Please feel free to add to this list. 

##DATABASE UPDATES:
* [5/04]
  * ALTER TABLE ea_roles ADD make int;
  * UPDATE ea_roles SET make = 0 WHERE id != 3;
  * UPDATE ea_roles SET make = 15 WHERE id = 3;

* [5/01]
  * ALTER TABLE ea_users ADD major varchar(64);
  * ALTER TABLE ea_users ADD year varchar(32);
  * ALTER TABLE ea_users ADD esl tinyint(1);
* [4/16] 
  * ALTER TABLE ea_users ADD create_date datetime;
* [4/14] 
  * ALTER TABLE ea_appointments ADD req_visit tinyint(1);
  * ALTER TABLE ea_appointments ADD first_visit tinyint(1);
  * ALTER TABLE ea_roles ADD reports int(4);
  * UPDATE ea_roles SET reports = 15 WHERE id = 1;
  * UPDATE ea_roles SET reports = 0 WHERE id != 1;
* [4/12] 
  * ALTER TABLE ea_appointments ADD group_size int(4);

##TO-DO:
####For Frontend:
* ~~[Matt] Add Group Size to appointment details form (page 2 of wizard)~~
* ~~[David] Add Required Visit to appointment details form (page 2 of wizard)~~
* ~~[David] Add First Visit to appointment details form (page 2 of wizard)~~ 
* ~~[Matt] Add corresponding appointment detail columns in database, added JSON code for form serialization~~
* ~~[Matt] Fix formatting issues caused by additional form inputs in appointment details registration panel~~
* ~~[Matt] Fix formatting issues caused by additional form inputs in customer details registration panel~~
* ~~[Matt] move page 3 (customer details panel) of the wizard to the front, add login for all users to this page~~
* ~~[Matt] Add client details (major and year) into client details registration form~~
* ~~[David] Fix page 4 of wizard (confirmation page) to redirect to front page or give login option (we'll decide on this)~~
* [] Modify page 4 of wizard for proper fields (remove address, insert major)
* [] Login page needs to look like an eStudio page
* [] Need to do password validation on customer registration form


####For Backend:
* ~~[Matt] give customers permission to login to backend with correct view/edit permissions~~
* ~~[Matt] Add Link to Reporting Section of Admin Header~~
* ~~[Matt] Switched out Providers for Tutors (cosmetic change only)~~
* ~~[Matt] Remove secretaries (just need to remove the secretary tab in users)~~
* ~~[Matt] Adjust book_time of ea_appointments to write at proper time (currently 6 hours ahead)~~
* ~~[Matt] Remove unnecessary fields like phone number, address, etc. (may be best just to remove view code for now and keep js and database fields. can check up on this after other core improvements are complete)~~
* ~~[] Give admin ability to extend appointment times~~ (already a feature of ea, admin can do in calendar)
* [] Give admin ability to turn off appointment wizard
* [] Need password validation for customer add from admins
* [] Double check edit for customer ability to edit password
* [] Fix form for making appointment from calendar view in backend
* [Matt] Make customer specific page to view their previous appointments and make appointment


####For Reporting Interface:
* [Matt] Adjust reporting queries for new EA database (need major, year, esl)
* ~~[Matt] Divide reportQueries file into different sections so it's not 1000 lines long~~
* ~~[Matt] Refactor reporting methods to eliminate repetitive statements~~
* ~~[Matt] Highlight % change in current reporting (red for - change, green for +)~~
* ~~[Matt] Add a created date column when clients register an account~~
* ~~[Matt] Remove POST forms from historic page and replace with a more dynamic way to view stats~~
