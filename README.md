# ChatterBOX



Link for website walk-through(https://www.youtube.com/watch?v=uq21fop80k8)
Another version(https://www.youtube.com/watch?v=GynWhNb_E0Y)
# Features
Create Account: We can create an account via the “Register” button. This button contains a link to the “create_account”.php file which asks for username, email address, and password. Once the register form has been filled, it immediately stores it in the mySQL database in the “users” table. The passwords in the “users” table are hashed for security reasons.
Login: We can also login via the “Login” button. This button contains a link to the “login.php” file which asks for just username and login. Once the login form has been filled, it checks with the “users” table in the database to see if it matches and if it corresponds with what is there, it will give the user access to more features of the website. If a user tries to access the other functions of the website before logging in, the user cannot do anything on the site. If the admin logs in, it will take the user into a different page called “admin.php”.
Post Creation: We can create a post via the “Options” dropdown and clicking “Create a chat”. This button contains a link to the “createPost.php” file. In order to create a post, it will ask for the title of the post, the community the post should be associated with, the description and an image (optional). Once the form is filled and submitted, it saves to the “content” table in the database with the user’s id. It also displays on the index page via the “viewPost.php” file.
Community Creation: We can create a community via the “Options” dropdown and clicking on “Creating a Chatterbox”. This button contains a link to the “create_community.php” file. In order to create a community, it just asks for the community name and description. Once the form is filled and submitted, it saves the information to the “communities” table in the database. It also appears on the Post Creation page in a “communities” dropdown.
Join a Community: We can join a community via the “Options” dropdown and clicking on “Join a Chatterbox”. This button contains a link to the “join_com.php” file. In order to join a community, it has a form which displays the list of communities in a dropdown. Whichever one the user wants to join, they just click submit and it records the user’s id, community id in the “user_communities” table in the database. 
Delete users: In order to delete a user, the admin has to be logged on. Once the admin has logged on, it is possible for the admin to see the list of users and delete any of them if it feels it is in any violation of the terms and services of the website. Once a user has been deleted, it removes all records of the user from all the tables in the database.
Seeing Posts from specific communities: In order to specific posts from specific communities, the user has to click on the “Find Chatters” button. Once the user clicks on this button, it contains a link to the “community_list.php” file which stores all the communities for the user to see. In order to see posts from the communities, it will have to click on the name of the communities and it takes them to the “community_post.php” file which allows the user to see all the posts associated with that specific community.
Comments: In order to comment under any post, the user will have to click on “comment” and this will link them to the “comments.php” file where they can type in a comment text and submit. In order to submit the comments, it will link to the “submitComments.php” file which will not only submit each comment to the “comments” table in the database, but it will also asynchronously update the posts with the most recent comment at the top.
Reset Password: In order to reset a password, the user will have to click on “Forgot Password” in order to change their password. The user also has to be logged in to change their password. When the user clicks on the “Forgot Password” button, it links the user to the “resetPwd.php” file and it will take them to a page where they can easily put in a new password and once they do that, it immediately changes the password information in the “users” table in the database. 
Search Posts: In order to search posts, the user just needs to go to the search bar and look up whatever post they are looking for. 
Tracking: Our implementation of Tracking is only visible on the admin page. In order to track which user just logged in to the website, the most recently logged in user shows up at the top of the admin display which shows who just got on the website.
User Account Information: This just displays the username, the email and the date the user joined. 



![image](https://github.com/yatharth711/myDiscussionForum/assets/67724181/6bad73d2-5f4d-4c3c-bb06-5ae05f9f3d10)

Project Mockup
(https://www.figma.com/file/pPaCJeZIprYt3mzyiqifWS/360-Project?type=design&node-id=0%3A1&mode=design&t=79fMZvh8OCxQJc2Y-1)

Admin login:
Username -> AdminNew
Password -> Passw0rd
