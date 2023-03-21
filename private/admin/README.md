# Tiger Admin
Internal admin panel created for managing an ROTC organization. Made using Material Dashboard as a HTML/CSS template. All functionalities in vanilla PHP.

## Features List
* Login/Registration System
  + Changing passwords
* CRUD Operations
  + Personnel
    - Edit user information including rank, unit, and position. 
  + Attendance Reports
    - Create attendance reports for PT/Lab and analyze percentages.
  + Assessments (Physical, Land Navigation, BRM, etc...)
    - Calculate PT scores, height/weight compositions, and display which personnel are failing in which areas.

* Weather Reports using weather.gov API
  + Use the weather.gov API to retrieve weather reports and return them in a tabled format.
* Merge PDF using personnel data
  + Generate a batch PDF file containing selected personnel data. PDF files must be created using form fields listed in the database and will be auto filled based on those fields.
  + A list of common PDF's can be configured, and their form fields can be added to the database.
  + Options for alternate form fields, for instance so that the "full name" value will be returned to multiple different form fields in different forms.
  + Unlock locked PDF files.

## Feature Images 
#### (This is not an all inclusive list, some CRUD operations were omitted)
### Merge PDF
![image](https://user-images.githubusercontent.com/46579169/226505606-c2e8dba7-3f61-43ba-ba05-af0d81aa1522.png)
### Logging In
![image](https://user-images.githubusercontent.com/46579169/226503640-8b96ed28-4462-485a-a7f5-67ebbc0b8ce8.png)
### Dashboard
![image](https://user-images.githubusercontent.com/46579169/226503845-03237773-240c-49d0-9ffe-7be767cf846f.png)
### View Users
![image](https://user-images.githubusercontent.com/46579169/226504110-98cba9f5-b943-44ee-ad70-7e4e51e1450b.png)
### Managing Users
![image](https://user-images.githubusercontent.com/46579169/226504447-c97700d1-209c-490c-bf9b-1952d95539fc.png)
### Managing Attendance
![image](https://user-images.githubusercontent.com/46579169/226504559-0827bc86-ec0b-471d-9b4c-ff7371096b06.png)
### Reading Assessment Data
![image](https://user-images.githubusercontent.com/46579169/226505349-13496e9a-0581-4c23-b15a-a1b88c616d29.png)
### Weather Forecasts Creation
![image](https://user-images.githubusercontent.com/46579169/226505456-7a05246a-e577-4a29-ab77-9fe7a64719ae.png)


