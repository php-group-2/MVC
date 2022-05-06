<h2>Welcome to Home THAT IS VERY AWESOME!</h2>
<ol>
    <?php foreach ($todo as $key => $value) { ?>
        <li>
            <?php
            $status = $value['status'] ? " done" : " not done";
            echo $value['task'] . $status;
            ?>
        </li>
    <?php } ?>
</ol>