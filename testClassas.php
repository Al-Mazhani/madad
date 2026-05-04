 <?php
    $Email = "husseinnoor@gmail.com";
    if (clsUser::IsUserExist($Email)) {
        echo "Yes, User Exist" . '<br>';
    }
    

    $user = clsUser::Find($Email);
    if($user->Delete() == SaveResult::Deleted){
        echo "User Deleted successfully";
    }
    else{
        echo "Conn't Delete This User";
    }
    ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <style>
         .table-wrap {
             width: 90%;
             overflow-x: auto;
             margin-top: 20px;
             font-family: Arial;
         }

         .user-table {
             width: 100%;
             border-collapse: collapse;
         }

         .user-table th,
         .user-table td {
             border: 1px solid #ddd;
             padding: 10px;
             text-align: left;
         }

         .user-table th {
             background: #f2f2f2;
         }

         .user-table tr:nth-child(even) {
             background: #fafafa;
         }

         .user-table tr:hover {
             background: #f1f1f1;
         }
     </style>

 </head>

 <body>

 </body>

 </html>
 <div class="table-wrap">
     <table class="user-table">
         <tr>
             <th>ID</th>
             <th>Username</th>
             <th>Email</th>
             <th>Token</th>
             <th>Role</th>
             <th>Active</th>
             <th>Is Admin</th>
         </tr>
         <tr>
             <th><?php echo $user->ID() ?></th>
             <th><?php echo $user->Username() ?></th>
             <th><?php echo $user->Email() ?></th>
             <th><?php echo $user->Toke() ?></th>
             <th><?php echo $user->Role() ?></th>
             <th><?php echo $user->Active() ?></th>
             <th><?php echo $user->IsAdmin() ?></th>

         </tr>
     </table>

 </div>