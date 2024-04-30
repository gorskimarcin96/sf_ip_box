<?php

namespace App\Report\Company;

readonly class Task
{
    public function __construct(
        private string $title,
        private ?string $description,
        private ?string $sha,
        private ?\DateTimeInterface $started,
        private ?\DateTimeInterface $finished
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSha(): ?string
    {
        return $this->sha;
    }

    public function getStarted(): ?\DateTimeInterface
    {
        return $this->started;
    }

    public function getFinished(): ?\DateTimeInterface
    {
        return $this->finished;
    }
}
