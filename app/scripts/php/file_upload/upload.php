<?php
// Check if the form was submitted
$upload_dir = dirname( __FILE__ ) 
    . DIRECTORY_SEPARATOR
    . '..' . DIRECTORY_SEPARATOR
    . '..' . DIRECTORY_SEPARATOR
    . '..' . DIRECTORY_SEPARATOR
    . 'uploads'.  DIRECTORY_SEPARATOR
    . "score_data"
    . DIRECTORY_SEPARATOR
    . $_FILES["file"]["name"];
    
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0){
        $allowed = array("csv" => "text/csv", "csv" => "application/vnd.ms-excel");
        $filename = $_FILES["file"]["name"];
        $filetype = $_FILES["file"]["type"];
        $filesize = $_FILES["file"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists("upload/" . $_FILES["file"]["name"])){
                echo $_FILES["file"]["name"] . " is already exists.";
                echo_json($_FILES["file"]["name"] . "already exists.");
            } else{
                move_uploaded_file($_FILES["file"]["tmp_name"], $upload_dir);
                echo_json("Your file was uploaded successfully.");
            } 
        } else{            
            echo_json("Error: There was a problem uploading your file. Please try again.");
        }
    } else{
        echo_json("Error: " . $_FILES["file"]["error"] );
    }
}

    function echo_json($message){
        $answer = array( 'answer' => $message);
        $json = json_encode( $answer );
        echo $json;
    }
?>