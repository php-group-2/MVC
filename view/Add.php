<form method="POST">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control">
    </div>
    <div class="mb-3">
        <label for="desc" class="form-label">Description</label>
        <input type="text" name="desc" id="desc" class="form-control">
    </div>
    <div class="mb-3">
        <label for="dline" class="form-label">Dead Line</label>
        <input type="datetime-local" name="dline" id="dline" class="form-control">
    </div>
    <div class="mb-3">
        <label for="dline" class="form-label">Color</label>
        <select name="color" class="form-select">
            <option selected disabled>Select one color</option>
            <option value="blue">Blue</option>
            <option value="red">Red</option>
            <option value="purple">Purple</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <?php if ($error) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
        </div>
    <?php endif; ?>
</form>