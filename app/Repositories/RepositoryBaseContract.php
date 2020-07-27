<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

abstract class RepositoryBaseContract
{
    protected $model;

    /**
     * RepositoryBaseContract constructor.
     * @param $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function criar(array $objeto)
    {
        $classeNome = get_class($this->model);
        $obj = new $classeNome();

        $obj->fill($objeto);

        $obj->save();

        return $obj;
    }

    public function deletarPorId($id)
    {
        $obj = $this->model->find($id);

        if ($obj == null)
            return false;

        return $obj->delete();
    }

    public function obterPorId($id)
    {
        return $this->model->find($id);
    }

    public function obterTodos()
    {
        return $this->model->get();
    }
}
