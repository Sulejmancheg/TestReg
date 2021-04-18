<?php

namespace model;

class View {

	private Model $model;
	private string $templatesPath ='view';
	private string $layoutsPath = 'view/layouts';

	public function getModel()
	{
		return $this->model;
	}

	public function __construct(Model $model ) {
		$this->model = $model;
	}

	public  function view(): void {

		$template = sprintf('%s/%s.php', $this->templatesPath, $this->model->getTemplate());

//        if (!file_exists($layout)) {
//            throw new \Exception("Layout '{$layout}' is not exists");
//        } else
            if (!file_exists($template)) {
            throw new \Exception("Template '{$template}' is not exists");
        }

		require_once('view/index/header.php');
		require_once($template);
		require_once('view/index/footer.php');

	}

}