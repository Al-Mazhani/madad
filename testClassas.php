<?php

   $user = clsAdmin::Find("hfrtcukur@gmail.com");
if (clsAdmin::CanShowAll($user->Permission())) {
  echo "Yes, Can Show All";
} else {
  echo "NO, Not Cam Show All";
}
?>
<!-- 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
  font-family: Arial, sans-serif;
  background: #0f172a;
  color: #e2e8f0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.card {
  background: #1e293b;
  padding: 25px;
  border-radius: 12px;
  width: 320px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.4);
}

h2 {
  margin-bottom: 15px;
}

.grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin: 15px 0;
}

.perm {
  background: #334155;
  padding: 10px;
  border-radius: 8px;
  cursor: pointer;
  display: flex;
  gap: 8px;
  align-items: center;
  transition: 0.2s;
}

.perm:hover {
  background: #475569;
}

.perm input {
  accent-color: #22c55e;
}

.all {
  background: #7c3aed;
}

.result {
  margin-top: 15px;
  font-weight: bold;
  font-size: 18px;
}

#result {
  color: #22c55e;
}
    </style>
</head>

<body>
    <div class="card">
        <form action="" method="get">
        <h2>User Permissions</h2>

        <label class="perm all">
            <input type="checkbox" name="permissions[]" id="allAccess" value="-1">
            All Access (Admin)
        </label>

        <div class="grid">
            <label class="perm">
                <input type="checkbox" name="permissions[]" class="perm-item" value="1">
                Show All
            </label>

            <label class="perm">
                <input type="checkbox"  name="permissions[]" class="perm-item" value="2">
                Add
            </label>

            <label class="perm">
                <input type="checkbox" name="permissions[]" class="perm-item" value="4">
                Delete
            </label>

            <label class="perm">
                <input type="checkbox" name="permissions[]" class="perm-item" value="8">
                Update
            </label>

            <label class="perm">
                <input type="checkbox" name="permissions[]" class="perm-item" value="16">
                Find
            </label>
        </div>

        <div class="result">
              <input type="submit" name="set" value="Set">
        </div>
    </div>
    </form>

  </body>

</html> -->