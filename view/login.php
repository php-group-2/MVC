<form class="row g-3" method="POST">
    <div class="col-12">
        <label for="inputEmail4" class="form-label">Email</label>
        <input name="email" type="text" class="form-control<?php if (isset($errors['email'][0])) echo " is-invalid" ?>" id="inputEmail4">
        <div class="invalid-feedback">
            <?php echo $errors['email'][0] ?? "" ?>
        </div>
    </div>
    <div class="col-12">
        <label for="inputPassword4" class="form-label">Password</label>
        <input name="password" type="password" class="form-control<?php if (isset($errors['password'][0])) echo " is-invalid" ?>" id="inputPassword4">
        <div class="invalid-feedback">
            <?php echo $errors['password'][0] ?? "" ?>
        </div>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Sign up</button>
    </div>
</form>