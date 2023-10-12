<?php

if (isset($_GET['k']) and !empty($_GET['k'])) {
    $suppluyer = $_GET['k'];
}else{
    echo 'no supplier';
}


$jsonData = file_get_contents('jsons/' . $suppluyer . '.json');


// Parse the JSON into an associative array
$data = json_decode($jsonData, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <!-- Add Bootstrap CSS link here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <form method="post" action="demo.php">
        <?php foreach ($data as $category => $items) : ?>
            <h4><?php echo $category; ?> </h4>
            <div class="form-group row">
                <!--                add hiden input named kremidas -->
                <input type="hidden" name="sender" value="<?php echo $suppluyer; ?>">
                <?php if (is_array($items)) : ?>
                    <?php foreach ($items as $itemKey => $itemValue) : ?>
                        <div class="form-group row">
                            <label  class="col-sm-2 col-form-label" for="<?php echo $category . '_' . $itemKey; ?>"><?php echo $itemValue; ?></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="<?php echo $itemKey; ?>" name="<?php echo $category . '[' . $itemKey . ']'; ?>" id="<?php echo $category . '_' . $itemKey; ?>">
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="<?php echo $category; ?>"><?php echo $items; ?></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="<?php echo $category; ?>" name="<?php echo $category; ?>" id="<?php echo $category; ?>">
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Add Bootstrap JS script link here -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
