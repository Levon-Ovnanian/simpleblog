# Simple blog
Hi! <br>
This repository is simple blog which has a minimal of functionality.<br>
So, the main goal for me in this project is to get PHP coding practice and even though `the site functionality is written, but I'M STILL AT THE DOCUMENTING STAGE`.<br>
Please, be lenient on the visual side of blog :)<br>

`!IMPORTANT!` please, do not use this blog for purposes other than informational!<br>
I am not responsible for any damage that may be received when using the source code of this resource

First, about blog administration.<br>
`Functionality for administrators is represented by the following features:`
- main administrator panel with articles and comments view with a limit of 5 articles per page;
  - flexible search functionality on this page (search panel details are described below in the text);
  - deleting, editing of comments and articles;
- users management page;<br>
  `displaying and editing the user's basic data:`
    - data of registration;
    - role (admin or user);
    - status (active, limited, blocked);
    - notifications settings (details are described below in the text);
    - count of user articles and comments;
    - lists of followers and subscriptions;
  
And the short description of the main logical blocks of functionality, presented in order of user interaction:
1. Registration of new user
- basic data matching check:
  - check if nickname or password already used; 
  - check for non empty row and only Latin alphabets and numeric in nickname;
  - email row filtration with function `filter_var($source, FILTER_VALIDATE_EMAIL)` and check for non empty row;
  - string length of password;<br>
  
  If something got wrong you will see a `notification about what was wrong`.<br>
  
  If all are well:
  - hash password is created with the function `password_hash($source, PASSWORD_DEFAULT)`; <br>
  - hash of 200 random bytes of data is calculated to authenticate the session;
  - converts binary 16 bytes data into hexadecimal representation with function `bin2hex()` to use as activation code;

2. Activation<br>
Check your email for new email with successful registration text and `a link to activate your new account`!<br>
After comparing the activation code and user ID received from link your account will be activated :)<br>

3. User settings<br>
Go to user cabinet to:
    - see your rating;<br>
    - see list of your followers and your subscriptions;<br>
    - download your account logo but be shore it has the extension `png` or `jpg`,`jpeg` or `gif` and file size is `less than 1mb` or it         will be rejected;<br>
    - `disable or enable notifications switches:`
      - get email notification if user you are subscribed wrote new article;
      - get email notification if someone left comment on your article page;
      - get email notification if someone subscribed to you;
      - get email notification if someone unsubscribed from you;
  
  4. Create your article<br>
  Create your article and spend time interacting with your readers and getting their opinion from the comments and their ratings of   your article.<br>
  
  5. Communicate<br>
  - `Search panel:`<br>
    `use flexible search functions`<br>
     search by article name/article text/author name sorted by 
      - only with high rating;
      - new articles first;
      - old articles first;
      - only with comments sorted by new articles first;
      - only with comments sorted by old articles first;
  - `Comments:`  
    - all answers on comments will be grouped with 'source' comment;
    - answers on comments will be shifted to the right;
    - the comment that was answered by you will be duplicated in your comment above your text;
    - link to quickly focus on the "original" comment to easily restore the thread of communication;
    - get your notifications if there are new comments under your articles;
  - `Rating:`
    - click on rating icons for show your opinion about an article or someone's comment;
    - if you `mistakenly click on the rating icon`, you can cancel your rating by clicking it again;
  - `Follow authors:`
    - follow authors you interested in and unfollow if there are no activity from them;
    - receive your notifications if there are new articles from the authors you are subscribed to;

  
  
