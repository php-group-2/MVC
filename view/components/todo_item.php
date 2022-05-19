<li class="list-group-item d-flex align-items-center">
    <input class="form-check-input me-1 checkbox" type="checkbox" <?php if ($task->status) echo "checked" ?> value="<?php echo $task->id ?>" id="check_<?php echo $task->id ?>">
    <span class="<?php echo $task->color ?> ms-1">
        <?php echo $task->title ?> -
        <?php echo $task->description ?>
    </span>
    <span class="ms-2">
        <?php echo $task->deadline ?>
    </span>
    <div class="ms-auto">
        <button type="button" class="d-inline-block btn btn-outline-primary" name="id" value="<?php echo $task->id; ?>" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $task->id ?>">
            <i class="bi bi-pen"></i>
        </button>
        <form action="/delete" method="post" class="d-inline-block">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="d-inline-block btn btn-outline-danger" name="id" value="<?php echo $task->id; ?>">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</li>