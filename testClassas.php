 <?php
$Users = clsUser::Find("hfrtcukur@gmail.com");
if($Users->VerifyEmail())
    echo "Success\n";
else
    echo "Filed\n";
//  echo  'ID: ' . $user->ID() . ' username: ' . $user->Username() . ' email: ' . $user->Email() . ' Password: ' . $user->Password() . ' Token: ' . $user->Toke()  .' Role: ' . $user->Role() . ' Active ' . $user->Active() . ' Image: ' . $user->Image() . ' Background Image: ' . $user->BackgroundImage() . ' \n';  
$Op = clsUser::Update("Ali Noor", "hussein.ahmed.al.mazhani@gmail.com", "uploads/image_user/main_image.jpg", "uploads/image_user/default_image.jpg");
// if ($Op == enSaveIntoDB::SucceedSave) {
//     echo "Updated\n";
// } else
//     echo "Fill Update\n";
$AllUsers = clsUser::LoadAllUsers();
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
        <?php foreach ($AllUsers as $User): ?>
            <?php if ($User->IsAdmin()): ?>
                <tr>
                    <td><?php echo $User->ID(); ?></td>
                    <td><?php echo $User->Username(); ?></td>
                    <td><?php echo $User->Email(); ?></td>
                    <td><?php echo $User->Toke(); ?></td>
                    <td><?php echo $User->Role(); ?></td>
                    <td><?php echo ($User->Active() ? 'true' : 'false'); ?></td>
                    <td><?php echo ($User->IsAdmin() ? 'Yes' : 'No'); ?></td>

                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>

</div>

