<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body">
    <?php
            extract( $_POST );
   
            if ( !$USERNAME || !$PASSWORD ) {
               validateEmptyFields();
               die();
            }
   
            if ( isset( $NewUser ) ) {
   
                   if ( !( $file = fopen( "password.txt", "a" ) ) ) {  
                         print( "<html><body> Could not open password file </body></html>" );
                         die();
                   }
                   fputs( $file, "$USERNAME,$PASSWORD\n" );
                   userAdded( $USERNAME );
               }
           else {
                   if ( !( $file = fopen( "password.txt", "r" ) ) ) {                        
                      print( "<html><body>Could not open password file</body></html>" );
                      die();              
               }
               
               
               $userVerified = 0;
   
               while ( !feof( $file ) && !$userVerified ) {
   
                  $line = fgets( $file, 255 );
       
                  $line = chop( $line );
   
                  $field = explode( ",", $line, 2 );
     
                      if ( $USERNAME == $field[ 0 ] ) {
                         $userVerified = 1;

                         if ( validatePassword( $PASSWORD, $field )  == true )
                            loginSuccess( $USERNAME );
                         else  
                            wrongPassword();
                     }
               }
     
               fclose( $file );
     
              
               if ( !$userVerified )
                  wrongPassword();
            }
   
            function validatePassword( $userpassword, $filedata )
            {
               if ( $userpassword == $filedata[ 1 ] )
                  return true;
               else
                  return false;          
            }
            function userAdded( $name )
            {
              print( "<title>Thank You</title></head><body>
                      <strong>You have been added to the user list, $name.<br />Please login again to get contact info.</strong>" );
              print("<a href=\"users.php\">Login</a>");
            }
 

           function loginSuccess( $name )
           {
              print( "<title>Thank You</title></head><body>
                      <strong>Permission has been granted, $name. <br />here you go..<br /><br/></strong>" );
               
               
               $contact_list = file("user.txt");
                  foreach($contact_list as $contact){
                      echo nl2br($contact);
                  }
           }
           function wrongPassword()
           {
              print( "<title>Access Denied</title></head><body>
                     <strong>You entered an invalid password.<br />Access has been denied.</strong>" );
           }
 
           function validateEmptyFields()
           {
              print( "<title>Access Denied</title></head> <body>
                     <strong> Please fill in all form fields.<br /></strong>" );
          }
       ?>
    </body>
</html>
