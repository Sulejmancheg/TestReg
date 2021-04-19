<?php

namespace model;

class Model {
	private string $pageUrl ='http://testreg';
	private null|string $title = null;
	private string $template = 'index';
	private string $layout = 'index';
	private null|string $nickname = null;
	private null|array $message = null;

	public function getPageUrl(): string {
		return $this->pageUrl;
	}

	public function setTitle($title ): void {
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTemplate( string $template ): void {
		$this->template = $template;
	}

	public function getTemplate(): string {
		return $this->template;
	}

	public function setLayout( string $layout ): void {
		$this->layout = $layout;
	}

	public function getLayout(): string {
		return $this->layout;
	}

    /**
     * @param null $nickname
     */
    public function setNickname($nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return null
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param array|null $message
     */
    public function setMessage(?array $message): void
    {
        $this->message = $message;
    }

    /**
     * @return array|null
     */
    public function getMessage(): ?array
    {
        return $this->message;
    }





}