<?php
require_once 'config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    
    $database = new Database();
    $db = $database->getConnection();
    $employee_name = trim($_POST['employee_name']);
    $task_name = trim($_POST['task_name']);
    
    if (!empty($employee_name) && !empty($task_name)) 
    {
        
        try 
        {
            $query = "INSERT INTO tasks (employee_name, task_name) VALUES (:employee_name, :task_name)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':employee_name', $employee_name);
            $stmt->bindParam(':task_name', $task_name);
            
            if ($stmt->execute()) 
            {
                header("Location: index.php?success=1");
            } 
            else
            {
                header("Location: index.php?error=execute");
            }
            
        } 
        catch(PDOException $e) 
        {
            header("Location: index.php?error=database");
        }
        
    } 
    else 
    {
        header("Location: index.php?error=empty");
    }
    
} 
else
{
    header("Location: index.php");
}

exit;
?>