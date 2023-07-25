<?php
// Include the API connection file
// If the API connection is essential for your page, use 'require'. Otherwise, you can use 'include'.

require 'components/header.php';

include 'blocks/search/search.php';

require 'blocks/table/table.php'; 



?>

<div id="customer-filterd-table">

</div>



<div id="customer-table">
    <?php echo $tableHtml; ?>
</div>


<?php


//echo out the blocks



require 'components/footer.php';
?>

