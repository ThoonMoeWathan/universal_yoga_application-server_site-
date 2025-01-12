<?PHP
include("dbconnection.php");

  
header("Access-Control-Allow-Origin: *");

  $query="delete from class";

  $result=mysqli_query($connection,$query);

if($result)
  {
        echo "All Class records are deleted";
  }
else
  {
        echo "Error in Deletion";
  }

  $query="delete from course";

  $result=mysqli_query($connection,$query);

if($result)
  {
        echo "All Course records are deleted";
  }
else
  {
        echo "Error in Deletion";
  }


$connection->close();


?>