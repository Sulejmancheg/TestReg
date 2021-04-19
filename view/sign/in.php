<p style="margin: auto">
    admin: qwe123 <br>
    user: qwerty <br>
    test: test
</p>

<form action="<?= $this->getModel()->getPageUrl() ?>" class="form-signin" method="post">
    <?php if ((!empty($this->model->getMessage()['code'])) && $this->model->getMessage()['code'] == 1){
        echo "<p class='alert-danger' style='font-size: x-small'>- логин должен начинаться с буквы латинского алфавита;<br>
            - может содержать цифры, точки, дефисы буквы латинского алфавита и нижнее подчеркивание;<br>
            - должен состоять из 3 - 16 символов</p>";
        $this->model->setMessage(null);
    } ?>
    <div class="form-label-group">
        <input type="text" name="login" placeholder="Login" id="login" class="form-control" autofocus required>
	<label for="login">Login</label>
    </div>

    <?php if ((!empty($this->model->getMessage()['code'])) && $this->model->getMessage()['code'] == 2){
        echo "<p class='alert-danger' style='font-size: smaller'>- недопустимые символы в пароле: <>' \" ` ; : / { } и пробел</p>";
        $this->model->setMessage(null);
    } ?>
    <div class="form-label-group">
	<input type="password" name="password" placeholder="Password" id="password" class="form-control" required>
	<label for="password">Password</label>
    </div>

	<button type="submit" class="w-100 btn btn-lg btn-primary">Войти</button>
</form>
