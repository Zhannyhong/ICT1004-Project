# [Popcorn](http://54.80.39.6/ICT1004-Project/index.php)

## Introduction
Many movie review websites to date are cluttered and over-commercialised. They are often geared towards marketing the latest releases, and upcoming movies. Rotten Tomatoes determines the score of a film based on the averaged reviews of professional film critics. Existing movie-ranking sites are also skewed heavily towards the opinions of men, including IMDB where men often make up over 70 per cent of the voters for any film. There currently lacks a site for like-minded people and avid movie watchers to share their thoughts and opinions on the show they recently watched.

## Solution and Purpose
The Popcorn movie review website is designed to be a simple-to-use website and boasts a clean user interface. As a non-profit, non-commercialised platform without ads, the website will serve solely as a candid avenue for people to openly rate and share their opinions and thoughts on movies they have enjoyed or did not enjoy. Users are also able to conveniently view the movie information on the website along with its reviews from other movie fans.


## System Design
The website was built using HTML5, CSS, PHP 7, Bootstrap 4.4.1, jQuery 3.4.1, Font Awesome v5, and JavaScript. MySQL Workbench was used for the website database.

The access rights for different types of users are listed below.

### None-logged in Users
None-logged in users will be able to access to all the following functions or pages below:

- Home
  - Landing page of the website
  - Contains two carousels of the movies sorted by top rated and latest movies respectively
  - Contains a grid view of all the movies
  
- User Registration
  - For users to register a new account to leave a review
  
- User Login
  - For users who have an account to log in to the website
  
- Movie Details & Reviews
  - Movie info (name, actors, genre, description, length, maturity rating, etc.)
  - All user reviews for the movie
  - Average rating out of five
  
- About Us
  - Read the purpose of the website
  - Meet the team members who contributed to the website

- Navigation Menu
  - Brings the user to the desired page
  - Search box to allow users to search for their desired movie

### Logged in Users
Logged in users will be able to access all of the functions and pages that the none-logged in users are able to access but with additional functions and pages.

- Profile
  - View profile picture, username, and email
  - Edit user information (username, password, profile picture)
  - View all the reviews posted by the user logged in account, with the below functionalities
    - Delete review
    - Update review
  
- Post Review
  - On the movie page, a user who is logged in will be able to 
    - Post review
    - Delete an existing review that was written by the user
    - Update an existing review that was written by the user

