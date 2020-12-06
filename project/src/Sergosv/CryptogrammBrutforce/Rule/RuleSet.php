<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce\Rule;

class RuleSet
{
    private array $repository = [];

    public function add(Cryptorule $rule): void
    {
        $ident = $rule->getIdent();
        if (!isset($this->repository[$ident])) {
            $this->repository[$ident] = $rule;
        }
    }

    public function getAll(): array
    {
        return $this->repository;
    }
}
