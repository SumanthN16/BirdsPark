<?php

if(isset($_GET['action'])){
    $function=$_GET['action'];
}else $function='';

switch($function){

    case 'add_bird':
        add_bird();
        break;

    case 'Deletebird':
        Deletebird();
        break;

    case 'Editbird':
        Editbird();
        break;    

    case 'add_blog':
        add_blog();
        break;

    case 'DeleteBlog':
        DeleteBlog();
        break;

    case 'EditBlog':
        EditBlog();
        break;

    default :
    echo 'no function';
       
}

function add_bird(){
    include('db_connect.php');
    
        
        $Kingdom=$_POST["Kingdom"];
        $Phylum=$_POST["Phylum"];
        $Class=$_POST["Class"];
        $Order=$_POST["Order"];
        $Family=$_POST["Family"];
        $Genus=$_POST["Genus"];
        $Species=$_POST["Species"];
        
        $allowed = array('jpg','png','jpeg','gif');
        $filename = $name ."_" . $_FILES["fileDoc"]["name"];
        $filetype = $_FILES["fileDoc"]["type"];
        $filesize = $_FILES["fileDoc"]["size"];
        $temp_name = $_FILES["fileDoc"]["tmp_name"];
        $uploadTo = "assets/images/background/"; 

        if(!file_exists($_FILES['fileDoc']['tmp_name']) || !is_uploaded_file($_FILES['fileDoc']['tmp_name'])) {
            $insert="INSERT INTO `tbl_bird`(`Kingdom`, `Phylum`, `Class`, `B_Order`, `Family`, `Genus`, `Species`, `Image`) 
            VALUES  ('$Kingdom','$Phylum','$Class','$Order','$Family','$Genus','$Species','')";
            $result=mysqli_query($conn,$insert);
            if(!$result){
                // echo "0";                    
                echo "<script>location.href='add_bird.php';alert('Something went wrong !!');</script>";
            }else{                                                   
                echo "<script> location.href='add_bird.php';alert('Added Successfully..');</script>";                
            }  
        }
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($ext, $allowed)){
            die("<script>location.href='add_bird.php';alert('Only jpg, gif, and png files are allowed.');</script>");
            //echo "<script>location.href='./Form1.html';alert('Only .docx, .doc .pdf formats allowed to a max size of 5 MB');</script>";
        } 
    
        // Verify file size - 5MB maximum
        $maxsize = 1 * 1024 * 1024;
        if($filesize > $maxsize)
        { 
            die("<script>location.href='add_bird.php';alert('File size is larger than the allowed limit.');</script>");
            //echo "<script>location.href='./Form1.html';alert('File size is larger than the allowed limit.');</script>";
        }
    
        // Verify MYME type of the file
        if(in_array($ext, $allowed)){
            // Check whether file exists before uploading it
                                           
            $insert="INSERT INTO `tbl_bird`(`Kingdom`, `Phylum`, `Class`, `B_Order`, `Family`, `Genus`, `Species`, `Image`) 
            VALUES  ('$Kingdom','$Phylum','$Class','$Order','$Family','$Genus','$Species','$filename')";
            $result=mysqli_query($conn,$insert);
            if(!$result){
                // echo "0";                    
                echo "<script>location.href='add_bird.php';alert('Something went wrong !!');</script>";
            }else{
                if(copy($temp_name, $uploadTo.$filename)){                                      
                    echo "<script> location.href='add_bird.php';alert('Added Successfully..');</script>";
                }
            }                            
        } else{
            echo "<script>alert('There was a problem uploading your file. Please try again');</script>";
        }
    }

    

function Deletebird(){
    include('db_connect.php');
      
    $key_code=$_GET["key"];
    
    $delet="DELETE FROM `tbl_bird` WHERE Keycode=$key_code";
              //echo $insert;
    $result=mysqli_query($conn,$delet); 
    if($result){
        echo "<script> location.href='view_bird.php'; alert('Bird Deleted Successfully..');</script>"; 
    }else{
        echo "<script> location.href='view_bird.php';  alert('Something went wrong !! Please try again..');</script>";
    } 
}

