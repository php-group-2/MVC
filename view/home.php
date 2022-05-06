<style>
    ul {
        list-style-type: none;
    }
</style>

<h2>Todo List:</h2>
<ul>
    <?php foreach ($todo as $key => $value) { ?>
        <li>
            <div class="form-check">
                <input class="form-check-input checkbox" <?php if ($value['status']) echo "checked" ?> type="checkbox" value="<?php echo $value['id'] ?>" id="check_<?php echo $value['id'] ?>">
                <label class="form-check-label" for="flexCheckDefault">
                    <a href="/?<?php echo "id={$value['id']}" ?>">
                        <?php echo $value['task'] ?>
                    </a>
                </label>
            </div>
        </li>
    <?php } ?>
</ul>

<script>
    $(document).ready(function() {
        $(".checkbox").change(function() {
            id = $(this).val();
            status = $(this).is(":checked");
            $.post("/", {
                id,
                status
            });
        })
    });
</script>