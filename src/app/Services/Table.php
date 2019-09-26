<?php

namespace LaravelEnso\Tables\app\Services;

use LaravelEnso\Helpers\app\Classes\Obj;
use LaravelEnso\Tables\app\Services\Table\Builder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

abstract class Table
{
    protected $request;
    protected $templatePath;

    public function __construct(array $request = [])
    {
        $this->request = new Obj(json_decode(json_encode($request), true));
    }

    abstract public function query();

    protected function afterCount(QueryBuilder $query)
    {
        return $query;
    }

    public function request()
    {
        return $this->request;
    }

    public function init()
    {
        return (new TemplateCache(
            new Template($this->templatePath())
        ))->get();
    }

    public function data()
    {
        return $this->builder()
            ->data();
    }

    public function fetcher()
    {
        return $this->builder()
            ->fetcher();
    }

    public function templatePath()
    {
        return $this->templatePath;
    }

    private function builder()
    {
        return new Builder(
            $this->request,
            $this->query(),
            $this->afterCount($this->query())
        );
    }
}