function Editbird(){
    include('db_connect.php');
      
    $key_code=$_GET["key"];
    $Kingdom=$_POST["Kingdom"];
    $Phylum=$_POST["Phylum"];
    $Class=$_POST["Class"];
    $Order=$_POST["Order"];
    $Family=$_POST["Family"];
    $Genus=$_POST["Genus"];
    $Species=$_POST["Species"];

    $filedelete = $_POST["deleteFile"];
    
    $allowed = array('jpg','png','jpeg','gif');
    $filename = $name ."_" . $_FILES["fileDoc"]["name"];
    $filetype = $_FILES["fileDoc"]["type"];
    $filesize = $_FILES["fileDoc"]["size"];
    $temp_name = $_FILES["fileDoc"]["tmp_name"];
    $uploadTo = "assets/images/background/"; 

    if($filedelete == null && !file_exists($_FILES['fileDoc']['tmp_name'])) {
        $insert="UPDATE `tbl_bird` SET `Kingdom`='$Kingdom',`Phylum`='$Phylum',`Class`='$Class',
        `B_Order`='$Order',`Family`='$Family',`Genus`='$Genus',`Species`='$Species'
            WHERE `Keycode`='$key_code'";
            $result=mysqli_query($conn,$insert);
            if(!$result){
                // echo "0";                    
                echo "<script>location.href='view_bird.php';alert('Something went wrong !!');</script>";
            }else{                                                   
                echo "<script> location.href='view_bird.php';alert('Updated Successfully..');</script>";                
            }  
    }elseif($filedelete == null && file_exists($_FILES['fileDoc']['tmp_name'])){        
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
          if(!in_array($ext, $allowed)){
              die("<script>location.href='view_bird.php';alert('Only jpg, gif, and png files are allowed.');</script>");
              //echo "<script>location.href='./Form1.html';alert('Only .docx, .doc .pdf formats allowed to a max size of 5 MB');</script>";
          } 
      
          // Verify file size - 5MB maximum
          $maxsize = 1 * 1024 * 1024;
          if($filesize > $maxsize)
          { 
              die("<script>location.href='view_bird.php';alert('File size is larger than the allowed limit.');</script>");
              //echo "<script>location.href='./Form1.html';alert('File size is larger than the allowed limit.');</script>";
          }
      
          // Verify MYME type of the file
          if(in_array($ext, $allowed)){
              // Check whether file exists before uploading it
                                             
              $insert="UPDATE `tbl_bird` SET `Kingdom`='$Kingdom',`Phylum`='$Phylum',`Class`='$Class',
              `B_Order`='$Order',`Family`='$Family',`Genus`='$Genus',`Species`='$Species',`Image`='$filename' 
              WHERE `Keycode`='$key_code'";
            //   echo $insert;
              $result=mysqli_query($conn,$insert);
              if(!$result){
                  // echo "0";                    
                  echo "<script>location.href='view_bird.php';alert('Something went wrong !!');</script>";
              }else{
                  if(copy($temp_name, $uploadTo.$filename)){                           
                      echo "<script> location.href='view_bird.php';alert('Updated Successfully..');</script>";
                  }
              }                            
          } else{
              echo "<script>alert('There was a problem uploading your file. Please try again');</script>";
          }
    }elseif(!file_exists($_FILES['fileDoc']['tmp_name']) && $filedelete != null){
        $insert="UPDATE `tbl_bird` SET `Kingdom`='$Kingdom',`Phylum`='$Phylum',`Class`='$Class',
        `B_Order`='$Order',`Family`='$Family',`Genus`='$Genus',`Species`='$Species'
            WHERE `Keycode`='$key_code'";
            $result=mysqli_query($conn,$insert);
            if(!$result){
                // echo "0";                    
                echo "<script>location.href='view_bird.php';alert('Something went wrong !!');</script>";
            }else{                                                   
                echo "<script> location.href='view_bird.php';alert('Updated Successfully..');</script>";                
            }  
    }elseif($filedelete != null && file_exists($_FILES['fileDoc']['tmp_name'])) {
        // echo $filedelete;
        unlink($uploadTo.$filedelete);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
          if(!in_array($ext, $allowed)){
              die("<script>location.href='view_bird.php';alert('Only jpg, gif, and png files are allowed.');</script>");
              //echo "<script>location.href='./Form1.html';alert('Only .docx, .doc .pdf formats allowed to a max size of 5 MB');</script>";
          } 
      
          // Verify file size - 5MB maximum
          $maxsize = 1 * 1024 * 1024;
          if($filesize > $maxsize)
          { 
              die("<script>location.href='view_bird.php';alert('File size is larger than the allowed limit.');</script>");
              //echo "<script>location.href='./Form1.html';alert('File size is larger than the allowed limit.');</script>";
          }
      
          // Verify MYME type of the file
          if(in_array($ext, $allowed)){
              // Check whether file exists before uploading it
                                             
              $insert="UPDATE `tbl_bird` SET `Kingdom`='$Kingdom',`Phylum`='$Phylum',`Class`='$Class',
              `B_Order`='$Order',`Family`='$Family',`Genus`='$Genus',`Species`='$Species',`Image`='$filename' 
              WHERE `Keycode`='$key_code'";
              $result=mysqli_query($conn,$insert);
              if(!$result){
                  // echo "0";                    
                  echo "<script>location.href='view_bird.php';alert('Something went wrong !!');</script>";
              }else{
                  if(copy($temp_name, $uploadTo.$filename)){                                      
                      echo "<script> location.href='view_bird.php';alert('Updated Successfully..');</script>";
                  }
              }                            
          } else{
              echo "<script>alert('There was a problem uploading your file. Please try again');</script>";
          }
    }else{
        echo "<script>location.href='view_bird.php';alert('Something went wrong !!');</script>";
    }    
}


