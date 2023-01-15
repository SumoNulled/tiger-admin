<form action="index.php" method="post">
<input required placeholder="Access Code" name="code" type="number" pattern="[0-9]" id="password"  value="" maxlength="4" style="text-align: center;font-size: 40px;-webkit-text-security: disc;" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
<input type="submit" name="submit" hidden />
</form>

<?php
$code = mysqli_real_escape_string($conn, htmlspecialchars(isset($_POST['code'])) ? htmlspecialchars($_POST['code']) : "");
$sql = "SELECT `access_code` FROM `cadets` WHERE `access_code` = '$code'";
$result = Mysql_Query($sql);
$row = Mysql_Fetch($sql);
if (isset($_POST['submit']))
{
  if ($result->num_rows === 0 || $row['access_code'] == "")
  {
    echo("That code does not exist!");
  } else {
    echo "You are signed in, " . Mysql_Select("SELECT username FROM cadets WHERE access_code = '$code'");
    Mysql_Update("UPDATE cadets SET access_code = (access_code + 1) WHERE username = 'Clay'");
  }
}
?>

<?php $country = array("USA", "Canada", "Mexico"); ?>
<select>Select a country
<?php
for ($i = 0; $i < count($country); $i++) {
  echo "<option value='" . $country[$i] . "'> " . $country[$i] . "</option>";
}
?>
</select>

<!DOCTYPE html>
<html>
<head>
  <style>
  table, td, th {
    border: 1px solid #ddd;
    text-align: left;
  }

  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    padding: 15px;
  }
  </style>
</head>
<body>
<?php
$query = "SELECT * FROM cadets";
  display_data($query, array('id', 'username', 'password', 'access_code'), 1);
  //sendMail();
  echo getTableHeads("cadets", array(5, 13,14,15))[0];
?>
</body>
</html>
