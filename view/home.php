<style>
    ul {
        list-style-type: none;
    }

    .red {
        color: red;
    }

    .blue {
        color: blue;
    }

    .purple {
        color: purple;
    }
</style>
<h2>Tasks List:</h2>
<ul>
    <?php foreach ((array) $tasks as $task) { ?>
        <li>
            <div class="form-check">
                <input class="form-check-input checkbox" <?php if ($task->status) echo "checked" ?> type="checkbox" task="<?php echo $task->id ?>" id="check_<?php echo $task->id ?>">
                <label class="form-check-label">
                    <span class="<?php echo $task->color ?>">
                        <?php echo $task->title ?> -
                        <?php echo $task->description ?>
                    </span>
                    <?php echo $task->deadline ?>
                </label>
            </div>
        </li>
    <?php } ?>
</ul>