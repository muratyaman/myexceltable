Author: Haci Murat Yaman

Environment: XAMPP on Windows 7
Nothing special: regular Apache HTTPD with PHP support enabled
Document root should point to the public folder.
Frontend uses jQuery and Twitter Bootstrap.

===================================================================================================

Simple Spreadsheet

Introduction 

The purpose of this exercise is to design and model a simple spreadsheet. You should spend no 
more than a morning or evening doing this assessment; you are not required to complete it. 

The Spreadsheet 

The application consists of a single spreadsheet containing a small, fixed number of cells; cells can 
contain numerical values or formulae that operate on the values. The spreadsheet has methods that 
allow values to be set and queried. The core application description is as follows: 

• there is a single spreadsheet with 10 rows and 10 columns 
• spreadsheet cells are identified by coordinates, such as (0, 1) and (9, 9) 
• spreadsheet cells may be empty, may contain floating-point values, or may contain a formula 

that operates on a range of cells 

• cells are empty by default 
• empty cells print out with the string value "" (the empty string) but when used in calculations 

have the numerical value 0 (zero) 

Formulae 

Formulae (i.e. calculations) are performed on ranges of cells. Some examples are: 

• SUM: sums all of the numerical values in the given range
• COUNT: returns the number of cells that are not empty in the given range
• MAX: finds the maximum numerical value in the given range (ignoring empty cells)
• MIN: finds the minimum numerical value in the given range (ignoring empty cells)

It is important to note that when a cell containing a formula is printed out, it should print out the result 
of the calculation (i.e. a number) rather than the formula. 

Ranges 

Calculations are done on ranges of cells; ranges are inclusive rectangular regions of the spreadsheet 
that are ranges expressed in the format (x, y), (x2, y2) 

The Task 

Using your favoured programming language, write a spreadsheet application that allows 
spreadsheets to be created with empty, numeric, and formula cells, and then printed with the content 
of the cells being correctly calculated by applying the formula to the spreadsheet. You do not need to
create any UI. Use of the console for simple input and output is perfectly sufficient. Please include a 

README with your solution outlining how the code should be run, and any external dependencies 
that are required to run the code. 

Please email barry@barrysims.com if you have any questions