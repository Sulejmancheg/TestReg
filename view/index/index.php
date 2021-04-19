<h3 style="margin: auto">
<?php
use model\Auth;
echo 'Добрый день, '.(new Auth($this->model))->getUser().PHP_EOL;
?>
</h3>
