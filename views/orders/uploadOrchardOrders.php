<?php
# including files and classes used to select our data
echo "<link rel='stylesheet' href='../../css/orchard_import_styles.css'>";
include '../../navBar.php';

echo "<form action='uploadOrchardVineInvoices.php' method='post' enctype='multipart/form-data' style='color:white;'>
        Select file to upload:
        <input type='file' name='order' id='fileUpload'>
        <input type='submit' value='Upload File' name='submit'>
      </form>";

?>