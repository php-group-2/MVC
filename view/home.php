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
<ul class="list-group">
    <?php foreach ((array) $tasks as $task) {
        include __DIR__ . "/components/todo_item.php";
        include __DIR__ . "/components/edit_todo_modal.php";
    } ?>
</ul>

<script>
    $(function() {
        $(".checkbox").on("change", function() {
            id = $(this).val();
            $.post("/toggle", {
                _method: "PUT",
                id
            }, function(e) {
                console.log(e);
            });
        })
    })
</script>