function add_blog(){
    include('db_connect.php');
    
        
        $blog_ttile=$_POST["blog_ttile"];
        $blog_video=$_POST["blog_video"];
        $blog_desc=$_POST["blog_desc"];
        
        $allowed = array('jpg','png','jpeg','gif');
        $filename = $name ."_" . $_FILES["fileDoc"]["name"];
        $filetype = $_FILES["fileDoc"]["type"];
        $filesize = $_FILES["fileDoc"]["size"];
        $temp_name = $_FILES["fileDoc"]["tmp_name"];
        $uploadTo = "assets/images/background/"; 

        if(!file_exists($_FILES['fileDoc']['tmp_name']) || !is_uploaded_file($_FILES['fileDoc']['tmp_name'])) {
            $insert="INSERT INTO `tbl_blog`(`Blog_title`, `Blog_video`, `Blog_img`, `Blog_desc`) 
            VALUES ('$blog_ttile','$blog_video','','$blog_desc')";
            $result=mysqli_query($conn,$insert);
            if(!$result){
                // echo "0";                    
                echo "<script>location.href='add_blog.php';alert('Something went wrong !!');</script>";
            }else{                                                   
                echo "<script> location.href='add_blog.php';alert('Added Successfully..');</script>";                
            }  
        }
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($ext, $allowed)){
            die("<script>location.href='add_blog.php';alert('Only jpg, gif, and png files are allowed.');</script>");
            //echo "<script>location.href='./Form1.html';alert('Only .docx, .doc .pdf formats allowed to a max size of 5 MB');</script>";
        } 
    
        // Verify file size - 5MB maximum
        $maxsize = 1 * 1024 * 1024;
        if($filesize > $maxsize)
        { 
            die("<script>location.href='add_blog.php';alert('File size is larger than the allowed limit.');</script>");
            //echo "<script>location.href='./Form1.html';alert('File size is larger than the allowed limit.');</script>";
        }
    
        // Verify MYME type of the file
        if(in_array($ext, $allowed)){
            // Check whether file exists before uploading it
                                           
            $insert="INSERT INTO `tbl_blog`(`Blog_title`, `Blog_video`, `Blog_img`, `Blog_desc`) 
            VALUES ('$blog_ttile','$blog_video','$filename','$blog_desc')";
            $result=mysqli_query($conn,$insert);
            if(!$result){
                // echo "0";                    
                echo "<script>location.href='add_blog.php';alert('Something went wrong !!');</script>";
            }else{
                if(copy($temp_name, $uploadTo.$filename)){                                      
                    echo "<script> location.href='add_blog.php';alert('Added Successfully..');</script>";
                }
            }                            
        } else{
            echo "<script>alert('There was a problem uploading your file. Please try again');</script>";
        }
    }

    

function DeleteBlog(){
    include('db_connect.php');
      
    $key_code=$_GET["key"];
    
    $delet="DELETE FROM `tbl_blog` WHERE Keycode=$key_code";
              //echo $insert;
    $result=mysqli_query($conn,$delet); 
    if($result){
        echo "<script> location.href='view_blog.php'; alert('bird Deleted Successfully..');</script>"; 
    }else{
        echo "<script> location.href='view_blog.php';  alert('Something went wrong !! Please try again..');</script>";
    } 
}

