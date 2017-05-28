public function __construct()
 {
  $db = new DB_con();
 }
public function create($fname,$lname,$city)
 {
  mysql_query("INSERT INTO users(first_name,last_name,user_city) VALUES('$fname','$lname','$city')");
 }
 
 public function read()
 {
  return mysql_query("SELECT * FROM users");
 }
 
 public function delete($id)
 {
  mysql_query("DELETE FROM users WHERE user_id=".$id);
 }
 
 public function update($fname,$lname,$city,$id)
 {
  mysql_query("UPDATE users SET first_name='$fname', last_name='$lname', user_city='$city' WHERE user_id=".$id);
 }