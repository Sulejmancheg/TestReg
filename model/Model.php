<?php

namespace model;

class Model {
	private string $pageUrl ='http://testreg';
	private null|string $title = null;
	private string $template = 'index';
	private string $layout = 'index';
	private null|string $nickname = null;
	private null|string $message = null;

	public function getPageUrl(): string {
		return $this->pageUrl;
	}

	public function setTitle(string $title ): void {
		$this->title = $title;
	}

	public function getTitle(): ?string
    {
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
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return array|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }





}