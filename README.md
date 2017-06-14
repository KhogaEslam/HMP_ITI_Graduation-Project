# Gadgetly, Where you find Gadgets that suits your needs.
##### HMP_ITI_Graduation-Project

This Project was created as Graduation Project for 

## Information Technology Institute ITI
### Intake 37

##### Built Using PHP Laravel @laravel Framework, JQuery, Bootstrap, HTML5, CSS3 and AJAX

### Team Members

##### From Open Source Application Development Track
* Eslam Gamal Khoga (Team Lead) @KhogaEslam
* Merna Shaker Attia @MernaShakerAttia
* Mohammed Magdy @muhammedmagdi
* Mohammed El-Alem @mohamed-elalem
##### From User Interface Development Track
* Khadija Ahmed

### All Needed Files and Installation Steps
* Documentation
* Design Templates
* Wireframes
* Final Screens
* User Stories
* Use Cases
* Class Diagram
* Entity Relationship Diagram
* and more...

Could Be found on the project shared drive folder **_[here](https://goo.gl/OWMv0B)_**

### Hardware Requirements
-	Server with Apache2
-	PHP > 7.0
-	Laravel 5.4
### Steps of Installations
-	Pull the project from github repository 
    - https://github.com/KhogaEslam/HMP_ITI_Graduation-Project
-	[IMPORTANT] Edit in file in this path [/hmp/vendor/risul/laravel-like-comment/src/LikeCommentServiceProvider.php] replace this part of code at line 34-36 with the following snippet >   $this->app->singleton('LaravelLikeComment', function ($app){
     return new LaravelLikeComment;
     });
-	Create Database
-	[REQUIRED] Configure .env file contents Database and APIs [Appendix D]
-	Inside /hmp/resources/ create two folders `img` directory and `banner` directory with suitable permissions [775]
-	Open terminal inside project’s folder
    - Run cmd> composer install
    - Run cmd> php artisan migrate
    - Run cmd> php artisan db:seed 
    - These cmds will install needed packages and will seed needed basic Database contents [Admin user, sample users, Rules, etc.]

