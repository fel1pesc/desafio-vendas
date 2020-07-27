<?php


namespace App\Repositories;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class RepositoryBase
{
    protected $model;
    protected $request;

    /**
     * RepositoryBase constructor.
     * @param $model
     * @param $request
     */
    public function __construct(Model $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
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
