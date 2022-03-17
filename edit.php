<?php 
// Start session 
session_start(); 
 
// Get data from session 
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:''; 
 
// Get status from session 
if(!empty($sessData['status']['msg'])){ 
    $statusMsg = $sessData['status']['msg']; 
    $status = $sessData['status']['type']; 
    unset($_SESSION['sessData']['status']); 
} 
 
// Include and initialize DB class 
require_once 'DB.class.php'; 
$db = new DB(); 
 
// Fetch the user data by ID 
if(!empty($_GET['id'])){ 
    $conditons = array( 
        'where' => array( 
            'id' => $_GET['id'] 
        ), 
        'return_type' => 'single' 
    ); 
    $userData = $db->getRows('users', $conditons); 
} 
 
// Redirect to list page if invalid request submitted 
if(empty($userData)){ 
    header("Location: index.php"); 
    exit; 
} 
 
// Get submitted form data  
$postData = array(); 
if(!empty($sessData['postData'])){ 
    $postData = $sessData['postData']; 
    unset($_SESSION['postData']); 
} 
?>
 <!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body class="m-5 p-5">

<div class="row">
    <div class="col-md-12 head">
        <h5>Edit User</h5>
        
        <!-- Back link -->
        <div class="float-right">
            <a href="index.php" class="btn btn-success"><i class="back"></i> Back</a>
        </div>
    </div>
    
    <!-- Status message -->
    <?php if(!empty($statusMsg)){ ?>
        <div class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
    <?php } ?>
    
    <div class="col-md-12">
        <form method="post" action="action.php" class="form">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo !empty($postData['name'])?$postData['name']:$userData['name']; ?>" required="">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo !empty($postData['email'])?$postData['email']:$userData['email']; ?>" required="">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" value="<?php echo !empty($postData['phone'])?$postData['phone']:$userData['phone']; ?>" required="">
            </div>
            <input type="hidden" name="id" value="<?php echo $userData['id']; ?>"/>
            <input type="hidden" name="action_type" value="edit"/>
            <input type="submit" class="form-control btn-primary" name="submit" value="Update User"/>
        </form>
    </div>
</div>
    </body>