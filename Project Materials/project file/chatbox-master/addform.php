<!DOCTYPE html>
<html lang="en">
   <head>
      <title>CHATBOT - iTech</title>
      <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="bootstrap.min.css">
      <style>
         body{ text-align: center; }
      </style>
   </head>
   <body>
      <h1>CHATBOT - iTech</h1>
      <p><a href="view.php" class="btn btn-primary">View</a>
       <a href="index.php" class="btn btn-primary">Chat Now</a></p>
         <h2>Add Chat Data</h2>
         <form action="insert.php" method="post">
            
            <div class="form-group">
               <label for="queries">Queries:</label>
               <div>
                  <input type="text" name="queries" id="queries" class="form-control">
               </div>
            </div>   
            <div class="form-group">
               <label for="replies">Replies:</label>
               <div>
                  <input type="text" name="replies" id="replies" class="form-control">
               </div>
            </div>

            <input type="submit" value="Add" class="btn btn-primary" />
         </form>
      <footer>Chatbot iTech. 2024 All rights reserved.</footer>
   </body>
</html>