<?PHP
include("dbconnection.php");


header("Access-Control-Allow-Origin: *");
if(isset($_POST['id']))

{

  $id = $_POST["id"];
  

  $query="delete from class where id = $id";

  $result=mysqli_query($connection,$query);

if($result)
  {
        echo "Class record is deleted";
  }
else
  {
        echo "Error in Deletion";
  }

    $connection->close();
    exit;

}
else echo "No POST request";


?>