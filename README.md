#### Wordpress Anonymous Comments
This is a basic little plugin I built to give me anonymous commenting functionality on a website I was working on. It works by performing two actions: 

* * *

##### Adding an "Post anonymously" checkbox to the comment form
This uses the **comment_form_defaults** hook to add a checkbox in after the **comment_field** textarea.

##### Removing the user ID from the comment before it is saved to the database
Using the **preprocess_comment** hook this plugin strips out the user id from the comment before it is inserted into the database. I tried just overwriting the name, but Wordpress quickly repopulated these details by doing a user lookup with the ID. So I remove the user ID and change the name (and email) to "Anonymous".
