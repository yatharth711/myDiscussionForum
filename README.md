# ChatterBOX

Welcome to ChatterBOX! This application allows users to create accounts, join communities, and engage in discussions. 

## Website Walk-through
- [Walk-through Video 1](https://www.youtube.com/watch?v=uq21fop80k8)
- [Walk-through Video 2](https://www.youtube.com/watch?v=GynWhNb_E0Y)

## Features

### User Accounts
- **Create Account**: Register via the “Register” button, which links to `create_account.php`. Fill in your username, email, and password. Passwords are securely hashed before being stored in the MySQL database.
- **Login**: Access your account through the “Login” button that links to `login.php`. Enter your username and password to log in. Admins are redirected to `admin.php` upon logging in.

### Community Features
- **Post Creation**: Create a post via the “Options” dropdown and select “Create a chat,” linking to `createPost.php`. Fill out the form with the post title, associated community, description, and an optional image. Posts are saved to the `content` table.
- **Community Creation**: Create a new community through the “Options” dropdown by selecting “Creating a Chatterbox,” which links to `create_community.php`. Enter the community name and description, and the information is stored in the `communities` table.
- **Join a Community**: Use the “Options” dropdown to select “Join a Chatterbox,” linking to `join_com.php`. Choose from a dropdown list of available communities to join, which records your user ID and community ID in the `user_communities` table.

### Admin Features
- **Delete Users**: Admins can delete users if they violate terms of service. This option is available only after logging in as an admin. Deleted users are removed from all database tables.
- **Tracking**: Admins can view the most recently logged-in user at the top of the admin page.

### User Interaction
- **View Posts by Community**: Click on the “Find Chatters” button to access `community_list.php`, where users can see all communities. Select a community to view associated posts in `community_post.php`.
- **Comments**: Comment on posts by clicking “comment,” which takes you to `comments.php`. Submit your comment to be saved in the `comments` table and update the post asynchronously.
- **Search Posts**: Use the search bar to find specific posts quickly.
  
### Account Management
- **Reset Password**: Click on “Forgot Password” while logged in to access `resetPwd.php`. Enter a new password to update the `users` table immediately.
- **User Account Information**: View your username, email, and the date you joined.

![Project Mockup](https://github.com/yatharth711/myDiscussionForum/assets/67724181/6bad73d2-5f4d-4c3c-bb06-5ae05f9f3d10)

## Project Mockup
- [Figma Project Mockup](https://www.figma.com/file/pPaCJeZIprYt3mzyiqifWS/360-Project?type=design&node-id=0%3A1&mode=design&t=79fMZvh8OCxQJc2Y-1)

## Admin Login Credentials
- **Username**: AdminNew  
- **Password**: Passw0rd
