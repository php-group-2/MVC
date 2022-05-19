<div class="modal fade" id="modal_<?php echo $task->id ?>" tabindex="-1">
    <form method="POST" action="/update">
        <input type="hidden" name="_method" value="PUT" />
        <input type="hidden" name="id" value="<?php echo $task->id ?>" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?php echo $task->title ?>">
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Description</label>
                        <input type="text" name="desc" id="desc" class="form-control" value="<?php echo $task->description ?>">
                    </div>
                    <div class="mb-3">
                        <label for="dline" class="form-label">Dead Line</label>
                        <input type="datetime-local" name="dline" id="dline" class="form-control" value="<?php if ($task->deadline) echo date("Y-m-d\TH:i:s", strtotime($task->deadline)); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="dline" class="form-label">Color</label>
                        <select name="color" class="form-select">
                            <option <?php if (!$task->color) echo "selected" ?> value="">No color</option>
                            <option <?php if ($task->color === "blue") echo "selected" ?> value="blue">Blue</option>
                            <option <?php if ($task->color === "red") echo "selected" ?> value="red">Red</option>
                            <option <?php if ($task->color === "purple") echo "selected" ?> value="purple">Purple</option>
                        </select>
                    </div>

                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error ?? ''; ?>
                        </div>
                    <?php endif; ?>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>