function EditBlog(){
    include('db_connect.php');
      
    $key_code=$_GET["key"];
    $blog_ttile=$_POST["blog_ttile"];
    $blog_video=$_POST["blog_video"];
    $blog_desc=$_POST["blog_desc"];

    $filedelete = $_POST["deleteFile"];
    
    $allowed = array('jpg','png','jpeg','gif');
    $filename = $name ."_" . $_FILES["fileDoc"]["name"];
    $filetype = $_FILES["fileDoc"]["type"];
    $filesize = $_FILES["fileDoc"]["size"];
    $temp_name = $_FILES["fileDoc"]["tmp_name"];
    $uploadTo = "assets/images/background/"; 

    if($filedelete == null && !file_exists($_FILES['fileDoc']['tmp_name'])) {
        $insert="UPDATE `tbl_blog` SET `Blog_title`='$blog_ttile',`Blog_video`='$blog_video',`Blog_desc`='$blog_desc'
         WHERE `Keycode`='$key_code'";
            $result=mysqli_query($conn,$insert);
            if(!$result){
                // echo $insert;                    
                echo "<script>location.href='view_blog.php';alert('Something went wrong !!');</script>";
            }else{                                                   
                echo "<script> location.href='view_blog.php';alert('Updated Successfully..');</script>";                
            }  
    }elseif($filedelete == null && file_exists($_FILES['fileDoc']['tmp_name'])){        
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
          if(!in_array($ext, $allowed)){
              die("<script>location.href='view_blog.php';alert('Only jpg, gif, and png files are allowed.');</script>");
              //echo "<script>location.href='./Form1.html';alert('Only .docx, .doc .pdf formats allowed to a max size of 5 MB');</script>";
          } 
      
          // Verify file size - 5MB maximum
          $maxsize = 1 * 1024 * 1024;
          if($filesize > $maxsize)
          { 
              die("<script>location.href='view_blog.php';alert('File size is larger than the allowed limit.');</script>");
              //echo "<script>location.href='./Form1.html';alert('File size is larger than the allowed limit.');</script>";
          }
      
          // Verify MYME type of the file
          if(in_array($ext, $allowed)){
              // Check whether file exists before uploading it
                                             
              $insert="UPDATE `tbl_blog` SET `Blog_title`='$blog_ttile',`Blog_video`='$blog_video',`Blog_desc`='$blog_desc',
              `Blog_img`='$filename' WHERE `Keycode`='$key_code'";
              $result=mysqli_query($conn,$insert);
              if(!$result){
                  // echo "0";                    
                  echo "<script>location.href='view_blog.php';alert('Something went wrong !!');</script>";
              }else{
                  if(copy($temp_name, $uploadTo.$filename)){                           
                      echo "<script> location.href='view_blog.php';alert('Updated Successfully..');</script>";
                  }
              }                            
          } else{
              echo "<script>alert('There was a problem uploading your file. Please try again');</script>";
          }
    }elseif(!file_exists($_FILES['fileDoc']['tmp_name']) && $filedelete != null){
        $insert="UPDATE `tbl_blog` SET `Blog_title`='$blog_ttile',`Blog_video`='$blog_video',`Blog_desc`='$blog_desc'
         WHERE `Keycode`='$key_code'";
            $result=mysqli_query($conn,$insert);
            if(!$result){
                // echo "0";                    
                echo "<script>location.href='view_blog.php';alert('Something went wrong !!');</script>";
            }else{                                                   
                echo "<script> location.href='view_blog.php';alert('Updated Successfully..');</script>";                
            }  
    }elseif($filedelete != null && file_exists($_FILES['fileDoc']['tmp_name'])) {
        // echo $filedelete;
        unlink($uploadTo.$filedelete);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
          if(!in_array($ext, $allowed)){
              die("<script>location.href='view_blog.php';alert('Only jpg, gif, and png files are allowed.');</script>");
              //echo "<script>location.href='./Form1.html';alert('Only .docx, .doc .pdf formats allowed to a max size of 5 MB');</script>";
          } 
      
          // Verify file size - 5MB maximum
          $maxsize = 1 * 1024 * 1024;
          if($filesize > $maxsize)
          { 
              die("<script>location.href='view_blog.php';alert('File size is larger than the allowed limit.');</script>");
              //echo "<script>location.href='./Form1.html';alert('File size is larger than the allowed limit.');</script>";
          }
      
          // Verify MYME type of the file
          if(in_array($ext, $allowed)){
              // Check whether file exists before uploading it
                                             
              $insert="UPDATE `tbl_blog` SET `Blog_title`='$blog_ttile',`Blog_video`='$blog_video',`Blog_desc`='$blog_desc',
              `Blog_img`='$filename' WHERE `Keycode`='$key_code'";
              $result=mysqli_query($conn,$insert);
              if(!$result){
                  // echo "0";                    
                  echo "<script>location.href='view_blog.php';alert('Something went wrong !!');</script>";
              }else{
                  if(copy($temp_name, $uploadTo.$filename)){                                      
                      echo "<script> location.href='view_blog.php';alert('Updated Successfully..');</script>";
                  }
              }                            
          } else{
              echo "<script>alert('There was a problem uploading your file. Please try again');</script>";
          }
    }else{
        echo "<script>location.href='view_blog.php';alert('Something went wrong !!');</script>";
    }    
}

?>